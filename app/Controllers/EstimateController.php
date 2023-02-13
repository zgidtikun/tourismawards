<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ApplicationForm;
use App\Models\Estimate;
use App\Models\UsersStage;
use App\Models\EstimateIndividual;
use App\Models\EstimateScore;
use App\Models\Committees;
use Exception;

class EstimateController extends BaseController
{
    private $estimate;
    private $estInd;
    private $estScr;
    private $stage;
    private $appForm;
    private $commit;
    private $lowcarbon;
    private $myId;

    public function __construct()
    {
        $this->estimate = new Estimate();
        $this->estInd = new EstimateIndividual();
        $this->estScr = new EstimateScore();
        $this->stage = new UsersStage();
        $this->appForm = new ApplicationForm();
        $this->commit = new Committees();
        $this->myId = session()->get('id');

        if (!isset($this->db))
            $this->db = \Config\Database::connect();
    }

    public function setEstimateRequest()
    {

        try {
            $judgeRequest = new \App\Controllers\EstimateRequestController();
            $currentDate = date('Y-m-d H:i:s');
            $duedate = date('Y-m-d H:i:s', strtotime($currentDate . ' + 3 day'));
            $appid = $this->input->getVar('application_id');

            $form = $this->appForm->where('id', $appid)
                ->select('created_by, IFNULL(attraction_name_th,attraction_name_en) place_name', false)
                ->first();

            $judgeRequest->insert_judge_request([
                'app_id' => $appid,
                'judge_id' => $this->myId,
                'user_id' => $form->created_by,
                'status' => 1,
                'date' => date('Y-m-d H:i:s'),
                'duedate' => $duedate,
                'update' => date('Y-m-d H:i:s'),
            ]);

            $this->estimate->where('application_id', $appid)
                ->where('estimate_by', $this->myId)
                ->whereIn('request_status', [0, 4])
                ->set([
                    'request_status' => 1,
                    'request_date' => $currentDate
                ])
                ->update();

            $this->db->query(
                "UPDATE answer a INNER JOIN estimate e ON a.id = e.answer_id
                SET a.status = 3
                WHERE e.application_id = $appid
                    AND e.request_status IN (1,4);"
            );

            $this->stage->where([
                'user_id' => $form->created_by,
                'stage' => 1
            ])
                ->set(['status' => 3, 'duedate' => $duedate])
                ->update();

            $this->estInd->where([
                'application_id' => $appid,
                'estimate_by' => $this->myId
            ])
                ->set(['score_pre' => NULL])
                ->update();

            /************* Mark Edit 02/09/2023 *************/
            $subQuery = $this->db->table('estimate')
                ->select('question_id')
                ->where('application_id', $appid)
                ->where('estimate_by', $this->myId)
                ->where('request_status', 1)
                ->getCompiledSelect();

            $builder = $this->db->table('assessment_group a')
                ->select('a.name')
                ->join('question b', 'a.id = b.assessment_group_id')
                ->join("($subQuery) c", 'b.id = c.question_id')
                ->groupBy('a.id')
                ->get();

            $ass_arr = [];

            foreach ($builder->getResult() as $key => $ass) {
                $str_ass = 'ด้าน ' . $ass->name;
                array_push($ass_arr, $str_ass);
            }

            $assessent = implode(', ', $ass_arr);
            /************* Mark Edit 02/09/2023 *************/

            save_log_activety([
                'module' => 'step_flow_checking',
                'action' => 'application-' . $appid,
                'bank' => 'frontend',
                'user_id' => $this->myId,
                'datetime' => date('Y-m-d H:i:s'),
                'data' => 'กรรมการกดส่งขอข้อมูล Pre-Screen เพิ่มเติม'
            ]);

            set_noti(
                (object) [
                    'user_id' => $form->created_by,
                    'bank' => 'frontend'
                ],
                (object) [
                    'message' => 'มีการขอข้อมูลเพิ่มเติมใน แบบประเมินขั้นต้น (Pre-screen) ' 
                    . $assessent . ' โปรดดูรายละเอียด เพื่อแก้ไขและส่งแบบประเมินอีกครั้ง ภายใน 72 ชั่วโมง',
                    'link' => base_url('awards/pre-screen'),
                    'send_date' => date('Y-m-d H:i:s'),
                    'send_by' => 'คณะกรรมการ'
                ]
            );

            helper('semail');
            send_email_frontend((object)[
                'id' => $form->created_by,
                'judge' => $this->myId,
                'appId' => $appid,
                'assessent' => $assessent
            ], 'estimate-request');

            $result = ['result' => 'success'];
        } catch (\Exception $e) {
            save_log_error([
                'module' => 'estimate_send_request',
                'input_data' => $this->input->getVar(),
                'error_date' => date('Y-m-d H:i:s'),
                'error_msg' => [
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                    'error_code' => $e->getCode(),
                    'error_msg' => $e->getMessage()
                ]
            ]);

            $result = [
                'result' => 'error',
                'message' => ''
                // 'messsage' => $e->getMessage()
            ];
        }

        return $this->response->setJSON($result);
    }

