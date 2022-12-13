<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class Award extends BaseController
{
    public function index()
    {
        $app = new \Config\App();

        $judge = $app->JudgingCriteriaScore;
        // pp($judge);

        // if ($persent >= $judge->ttg->low) {
        //     $award_s = 1;
        // } else if ($persent >= $judge->tta->low && $persent <= $judge->tta->max) {
        //     $award_s = 2;
        // } elseif ($persent >= $judge->ttc->low && $persent <= $judge->ttc->max) {
        //     $award_s = 3;
        // } else {
        //     $award_s = 0;
        // }

        $data['result'] = $this->db->table('application_form AP')->select('AP.*,AR.award_persent')->join('award_result AR', 'AR.application_id = AP.id', 'left')->where('AR.award_type', 1)->get()->getResultObject();

        // px($data['result']);
        
        $data['title']  = 'รางวัลยอดเยี่ยม';
        $data['view']   = 'administrator/award/index';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }
}
