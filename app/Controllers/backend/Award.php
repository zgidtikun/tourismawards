<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class Award extends BaseController
{
    public function index()
    {
        $app = new \Config\App();

        $judge = $app->JudgingCriteriaScore;
        pp($judge);

        // if ($persent >= $judge->ttg->low) {
        //     $award_s = 1;
        // } else if ($persent >= $judge->tta->low && $persent <= $judge->tta->max) {
        //     $award_s = 2;
        // } elseif ($persent >= $judge->ttc->low && $persent <= $judge->ttc->max) {
        //     $award_s = 3;
        // } else {
        //     $award_s = 0;
        // }

        $data['result'] = $this->db->table('application_form AP')->select('AP.*, US.stage, US.status AS users_stage_status, US.duedate, ES.score_prescreen_tt, ES.score_onsite_tt')->join('users_stage US', 'US.user_id = AP.created_by AND US.status >= 6', 'left')->join('estimate_score ES', 'ES.application_id = AP.id', 'left')->where('US.stage', 2)->get()->getResultObject();

        px($data['result']);
    }
}