    private function checkExistEstimate($appId,$questionId,$judgeId)
    {
        $estimate = $this->estimate->where([
            'application_id' => $appId,
            'question_id' => $questionId,
            'estimate_by' => $judgeId
        ])
        ->select('id')
        ->first();

        return (object) [
            'result' => empty($estimate) ? true : false,
            'est_id' =>  empty($estimate) ? '' : $estimate->id, 
        ];
    }

    public function draftEstimate()
    {
        try {
            $input = (object) $this->input->getVar();

            save_log_activety([
                'module' => 'estimate_draft',
                'action' => 'estimate_draft_' . $input->target,
                'bank' => 'frontend',
                'user_id' => $this->myId,
                'datetime' => date('Y-m-d H:i:s'),
                'data' => $this->input->getVar()
            ]);

            $data = [];

            $target = $input->target == 'pre-screen' ? 'pre' : 'onsite';

            if (!empty($input->answer_id)) {
                $data['answer_id'] = $input->answer_id;
            }

            if ($input->score != '' && is_numeric($input->score)) {
                $data['score_' . $target] = $input->score;
            } else {
                $data['score_' . $target] = NULL;
            }

            if ($input->tscore != '' && is_numeric($input->tscore)) {
                $data['tscore_' . $target] = $input->tscore;
            } else {
                $data['tscore_' . $target] = NULL;
            }

            if (!empty($input->comment)) {
                $data['comment_' . $target] = $input->comment;
            } else {
                $data['comment_' . $target] = NULL;
            }

            if (!empty($input->note)) {
                $data['note_' . $target] = $input->note;
            } else {
                $data['note_' . $target] = NULL;
            }

            if ($input->score_origin != '' && is_numeric($input->score_origin)) {
                $data['score_' . $target . '_origin'] = $input->score_origin;
            } else {
                $data['score_' . $target . '_origin'] = NULL;
            }

            if (empty($input->est_id)) {
                $cestimate = $this->estimate->where([
                    'estimate_by' => $this->myId,
                    'application_id' => $input->application_id,
                    'question_id' => $input->question_id
                ])
                    ->select('id')
                    ->first();

                if (!empty($cestimate)) {
                    $input->est_id = $cestimate->id;
                    $action = 'update';
                } else {
                    $action = 'create';
                }
            } else {
                $action = 'update';
            }

            if ($input->target == 'pre-screen') {
                if (!empty($input->request_list)) {
                    $data['request_list'] = $input->request_list;
                    $data['request_date'] = $input->request_date;

                    if ($input->request_status != '' && is_numeric($input->request_status)) {
                        $data['request_status'] = $input->request_status;
                    } else {
                        $data['request_status'] = NULL;
                    }
                } else {
                    $data['request_list'] = NULL;
                    $data['request_date'] = NULL;
                    $data['request_status'] = NULL;
                }
            }

            switch ($action) {
                case 'create':
                    
                    $exist = $this->checkExistEstimate($input->application_id,$input->question_id,$this->myId);

                    if($exist->result){
                        $data['application_id'] = $input->application_id;
                        $data['question_id'] = $input->question_id;
                        $data['estimate_by'] = $this->myId;
                        $data['estimate_name'] = session()->get('user');
                        $data['status_pre'] = 1;
                        $data['status_onsite'] = 1;
                        $this->estimate->insert($data);
                        $instId = $this->estimate->getInsertID();
                    } else {
                        $this->estimate->where([
                            'id' => $exist->est_id,
                            'estimate_by' => $this->myId,
                        ])
                        ->set($data)
                        ->update();
                        $instId = $exist->est_id;
                    }

                    $result = [
                        'result' => 'success',
                        'id' => $instId,
                        'by' => $this->myId
                    ];

                    break;
                case 'update':
                    $this->estimate->where([
                        'id' => $input->est_id,
                        'estimate_by' => $this->myId,
                    ])
                    ->set($data)
                    ->update();

                    $result = [
                        'result' => 'success',
                        'id' => $input->est_id,
                        'by' => $this->myId
                    ];
                    break;
            }

            $form = $this->appForm->where('id', $input->application_id)
                ->select('created_by')
                ->first();

            $this->stage->where([
                'user_id' => $form->created_by,
                'stage' => $target == 'pre' ? 1 : 2
            ])
                ->set(['status' => 2])
                ->update();
        } catch (Exception $e) {
            save_log_error([
                'module' => 'estimate_draft',
                'input_data' => $this->input->getVar(),
                'error_date' => date('Y-m-d H:i:s'),
                'error_msg' => [
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                    'error_code' => $e->getCode(),
                    'error_msg' => $e->getMessage()
                ]
            ]);

            $result = [
                'result' => 'error',
                'message' => ''
                // 'message' => $e->getMessage()
            ];
        }

        return $this->response->setJSON($result);
    }

