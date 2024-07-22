<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

use App\Models\ApplicationForm;
use App\Models\ApplicationType;
use App\Models\ApplicationTypeSub;

class Report extends BaseController
{
    private $ApplicationForm;
    private $ApplicationType;
    private $ApplicationTypeSub;

    function __construct()
    {
        $this->ApplicationForm = new ApplicationForm;
        $this->ApplicationType = new ApplicationType;
        $this->ApplicationTypeSub = new ApplicationTypeSub;

        ini_set('memory_limit', '6144M');
        ini_set('max_execution_time', '999999');

        // ini_set('post_max_size', '1024M');
        // ini_set('upload_max_filesize', '1024M');
    }

    public function index()
    {
        // $data['type']   = $this->ApplicationType->findAll();

        $data['title']  = 'ส่งออกรายงาน';
        $data['view']   = 'administrator/export/index';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function export($page, $type_id = 1)
    {
        if ($page == 'register') {
            $this->register();
        } else if ($page == 'pre_officer') {
            $this->pre_officer($type_id);
        } else if ($page == 'pre_average') {
            $this->pre_average();
        } else if ($page == 'onsite_average') {
            $this->onsite_average();
        } else if ($page == 'onsite_officer') {
            $this->onsite_officer($type_id);
        } else if ($page == 'summary_scores') {
            $this->summary_scores();
        } else if ($page == 'summary_scores_prescreen') {
            $this->summary_scores_prescreen();
        } else if ($page == 'summary_scores_onsite') {
            $this->summary_scores_onsite();
        } else if ($page == 'suggestion') {
            $this->suggestion();
        } else if ($page == 'lowcarbon') {
            $this->lowcarbon();
        } else if ($page == 'lowcarbon_officer') {
            $this->lowcarbon_officer();
        } else {
            show_404();
        }
    }

    public function register()
    {
        $data['result'] = $this->db->table('application_form AP')
            ->select('AP.*, U.email AS user_email, U.mobile AS user_mobile, ES.score_prescreen_tt, ES.score_onsite_tt')
            ->join('estimate_score ES', 'ES.application_id = AP.id', 'left')
            ->join('users U', 'U.id = AP.created_by')->get()->getResultObject();

        return view('administrator/export/register', $data);
    }

    public function pre_officer($type_id)
    {
        $data['result'] = $this->db->table('estimate ET')
            ->select('ET.*,QU.topic_no ,QU.question_ordering , QU.question, QU.assessment_group_id, AP.code, AP.attraction_name_th, AP.application_type_id, AT.name AS application_type_name, ATS.name AS application_type_sub_name, AP.address_province, QU.pre_score, QU.weight')
            ->join('question QU', 'QU.id = ET.question_id')
            ->join('application_form AP', 'AP.id = ET.application_id')
            ->join('application_type AT', 'AT.id = AP.application_type_id')
            ->join('application_type_sub ATS', 'ATS.id = AP.application_type_sub_id')
            ->where('AP.application_type_id', $type_id)
            ->where("ET.score_pre_origin IS NOT NULL")
            ->orderBy('AP.attraction_name_th ASC, ET.estimate_name ASC, QU.assessment_group_id ASC, QU.topic_no ASC')
            ->get()->getResultObject();

        return view('administrator/export/pre_officer', $data);
    }

    public function pre_average()
    {
        $data['result'] = $this->db->table('application_form AP')
            ->select('AP.id, AP.code, AP.attraction_name_th, AP.attraction_name_th, AT.name AS application_type_name, ATS.name AS application_type_sub_name, AP.address_province, CM.admin_id_tourism, CM.admin_id_supporting, CM.admin_id_responsibility')
            ->join('committees CM', 'CM.application_form_id = AP.id AND CM.assessment_round = 1')
            ->join('application_type AT', 'AT.id = AP.application_type_id')
            ->join('application_type_sub ATS', 'ATS.id = AP.application_type_sub_id')->get()->getResultObject();

        if (empty($data['result'])) {
            show_error_report();
        }
        $count_committees = [];
        foreach ($data['result'] as $key => $value) {
            $estimate = $this->db->table('estimate_score ES')
                ->select('ES.score_prescreen_te, ES.score_prescreen_sb, ES.score_prescreen_rs')
                ->where('application_id', $value->id)->get()->getRowObject();

            $tourism = json_decode($value->admin_id_tourism);
            $supporting = json_decode($value->admin_id_supporting);
            $responsibility = json_decode($value->admin_id_responsibility);
            $count_committees[] = count($tourism);
            $count_committees[] = count($supporting);
            $count_committees[] = count($responsibility);

            $result['result'][$key]['id'] = $value->id;
            $result['result'][$key]['code'] = $value->code;
            $result['result'][$key]['attraction_name_th'] = $value->attraction_name_th;
            $result['result'][$key]['application_type_name'] = $value->application_type_name;
            $result['result'][$key]['application_type_sub_name'] = $value->application_type_sub_name;
            $result['result'][$key]['address_province'] = $value->address_province;
            $result['result'][$key]['estimate'] = $estimate;

            foreach ($tourism as $index => $val) {
                $result['result'][$key]['tourism'][$index] = $this->db->table('estimate_individual ET')
                    ->select('ET.score_pte, ET.score_psb, ET.score_prs, ET.score_pre, U.name, U.surname')
                    ->join('users U', 'U.id = ET.estimate_by')
                    ->where('ET.estimate_by', $val)
                    ->where('ET.application_id', $value->id)->get()->getRowObject();
            }

            foreach ($supporting as $index => $val) {
                $result['result'][$key]['supporting'][$index] = $this->db->table('estimate_individual ET')
                    ->select('ET.score_pte, ET.score_psb, ET.score_prs, ET.score_pre, U.name, U.surname')
                    ->join('users U', 'U.id = ET.estimate_by')
                    ->where('ET.estimate_by', $val)
                    ->where('ET.application_id', $value->id)->get()->getRowObject();
            }

            foreach ($responsibility as $index => $val) {
                $result['result'][$key]['responsibility'][$index] = $this->db->table('estimate_individual ET')
                    ->select('ET.score_pte, ET.score_psb, ET.score_prs, ET.score_pre, U.name, U.surname')
                    ->join('users U', 'U.id = ET.estimate_by')
                    ->where('ET.estimate_by', $val)
                    ->where('ET.application_id', $value->id)->get()->getRowObject();
            }
        }
        $result['count_committees'] = max($count_committees);

        return view('administrator/export/pre_average', $result);
    }

    public function onsite_officer($type_id)
    {
        $data['result'] = $this->db->table('estimate ET')
            ->select('ET.*,QU.topic_no ,QU.question_ordering , QU.question, QU.assessment_group_id, AP.code, AP.attraction_name_th, AP.application_type_id, AT.name AS application_type_name, ATS.name AS application_type_sub_name, AP.address_province, QU.pre_score, QU.weight, QU.onside_score')
            ->join('question QU', 'QU.id = ET.question_id AND QU.assessment_group_id != 4')
            ->join('application_form AP', 'AP.id = ET.application_id')
            ->join('application_type AT', 'AT.id = AP.application_type_id')
            ->join('application_type_sub ATS', 'ATS.id = AP.application_type_sub_id')
            ->where('AP.application_type_id', $type_id)
            ->where("ET.score_onsite_origin IS NOT NULL")
            ->orderBy('AP.attraction_name_th ASC, ET.estimate_name ASC, QU.assessment_group_id ASC, QU.topic_no ASC')
            ->get()->getResultObject();

        return view('administrator/export/onsite_officer', $data);
    }

    public function onsite_average()
    {
        $data['result'] = $this->db->table('application_form AP')
            ->select('AP.id, AP.code, AP.application_type_id, AP.application_type_sub_id, AP.attraction_name_th, AP.attraction_name_th, AT.name AS application_type_name, ATS.name AS application_type_sub_name, AP.address_province, CM.admin_id_tourism, CM.admin_id_supporting, CM.admin_id_responsibility')
            ->join('committees CM', 'CM.application_form_id = AP.id AND CM.assessment_round = 2')
            ->join('application_type AT', 'AT.id = AP.application_type_id')
            ->join('application_type_sub ATS', 'ATS.id = AP.application_type_sub_id')->get()->getResultObject();

        if (empty($data['result'])) {
            show_error_report();
        }
        $count_committees = [];
        foreach ($data['result'] as $key => $value) {
            $estimate = $this->db->table('estimate_score ES')
                ->select('ES.score_onsite_te, ES.score_onsite_sb, ES.score_onsite_rs')
                ->where('application_id', $value->id)->get()->getRowObject();

            $tourism = json_decode($value->admin_id_tourism);
            $supporting = json_decode($value->admin_id_supporting);
            $responsibility = json_decode($value->admin_id_responsibility);
            $count_committees[] = count($tourism);
            $count_committees[] = count($supporting);
            $count_committees[] = count($responsibility);

            $result['result'][$key]['id'] = $value->id;
            $result['result'][$key]['code'] = $value->code;
            $result['result'][$key]['attraction_name_th'] = $value->attraction_name_th;
            $result['result'][$key]['application_type_name'] = $value->application_type_name;
            $result['result'][$key]['application_type_sub_name'] = $value->application_type_sub_name;
            $result['result'][$key]['address_province'] = $value->address_province;
            $result['result'][$key]['estimate'] = $estimate;

            foreach ($tourism as $index => $val) {
                $result['result'][$key]['tourism'][$index] = $this->db->table('estimate_individual ET')
                    ->select('ET.score_ote, ET.score_osb, ET.score_ors, ET.score_onsite, U.name, U.surname')
                    ->join('users U', 'U.id = ET.estimate_by')
                    ->where('ET.estimate_by', $val)
                    ->where('ET.application_id', $value->id)->get()->getRowObject();
            }

            foreach ($supporting as $index => $val) {
                $result['result'][$key]['supporting'][$index] = $this->db->table('estimate_individual ET')
                    ->select('ET.score_ote, ET.score_osb, ET.score_ors, ET.score_onsite, U.name, U.surname')
                    ->join('users U', 'U.id = ET.estimate_by')
                    ->where('ET.estimate_by', $val)
                    ->where('ET.application_id', $value->id)->get()->getRowObject();
            }

            foreach ($responsibility as $index => $val) {
                $result['result'][$key]['responsibility'][$index] = $this->db->table('estimate_individual ET')
                    ->select('ET.score_ote, ET.score_osb, ET.score_ors, ET.score_onsite, U.name, U.surname')
                    ->join('users U', 'U.id = ET.estimate_by')
                    ->where('ET.estimate_by', $val)
                    ->where('ET.application_id', $value->id)->get()->getRowObject();
            }
        }
        $result['count_committees'] = max($count_committees);

        return view('administrator/export/onsite_average', $result);
    }

    public function summary_scores()
    {
        $data['result'] = $this->db->table('application_form AP')
            ->select('AP.*, ES.score_prescreen_tt AS score_prescreen_tt, ES.lowcarbon_score AS lowcarbon_score, ES.score_onsite_tt AS score_onsite_tt, AT.name AS application_type_name, ATS.name AS application_type_sub_name')
            ->join('estimate_score ES', 'ES.application_id = AP.id', 'left')
            ->join('application_type AT', 'AT.id = AP.application_type_id')
            ->join('application_type_sub ATS', 'ATS.id = AP.application_type_sub_id')
            ->join('users_stage US', 'US.user_id = AP.created_by AND US.status >= 6', 'left')
            ->where('US.stage', 2)
            ->orderBy('AP.id', 'desc')->get()->getResultObject();

        return view('administrator/export/summary_scores', $data);
    }

    public function summary_scores_prescreen()
    {
        $data['result'] = $this->db->table('application_form AP')
            ->select('AP.*, ES.score_prescreen_tt AS score_prescreen_tt, ES.lowcarbon_score AS lowcarbon_score, ES.score_onsite_tt AS score_onsite_tt, AT.name AS application_type_name, ATS.name AS application_type_sub_name')
            ->join('estimate_score ES', 'ES.application_id = AP.id', 'left')
            ->join('application_type AT', 'AT.id = AP.application_type_id')
            ->join('application_type_sub ATS', 'ATS.id = AP.application_type_sub_id')
            ->join('users_stage US', 'US.user_id = AP.created_by AND US.status >= 6', 'left')
            ->where('US.stage', 1)
            ->orderBy('AP.id', 'desc')->get()->getResultObject();

        return view('administrator/export/summary_scores_prescreen', $data);
    }

    public function summary_scores_onsite()
    {
        $data['result'] = $this->db->table('application_form AP')
            ->select('AP.*, ES.score_prescreen_tt AS score_prescreen_tt, ES.lowcarbon_score AS lowcarbon_score, ES.score_onsite_tt AS score_onsite_tt, AT.name AS application_type_name, ATS.name AS application_type_sub_name')
            ->join('estimate_score ES', 'ES.application_id = AP.id', 'left')
            ->join('application_type AT', 'AT.id = AP.application_type_id')
            ->join('application_type_sub ATS', 'ATS.id = AP.application_type_sub_id')
            ->join('users_stage US', 'US.user_id = AP.created_by', 'left')
            ->where('US.stage', 2)
            ->orderBy('AP.id', 'desc')->get()->getResultObject();

        return view('administrator/export/summary_scores_onsite', $data);
    }

    public function suggestion()
    {
        $data['result'] = $this->db->table('estimate ET')
            ->select('ET.*,QU.question, QU.assessment_group_id, AP.code, AP.attraction_name_th, AT.name AS application_type_name, ATS.name AS application_type_sub_name, AP.address_province, QU.pre_score, QU.weight, AW.reply, AW.reply_by')
            ->join('question QU', 'QU.id = ET.question_id')
            ->join('answer AW', 'AW.id = ET.answer_id', 'left')
            ->join('application_form AP', 'AP.id = ET.application_id')
            ->join('application_type AT', 'AT.id = AP.application_type_id')
            ->join('application_type_sub ATS', 'ATS.id = AP.application_type_sub_id')->get()->getResultObject();
        // pp(count($data['result']));

        return view('administrator/export/suggestion', $data);
    }

    public function lowcarbon()
    {
        $data['result'] = $this->db->table('application_form AP')
            ->select('AP.*, ES.score_prescreen_rs AS score_prescreen_rs, ES.score_onsite_rs AS score_onsite_rs, ES.lowcarbon_score AS lowcarbon_score, AT.name AS application_type_name, ATS.name AS application_type_sub_name')
            ->join('estimate_score ES', 'ES.application_id = AP.id', 'left')
            ->join('users_stage US', 'US.user_id = AP.created_by', 'left')
            ->join('application_type AT', 'AT.id = AP.application_type_id')
            ->join('application_type_sub ATS', 'ATS.id = AP.application_type_sub_id')
            ->where('US.stage', 1)
            ->where('AP.require_lowcarbon', 1)->where('AP.status', 3)->orderBy('AP.id', 'desc')->get()->getResultObject();

        return view('administrator/export/lowcarbon', $data);
    }

    public function lowcarbon_officer()
    {
        $data['result'] = $this->db->table('estimate ET')
            ->select('ET.*,QU.question, QU.assessment_group_id, AP.code, AP.attraction_name_th, AT.name AS application_type_name, ATS.name AS application_type_sub_name, AP.address_province, QU.pre_score, QU.weight')
            ->join('question QU', 'QU.id = ET.question_id AND QU.assessment_group_id = 4')
            ->join('application_form AP', 'AP.id = ET.application_id')
            ->join('application_type AT', 'AT.id = AP.application_type_id')
            ->join('application_type_sub ATS', 'ATS.id = AP.application_type_sub_id')
            ->where('AP.require_lowcarbon', 1)->where('AP.status', 3)->get()->getResultObject();

        return view('administrator/export/lowcarbon_officer', $data);
    }

    public function export1()
    {
        $data['result'] = $this->db->table('application_form AP')
            ->select('AP.*, U.email AS user_email, U.mobile AS user_mobile')
            ->join('users U', 'U.id = AP.created_by')->get()->getResultObject();

        px($data);
    }

    public function logs($position = 'backend-approve')
    {
        $path = FCPATH . 'logs/' . $position . '/';
        $filename = readFiles($path);

        foreach ($filename as $key => $value) {
            $f = fopen($value, 'r');
            if ($f) {
                echo $value . "<br>";
                $contents = fread($f, filesize($value));
                fclose($f);
                echo nl2br($contents);
            }
            echo "<hr>";
        }
    }
}
