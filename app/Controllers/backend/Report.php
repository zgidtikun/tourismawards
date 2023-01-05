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
    }

    public function index()
    {
        // $data['type']   = $this->ApplicationType->findAll();

        $data['title']  = 'ส่งออกรายงาน';
        $data['view']   = 'administrator/export/index';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function export($page)
    {
        if ($page == 'register') {
            $this->register();
        } else if ($page == 'pre_officer') {
            $this->pre_officer();
        } else if ($page == 'pre_average') {
            $this->pre_average();
        } else if ($page == 'onsite_average') {
            $this->onsite_average();
        } else if ($page == 'onsite_officer') {
            $this->onsite_officer();
        } else if ($page == 'summary_scores') {
            $this->summary_scores();
        } else if ($page == 'suggestion') {
            $this->suggestion();
        } else if ($page == 'lowcarbon') {
            $this->lowcarbon();
        } else {
            show_404();
        }
    }

    public function register()
    {
        $data['result'] = $this->db->table('application_form AP')->select('AP.*, U.email AS user_email, U.mobile AS user_mobile')->join('users U', 'U.id = AP.created_by')->get()->getResultObject();

        return view('administrator/export/register', $data);
    }

    public function pre_officer()
    {
        $data['result'] = $this->db->table('estimate ET')->select('ET.*,QU.question, QU.assessment_group_id, AP.code, AP.attraction_name_th, AT.name AS application_type_name, ATS.name AS application_type_sub_name, AP.address_province, QU.pre_score, QU.weight')->join('question QU', 'QU.id = ET.question_id')->join('application_form AP', 'AP.id = ET.application_id')->join('application_type AT', 'AT.id = AP.application_type_id')->join('application_type_sub ATS', 'ATS.id = AP.application_type_sub_id')->get()->getResultObject();

        // px($data['result']);

        return view('administrator/export/pre_officer', $data);
    }

    public function pre_average()
    {
        $data['result'] = $this->db->table('application_form AP')->select('AP.id, AP.code, AP.attraction_name_th, AP.attraction_name_th, AT.name AS application_type_name, ATS.name AS application_type_sub_name, AP.address_province, CM.admin_id_tourism, CM.admin_id_supporting, CM.admin_id_responsibility')->join('committees CM', 'CM.application_form_id = AP.id AND CM.assessment_round = 1')->join('application_type AT', 'AT.id = AP.application_type_id')->join('application_type_sub ATS', 'ATS.id = AP.application_type_sub_id')->get()->getResultObject();

        // pp($data['result']);
        foreach ($data['result'] as $key => $value) {

            $tourism = json_decode($value->admin_id_tourism);
            $supporting = json_decode($value->admin_id_supporting);
            $responsibility = json_decode($value->admin_id_responsibility);

            $result['result'][$key]['id'] = $value->id;
            $result['result'][$key]['code'] = $value->code;
            $result['result'][$key]['attraction_name_th'] = $value->attraction_name_th;
            $result['result'][$key]['application_type_name'] = $value->application_type_name;
            $result['result'][$key]['application_type_sub_name'] = $value->application_type_sub_name;
            $result['result'][$key]['address_province'] = $value->address_province;

            if (!empty($tourism[0])) {
                $result['result'][$key]['tourism'][1] = $this->db->table('estimate ET')->select('SUM(ET.score_pre) AS score_pre, SUM(ET.tscore_pre) AS tscore_pre, SUM(QU.weight) AS weight, SUM(QU.pre_score) AS pre_score_total')->join('question QU', 'QU.id = ET.question_id')->where('ET.estimate_by', $tourism[0])->where('ET.application_id', $value->id)->where('QU.assessment_group_id', 1)->get()->getRowObject();
            }
            if (!empty($tourism[1])) {
                $result['result'][$key]['tourism'][2] = $this->db->table('estimate ET')->select('SUM(ET.score_pre) AS score_pre, SUM(ET.tscore_pre) AS tscore_pre, SUM(QU.weight) AS weight, SUM(QU.pre_score) AS pre_score_total')->join('question QU', 'QU.id = ET.question_id')->where('ET.estimate_by', $tourism[1])->where('ET.application_id', $value->id)->where('QU.assessment_group_id', 1)->get()->getRowObject();
            }

            if (!empty($supporting[0])) {
                $result['result'][$key]['supporting'][1] = $this->db->table('estimate ET')->select('SUM(ET.score_pre) AS score_pre, SUM(ET.tscore_pre) AS tscore_pre, SUM(QU.weight) AS weight, SUM(QU.pre_score) AS pre_score_total')->join('question QU', 'QU.id = ET.question_id')->where('ET.estimate_by', $supporting[0])->where('ET.application_id', $value->id)->where('QU.assessment_group_id', 2)->get()->getRowObject();
            }
            if (!empty($supporting[1])) {
                $result['result'][$key]['supporting'][2] = $this->db->table('estimate ET')->select('SUM(ET.score_pre) AS score_pre, SUM(ET.tscore_pre) AS tscore_pre, SUM(QU.weight) AS weight, SUM(QU.pre_score) AS pre_score_total')->join('question QU', 'QU.id = ET.question_id')->where('ET.estimate_by', $supporting[1])->where('ET.application_id', $value->id)->where('QU.assessment_group_id', 2)->get()->getRowObject();
            }

            if (!empty($responsibility[0])) {
                $result['result'][$key]['responsibility'][1] = $this->db->table('estimate ET')->select('SUM(ET.score_pre) AS score_pre, SUM(ET.tscore_pre) AS tscore_pre, SUM(QU.weight) AS weight, SUM(QU.pre_score) AS pre_score_total')->join('question QU', 'QU.id = ET.question_id')->where('ET.estimate_by', $responsibility[0])->where('ET.application_id', $value->id)->where('QU.assessment_group_id', 3)->get()->getRowObject();
            }
            if (!empty($responsibility[1])) {
                $result['result'][$key]['responsibility'][2] = $this->db->table('estimate ET')->select('SUM(ET.score_pre) AS score_pre, SUM(ET.tscore_pre) AS tscore_pre, SUM(QU.weight) AS weight, SUM(QU.pre_score) AS pre_score_total')->join('question QU', 'QU.id = ET.question_id')->where('ET.estimate_by', $responsibility[1])->where('ET.application_id', $value->id)->where('QU.assessment_group_id', 3)->get()->getRowObject();
            }
        }

        return view('administrator/export/pre_average', $result);
    }

    public function onsite_officer()
    {
        $data['result'] = $this->db->table('estimate ET')->select('ET.*,QU.question, QU.assessment_group_id, AP.code, AP.attraction_name_th, AT.name AS application_type_name, ATS.name AS application_type_sub_name, AP.address_province, QU.pre_score, QU.weight')->join('question QU', 'QU.id = ET.question_id')->join('application_form AP', 'AP.id = ET.application_id')->join('application_type AT', 'AT.id = AP.application_type_id')->join('application_type_sub ATS', 'ATS.id = AP.application_type_sub_id')->get()->getResultObject();

        return view('administrator/export/onsite_officer', $data);
    }

    public function onsite_average()
    {
        $data['result'] = $this->db->table('application_form AP')->select('AP.id, AP.code, AP.attraction_name_th, AP.attraction_name_th, AT.name AS application_type_name, ATS.name AS application_type_sub_name, AP.address_province, CM.admin_id_tourism, CM.admin_id_supporting, CM.admin_id_responsibility')->join('committees CM', 'CM.application_form_id = AP.id AND CM.assessment_round = 2')->join('application_type AT', 'AT.id = AP.application_type_id')->join('application_type_sub ATS', 'ATS.id = AP.application_type_sub_id')->get()->getResultObject();

        // pp($data['result']);
        foreach ($data['result'] as $key => $value) {

            $tourism = json_decode($value->admin_id_tourism);
            $supporting = json_decode($value->admin_id_supporting);
            $responsibility = json_decode($value->admin_id_responsibility);

            $result['result'][$key]['id'] = $value->id;
            $result['result'][$key]['code'] = $value->code;
            $result['result'][$key]['attraction_name_th'] = $value->attraction_name_th;
            $result['result'][$key]['application_type_name'] = $value->application_type_name;
            $result['result'][$key]['application_type_sub_name'] = $value->application_type_sub_name;
            $result['result'][$key]['address_province'] = $value->address_province;

            if (!empty($tourism[0])) {
                $result['result'][$key]['tourism'][1] = $this->db->table('estimate ET')->select('SUM(ET.score_onsite) AS score_onsite, SUM(ET.tscore_onsite) AS tscore_onsite, SUM(QU.weight) AS weight, SUM(QU.onside_score) AS onside_score_total')->join('question QU', 'QU.id = ET.question_id')->where('ET.estimate_by', $tourism[0])->where('ET.application_id', $value->id)->where('QU.assessment_group_id', 1)->get()->getRowObject();
            }
            if (!empty($tourism[1])) {
                $result['result'][$key]['tourism'][2] = $this->db->table('estimate ET')->select('SUM(ET.score_onsite) AS score_onsite, SUM(ET.tscore_onsite) AS tscore_onsite, SUM(QU.weight) AS weight, SUM(QU.onside_score) AS onside_score_total')->join('question QU', 'QU.id = ET.question_id')->where('ET.estimate_by', $tourism[1])->where('ET.application_id', $value->id)->where('QU.assessment_group_id', 1)->get()->getRowObject();
            }

            if (!empty($supporting[0])) {
                $result['result'][$key]['supporting'][1] = $this->db->table('estimate ET')->select('SUM(ET.score_onsite) AS score_onsite, SUM(ET.tscore_onsite) AS tscore_onsite, SUM(QU.weight) AS weight, SUM(QU.onside_score) AS onside_score_total')->join('question QU', 'QU.id = ET.question_id')->where('ET.estimate_by', $supporting[0])->where('ET.application_id', $value->id)->where('QU.assessment_group_id', 2)->get()->getRowObject();
            }
            if (!empty($supporting[1])) {
                $result['result'][$key]['supporting'][2] = $this->db->table('estimate ET')->select('SUM(ET.score_onsite) AS score_onsite, SUM(ET.tscore_onsite) AS tscore_onsite, SUM(QU.weight) AS weight, SUM(QU.onside_score) AS onside_score_total')->join('question QU', 'QU.id = ET.question_id')->where('ET.estimate_by', $supporting[1])->where('ET.application_id', $value->id)->where('QU.assessment_group_id', 2)->get()->getRowObject();
            }

            if (!empty($responsibility[0])) {
                $result['result'][$key]['responsibility'][1] = $this->db->table('estimate ET')->select('SUM(ET.score_onsite) AS score_onsite, SUM(ET.tscore_onsite) AS tscore_onsite, SUM(QU.weight) AS weight, SUM(QU.onside_score) AS onside_score_total')->join('question QU', 'QU.id = ET.question_id')->where('ET.estimate_by', $responsibility[0])->where('ET.application_id', $value->id)->where('QU.assessment_group_id', 3)->get()->getRowObject();
            }
            if (!empty($responsibility[1])) {
                $result['result'][$key]['responsibility'][2] = $this->db->table('estimate ET')->select('SUM(ET.score_onsite) AS score_onsite, SUM(ET.tscore_onsite) AS tscore_onsite, SUM(QU.weight) AS weight, SUM(QU.onside_score) AS onside_score_total')->join('question QU', 'QU.id = ET.question_id')->where('ET.estimate_by', $responsibility[1])->where('ET.application_id', $value->id)->where('QU.assessment_group_id', 3)->get()->getRowObject();
            }
        }

        return view('administrator/export/onsite_average', $result);
    }

    public function summary_scores()
    {
        $data['result'] = $this->db->table('application_form AP')->select('AP.*, ES.*, AT.name AS application_type_name, ATS.name AS application_type_sub_name')->join('estimate_score ES', 'ES.application_id = AP.id', 'left')->join('application_type AT', 'AT.id = AP.application_type_id')->join('application_type_sub ATS', 'ATS.id = AP.application_type_sub_id')->get()->getResultObject();
        // px($data['result']);

        return view('administrator/export/summary_scores', $data);
    }

    public function suggestion()
    {
        $data['result'] = $this->db->table('estimate ET')->select('ET.*,QU.question, QU.assessment_group_id, AP.code, AP.attraction_name_th, AT.name AS application_type_name, ATS.name AS application_type_sub_name, AP.address_province, QU.pre_score, QU.weight')->join('question QU', 'QU.id = ET.question_id')->join('application_form AP', 'AP.id = ET.application_id')->join('application_type AT', 'AT.id = AP.application_type_id')->join('application_type_sub ATS', 'ATS.id = AP.application_type_sub_id')->get()->getResultObject();
        // px($data['result']);

        return view('administrator/export/suggestion', $data);
    }

    public function lowcarbon()
    {
        $data['result'] = $this->db->table('estimate ET')->select('ET.*,QU.question, QU.assessment_group_id, AP.code, AP.attraction_name_th, AT.name AS application_type_name, ATS.name AS application_type_sub_name, AP.address_province, QU.pre_score, QU.weight')->join('question QU', 'QU.id = ET.question_id')->join('application_form AP', 'AP.id = ET.application_id')->join('application_type AT', 'AT.id = AP.application_type_id')->join('application_type_sub ATS', 'ATS.id = AP.application_type_sub_id')->get()->getResultObject();

        return view('administrator/export/lowcarbon', $data);
    }

    public function export1()
    {
        $data['result'] = $this->db->table('application_form AP')->select('AP.*, U.email AS user_email, U.mobile AS user_mobile')->join('users U', 'U.id = AP.created_by')->get()->getResultObject();

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