    public function setCompleteEstimate()
    {
        try {

            $input = $this->input->getJsonVar('data', false);
            $this->lowcarbon = $input->stage == 1 ? $input->lowcarbon : false;
            $module = 'estimate_' . ($input->stage == 1 ? 'pre_screen' : 'onsite');

            save_log_activety([
                'module' => $module,
                'action' => $module . '_send_sys',
                'bank' => 'frontend',
                'user_id' => $this->myId,
                'datetime' => date('Y-m-d H:i:s'),
                'data' => $input
            ]);

            save_log_activety([
                'module' => 'step_flow_checking',
                'action' => 'application-' . $input->appId,
                'bank' => 'frontend',
                'user_id' => $this->myId,
                'datetime' => date('Y-m-d H:i:s'),
                'data' => 'ส่งผลประเมิน รอบ ' . ($input->stage == 1 ? 'pre_screen' : 'onsite')
            ]);

            $dataEstimate = $this->getJudgeEstimate($input->appId, $this->myId, $input->stage);
            $reEstimate = $this->reupdateEstimate($dataEstimate);

            if (!$reEstimate['result']) {
                $reEstimate['result'] = 'error';
                return $this->response->setJSON($reEstimate);
            }

            $individuel = (object) $reEstimate['individuel'];
            unset($input->sourcs);
            unset($reEstimate['individuel']);

            $eRequest = new \App\Controllers\EstimateRequestController();
            $eRequest->complete_request($input->appId, $this->myId);

            $resultIndividuel = $this->setIndividuel($input, $individuel);

            if (!$resultIndividuel->result) {
                $resultIndividuel->result = 'error';
                return $this->response->setJSON($resultIndividuel);
            }

            if ($this->checkFinishEsitmate($input->appId, $input->stage)) {
                $resultEstimate = $this->setFinishEstimate($input->appId, $input->stage);

                $this->sendEstimateResult((object)[
                    'app_id' => $input->appId,
                    'stage' => $input->stage,
                    'pass' => $resultEstimate,
                ]);
            }

            $result = ['result' => 'success'];
        } catch (Exception $e) {
            save_log_error([
                'module' => 'estimate_send_sys',
                'input_data' => $this->input->getVar(),
                'error_date' => date('Y-m-d H:i:s'),
                'error_msg' => [
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                    'error_code' => $e->getCode(),
                    'error_msg' => $e->getMessage()
                ]
            ]);

            $result = [
                'result' => 'error',
                'message' => ''
                // 'message' => $e->getMessage()
            ];
        }

        return $this->response->setJSON($result);
    }

    private function getJudgeEstimate($appId, $judgeId, $stage)
    {
        if ($stage == 1) {
            $where['b.pre_status'] = 1;
            $select = 'a.score_pre_origin score_origin, 
            b.pre_score max_score, 
            c.score_prescreen assign_total';
        } else {
            $where['b.onside_status'] = 1;
            $select = 'a.score_onsite_origin score_origin, 
            b.onside_score max_score,
            c.score_onsite assign_total';
        }

        $where['a.application_id'] = $appId;
        $where['a.estimate_by'] = $judgeId;

        $builder = $this->db->table('estimate a')
            ->join('question b', 'a.question_id = b.id')
            ->join('assessment_group c', 'b.assessment_group_id = c.id')
            ->select(
                "a.id est_id, a.estimate_by,
            $stage stage,
            a.question_id ques_id, 
            b.assessment_group_id assign,
            b.lowcarbon_status, b.weight,
            $select"
            )
            ->where($where)
            ->get();

        $result = $builder->getResult();
        return $result;
    }

    private function reupdateEstimate($estimate)
    {
        try {
            $tescore = $sbscoe = $rsscore = $lcscore = 0;
            $ttescore = $tsbscoe = $trsscore = $tlcscore = 0;
            $stescore = $ssbscore = $srsscore = $slcscore = $sscore = 0;
            $te = $sb = $rs = 0;

            foreach ($estimate as $list) {
                $escore = $cscore = 0;

                if ($list->assign != 4 && $list->score_origin > 0) {
                    $escore = $list->score_origin * $list->weight;
                    $cscore = $escore / $list->max_score;
                }

                if ($list->assign == 1) {
                    $te = $list->assign_total;
                    $ttescore += $list->max_score;
                    $tescore += $escore;
                } elseif ($list->assign == 2) {
                    $sb = $list->assign_total;
                    $tsbscoe += $list->max_score;
                    $sbscoe += $escore;
                } elseif ($list->assign == 3) {
                    $rs = $list->assign_total;
                    $trsscore += $list->max_score;
                    $rsscore += $escore;
                } elseif ($list->assign == 4) {
                    if ($this->lowcarbon) {
                        $tlcscore += $list->score_origin;
                        $lcscore += $list->score_origin;
                    }
                }

                if ($list->stage == 1) {
                    $update['score_pre'] = $escore;
                    $update['tscore_pre'] = $cscore;
                    $update['status_pre'] = 3;
                    $update['request_status'] = 3;
                } else {
                    $update['score_onsite'] = $escore;
                    $update['tscore_onsite'] = $cscore;
                    $update['status_onsite'] = 3;
                }

                $this->estimate->where('id', $list->est_id)
                    ->set($update)
                    ->update();
            }

            if ($tescore > 0) {
                $stescore = ($tescore * $te) / $ttescore;
            }

            if ($sbscoe > 0) {
                $ssbscore = ($sbscoe * $sb) / $tsbscoe;
            }

            if ($rsscore > 0) {
                $srsscore = ($rsscore * $rs) / $trsscore;
            }

            if ($lcscore > 0) {
                $slcscore = $lcscore;
            }

            $sscore = $stescore + $ssbscore + $srsscore;

            $result = [
                'result' => true,
                'individuel' => [
                    'score_te' => $stescore,
                    'score_sb' => $ssbscore,
                    'score_rs' => $srsscore,
                    'score_tt' => $sscore,
                    'lowcarbon' => $slcscore
                ]
            ];

            return $result;
        } catch (Exception $e) {
            save_log_error([
                'module' => 'estimate_recal',
                'input_data' => $estimate,
                'error_date' => date('Y-m-d H:i:s'),
                'error_msg' => [
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                    'error_code' => $e->getCode(),
                    'error_msg' => $e->getMessage()
                ]
            ]);

            return [
                'result' => false,
                'message' => ''
                // 'message' => $e->getMessage()
            ];
        }
    }

    private function setIndividuel($estimate, $score)
    {
        try {
            $current_datetime = date('Y-m-d H:i:s');

            if ($estimate->stage == 1) {
                $inst_estind['score_pte'] = $score->score_te;
                $inst_estind['score_psb'] = $score->score_sb;
                $inst_estind['score_prs'] = $score->score_rs;
                $inst_estind['score_pre'] = $score->score_tt;
                $inst_estind['pre_send_date'] = $current_datetime;
                $inst_estind['lowcarbon_status'] = $this->lowcarbon ? 1 : 2;
                $inst_estind['lowcarbon_score'] = $this->lowcarbon ? $score->lowcarbon : 0;
            } else {
                $inst_estind['score_ote'] = $score->score_te;
                $inst_estind['score_osb'] = $score->score_sb;
                $inst_estind['score_ors'] = $score->score_rs;
                $inst_estind['score_onsite'] = $score->score_tt;
                $inst_estind['onsite_send_date'] = $current_datetime;
            }

            $existEstInd = $this->estInd->where([
                'application_id' => $estimate->appId,
                'estimate_by' => $this->myId
            ])
                ->countAllResults();

            if ($existEstInd < 1) {
                $inst_estind['application_id'] = $estimate->appId;
                $inst_estind['estimate_by'] = $this->myId;
                $result = $this->estInd->insert($inst_estind);
            } else {
                $result = $this->estInd->where([
                    'application_id' => $estimate->appId,
                    'estimate_by' => $this->myId
                ])
                    ->set($inst_estind)
                    ->update();
            }

            return (object) ['result' => $result];
        } catch (Exception $e) {
            save_log_error([
                'module' => 'estimate_set_individue',
                'input_data' => $this->input->getVar(),
                'error_date' => date('Y-m-d H:i:s'),
                'error_msg' => [
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                    'error_code' => $e->getCode(),
                    'error_msg' => $e->getMessage()
                ]
            ]);

            return (object) [
                'result' => false,
                'message' => ''
                // 'message' => $e->getMessage()
            ];
        }
    }

    private function setFinishEstimate($id, $stage)
    {
        $app = new \Config\App();
        $users = new \App\Models\Users();
        $answer = new \App\Models\Answer();
        $appForm = new  \App\Controllers\ApplicationController();
        $haveLowcarbon = $appForm->checkRequireLowCarbon($id);
        $cJudge = $this->countJudgeEstimate($id, $stage);
        $current_datetime = date('Y-m-d H:i:s');

        if ($stage == 1) {
            $select_sum = 'SUM(score_pte) score_te, SUM(score_psb) score_sb,
                SUM(score_prs) score_rs, SUM(score_pre) score_tt, 
                SUM(lowcarbon_score) score_lc';
        } else {
            $select_sum = 'SUM(score_ote) score_te, SUM(score_osb) score_sb,
                SUM(score_ors) score_rs, SUM(score_onsite) score_tt';
        }

        $sumScr = $this->estInd->where('application_id', $id)
            ->select($select_sum)
            ->first();

        $avg_te = $avg_sb = $avg_rs = $avg_lc = 0;

        if ($sumScr->score_te > 0) {
            $avg_te = $sumScr->score_te / $cJudge->tourism;
        }

        if ($sumScr->score_te > 0) {
            $avg_sb = $sumScr->score_sb / $cJudge->support;
        }

        if ($sumScr->score_rs > 0) {
            $avg_rs = $sumScr->score_rs / $cJudge->respons;
        }

        if ($stage == 1) {
            if ($sumScr->score_lc > 0) {
                $avg_lc = $sumScr->score_lc / $cJudge->lowcarbon;
            }
        }

        $avg_tt = $avg_te + $avg_sb + $avg_rs;

        if ($stage == 1) {
            $inst_avg['score_prescreen_te'] = $avg_te;
            $inst_avg['score_prescreen_sb'] = $avg_sb;
            $inst_avg['score_prescreen_rs'] = $avg_rs;
            $inst_avg['score_prescreen_tt'] = $avg_tt;
            $inst_avg['pre_send_date'] = $current_datetime;
            $inst_avg['lowcarbon_status'] = $haveLowcarbon ? 1 : 2;
            $inst_avg['lowcarbon_score'] = $haveLowcarbon ? $avg_lc : 0;
        } else {
            $inst_avg['score_onsite_te'] = $avg_te;
            $inst_avg['score_onsite_sb'] = $avg_sb;
            $inst_avg['score_onsite_rs'] = $avg_rs;
            $inst_avg['score_onsite_tt'] = $avg_tt;
            $inst_avg['onsite_send_date'] = $current_datetime;
        }

        $existEstScr = $this->estScr->where('application_id', $id)
            ->countAllResults();

        if ($existEstScr < 1) {
            $inst_avg['application_id'] = $id;
            $this->estScr->insert($inst_avg);
        } else {
            $this->estScr->where('application_id', $id)
                ->set($inst_avg)
                ->update();
        }

        $criteria = $stage == 1 ? $app->JudgingCriteriaPre : $app->JudgingCriteriaOnst;
        $pass = $avg_tt >= $criteria ? true : false;

        $form = $this->appForm->where('id', $id)
            ->select(
                'created_by app_of,
                    IFNULL(attraction_name_th,attraction_name_en) place_name',
                false
            )
            ->first();

        $this->stage->where([
            'user_id' => $form->app_of,
            'stage' => $stage
        ])
            ->set(['status' => $pass ? 6 : 7])
            ->update();

        $answer->where('reply_by', $form->app_of)
            ->set(['status' => $pass ? 4 : 0])
            ->update();

        $users->where('id', $form->app_of)
            ->set(['stage' => 3])
            ->update();

        if ($pass && $stage == 1) {
            $existStage = $this->stage->where([
                'user_id' => $form->app_of,
                'stage' => 2,
            ])
                ->countAllResults();

            if ($existStage <= 0) {
                $this->stage->insert([
                    'user_id' => $form->app_of,
                    'stage' => 2,
                    'status' => 1
                ]);
            }
        }

        return $pass;
    }

    private function countJudgeEstimate($id, $stage)
    {
        $select = 'admin_id_tourism tourism,
            admin_id_supporting support,
            admin_id_responsibility respons, 
            admin_id_lowcarbon lowcarbon';

        $cJudge = $this->commit->where([
            'application_form_id' => $id,
            'assessment_round' => $stage
        ])
            ->select($select)
            ->first();

        $ctourism = $csupport = $crespons = $clowcarbon = 1;

        if (!empty($cJudge->tourism)) {
            $tourism = json_decode($cJudge->tourism, true);
            $ctourism = !empty($tourism) ? count($tourism) : 1;
        }

        if (!empty($cJudge->support)) {
            $support = json_decode($cJudge->support, true);
            $csupport = !empty($support) ? count($support) : 1;
        }

        if (!empty($cJudge->respons)) {
            $respons = json_decode($cJudge->respons, true);
            $crespons = !empty($respons) ? count($respons) : 1;
        }

        if (!empty($cJudge->lowcarbon)) {
            $lowcarbon = json_decode($cJudge->lowcarbon, true);
            $clowcarbon = !empty($lowcarbon) ? count($lowcarbon) : 1;
        }

        return (object) [
            'tourism' => $ctourism,
            'support' => $csupport,
            'respons' => $crespons,
            'lowcarbon' => $clowcarbon
        ];
    }

    private function checkFinishEsitmate($id, $stage)
    {
        $count_adm = $this->commit->where([
            'application_form_id' => $id,
            'assessment_round' => $stage
        ])
            ->select('admin_count')->first();

        if ($stage == 1) {
            $count_est = $this->estInd->where(
                "application_id = $id 
                    AND CASE 
                        WHEN lowcarbon_status = 1 
                            AND score_pre IS NOT NULL 
                            AND lowcarbon_score IS NOT NULL
                                THEN TRUE
                        WHEN lowcarbon_status = 2 
                            AND score_pre IS NOT NULL 
                            THEN TRUE 
                        ELSE FALSE 
                    END                    
                ",
                NULL,
                FALSE
            )
                ->countAllResults();
        } else {
            $count_est = $this->estInd->where(
                "application_id = $id 
                AND score_onsite IS NOT NULL",
                NULL,
                FALSE
            )
                ->countAllResults();
        }

        if ($count_est >= $count_adm->admin_count)
            return true;
        else  return false;
    }

    private function sendEstimateResult($data)
    {

        // $form = $this->appForm->where('id',$data->app_id)
        // ->select(
        //     'created_by app_of,
        //     IFNULL(attraction_name_th,attraction_name_en) place_name'
        //     ,false
        // )
        // ->first();

        // if($data->stage == 1){
        //     if($data->pass){
        //         $message_a = $form->place_name.' ได้ทำการส่งแบบประเมินเข้าสู่ระบบ กรุณามอบหมายกรรมการเพื่อประเมินรอบขั้นต้น (Pre-Screen)';                       
        //     } else {
        //         $message_a = $form->place_name.' ได้ทำการส่งแบบประเมินขั้นต้น (Pre-screen) เข้าสู่ระบบ';
        //     }
        // } else {
        //     $message_a = $form->place_name.' ได้ทำการส่งแบบประเมินรอบลงพื้นที่เข้าสู่ระบบ';
        // }

        // set_multi_noti(
        //     get_receive_admin(),
        //     (object) [
        //         'bank' => 'backend'
        //     ],
        //     (object) [
        //         'message'=> $message_a,
        //         'link' => '',
        //         'send_date' => date('Y-m-d H:i:s'),
        //         'send_by' => $form->place_name
        //     ]);

        // helper('semail');
        // send_email_frontend((object)[
        //     'id' => $form->app_of,
        //     'appId' => $data->app_id,
        //     'stage' => $data->stage
        // ],'estimate-complete');
    }

    public function setAwardResut()
    {
        $app = new \Config\App();
        $award = new \App\Models\AwardResult();

        $this->db->table('award_result')->truncate();

        $subQuery = $this->db->table('users_stage us')
            ->select(
                'af.id, af.created_by,          
                af.application_type_id type_id, af.application_type_sub_id sub_id'
            )
            ->join('application_form af', 'us.user_id = af.created_by')
            ->where([
                'us.stage' => 2,
                'us.status' => 6
            ])
            ->getCompiledSelect();

        $score = $this->db->table('estimate_score es')
            ->join('(' . $subQuery . ') ap', 'es.application_id = ap.id')
            ->select(
                'es.application_id app_id, ap.created_by,
                    ap.type_id, ap.sub_id,
                    (es.score_prescreen_tt + es.score_onsite_tt) score_tt'
            )
            ->get();

        foreach ($score->getResult() as $v) {
            $judge = $app->JudgingCriteriaScore;

            if ($v->score_tt >= $judge->ttg->low) {
                $award_s = 1;
                $award_n = 'Thailand Tourism Gold Award';
            } elseif ($v->score_tt >= $judge->tta->low && $v->score_tt <= $judge->tta->max) {
                $award_s = 2;
                $award_n = 'Thailand Tourism Gold Award';
            } elseif ($v->score_tt >= $judge->ttc->low && $v->score_tt <= $judge->ttc->max) {
                $award_s = 3;
                $award_n = 'Thailand Tourism Certificate';
            } else {
                $award_s = 0;
                $award_n = 'No Award';
            }

            $temp = [
                'application_id' => $v->app_id,
                'user_id' => $v->created_by,
                'app_type_id' => $v->type_id,
                'app_type_sub_id' => $v->sub_id,
                'award_persent' => $v->score_tt,
                'award_name' => $award_n,
                'award_type' => $award_s,
                'award_status' => 0,
            ];

            $award->insert($temp);
        }
    }

    public function getAwardResut()
    {
        $gold = [];
        $silver = [];
        $certificate = [];
        $input =  (object) $this->input->getVar();
        $where_type = [1, 2, 3];

        foreach ($where_type as $type) {
            $builder = $this->db->table('award_result ar')
                ->join('application_form af', 'ar.application_id = af.id')
                ->select(
                    "IFNULL(af.attraction_name_th, af.attraction_name_en) place_name,
                    af.address_province province, af.address_no, af.address_road, 
                    af.address_sub_district, af.address_district, af.address_province, 
                    af.address_zipcode, 
                    af.pack_file,
                    IFNULL(af.mobile,'') mobile, 
                    IFNULL(af.other_social,'') web, 
                    IFNULL(af.facebook,'') fb,
                    IFNULL(af.google_map,'') gps",
                    false
                )
                ->where([
                    'app_type_id' => $input->type,
                    'app_type_sub_id' => $input->sub,
                    'award_type' => $type,
                ])
                ->get();

            foreach ($builder->getResult() as $v) {
                $v->address = '';
                $v->address .= !empty($v->address_no) ? $v->address_no : '';
                $v->address .= !empty($v->address_road) ? " $v->address_road" : '';
                $v->address .= !empty($v->address_sub_district) ? " $v->address_sub_district" : '';
                $v->address .= !empty($v->address_district) ? " $v->address_district" : '';
                $v->address .= !empty($v->address_province) ? " $v->address_province" : '';
                $v->address .= !empty($v->address_zipcode) ? " $v->address_zipcode" : '';

                if (!empty($v->pack_file)) {
                    $v->pack_file = json_decode($v->pack_file);
                } else {
                    $v->pack_file = [];
                }

                if ($type == 1) array_push($gold, $v);
                elseif ($type == 2) array_push($silver, $v);
                else array_push($certificate, $v);
            }
        }

        $result = ['gold' => $gold, 'silver' => $silver, 'certificate' => $certificate];
        return $this->response->setJSON($result);
    }
}
