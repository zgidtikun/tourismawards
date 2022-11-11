<?php

namespace App\Controllers;
use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
    {
        $obj_user = new \App\Models\Users();
        $obj_news = new \App\Models\News();
        
        $judge = $obj_user->where([
            'role_id' => 3,
            'status' => 1,
            'status_delete' => 1
        ])
        ->select(
            'CONCAT(name,\' \',surname) fullname, profile, position'
        , false)
        ->limit(5)
        ->findAll();        

        foreach($judge as $val){
            if(empty($val->pofile))
                $val->profile = 'assets/images/unknown_user.jpg';
        }

        $news  = $obj_news->where('publish_end >=',"'".date('Y-m-d H:i:s')."'")
            ->select('id, title, description, image_cover, created_by, publish_start')
            ->orderBy('id','desc')
            ->limit(4)
            ->findAll();
            
        foreach($news as $new){
            $new->publish_start = docDate($new->publish_start,3,'thailand');
        }

        $data = [
            'title' => 'Thailand Tourism Awards',
            '_recapcha' => false,
            '_banner' => true,
            'judge' => json_decode(json_encode($judge),true),
            'news' => json_decode(json_encode($news),true),
            'view' => 'index'
        ];
        return view('template-app',$data);
    }

    public function new()
    {
        $obj = new \App\Models\News();
        $news  = $obj->where('publish_end >=',"'".date('Y-m-d H:i:s')."'")
            ->select('id, title, image_cover, created_by, publish_start')
            ->orderBy('id','desc')
            ->findAll();
            
        foreach($news as $new){
            $new->publish_start = docDate($new->publish_start,3,'thailand');
        }

        $data = [
            'title' => 'ข่าวประชาสัมพันธ์',
            '_recapcha' => false,
            '_banner' => false,
            'news' => $news,
            'view' => 'new'
        ];

        return view('template-app',$data);
    }

    public function new_detail($id)
    {
        $obj = new \App\Models\News();
        $new  = $obj->where('id',$id)
            ->select('id, title, description, image_cover, created_by, 
            publish_start')
            ->first();

        $data = [
            'title' => 'ข่าวประชาสัมพันธ์',
            '_recapcha' => false,
            '_banner' => false,
            'new' => $new,
            'view' => 'new-detail'
        ];

        return view('template-app',$data);
    }

    public function contactus()
    {
        $data = [
            'title' => 'ติดต่อเรา',
            '_recapcha' => false,
            '_banner' => false,
            'view' => 'contact-us'
        ];

        return view('template-app',$data);
    }

    public function sendEmailContact()
    {
        $input = (object) $this->input->getVar();
        $_subject = $input->subject;
        $_from = $input->email;
        $_to = 'zgidtikun@gmail.com';
        $_message = '<p>'.$input->message.'</p>';
        $_message .= '<p>ขอแสดงความนับถือ<br>'.$input->name.'</p>';

        try {
        
            $this->email->setTo($_to);
            $this->email->setFrom($_from);
            $this->email->setSubject($_subject);
            $this->email->setMessage($_message);
            $_status = $this->email->send();
            
            $result = [ 'result' => $_status ? 'success' : 'error' ];
        } catch(\Exception $e) {
            $result = ['result' => 'error', 'message' => $e->getMessage()];
        }
        
        return $this->response->setJSON($result);
    }

    public function judge()
    {
        $obj = new \App\Models\Users();
        $judge = $obj->where([
                'role_id' => 3,
                'status' => 1,
                'status_delete' => 1
            ])
            ->select(
                'CONCAT(name,\' \',surname) fullname, profile, 
                award_type, position'
            , false)
            ->findAll();

        foreach($judge as $val){
            $val->award_type = json_decode($val->award_type,false);

            if(empty($val->pofile))
                $val->profile = 'assets/images/unknown_user.jpg';
        }
        
        $data = [
            'title' => 'คณะกรรมการ',
            '_recapcha' => false,
            '_banner' => false,
            'judge' => $judge,
            'view' => 'judge'
        ];

        return view('template-app',$data);
    }

    public function privacypolicy()
    {
        $data = [
            'title' => 'ข้อกำหนดและเงื่อนไขการใช้งาน',
            '_recapcha' => false,
            '_banner' => false,
            'view' => 'privacy-policy'
        ];

        return view('template-app',$data);

    }

    public function winnerinfo()
    {
        $data = [
            'title' => 'ข้อมูลการประกวดรางวัล',
            '_recapcha' => false,
            '_banner' => false,
            'view' => 'awards-info'
        ];

        return view('template-app',$data);
    }

    public function winneraward()
    {
        $data = [
            'title' => 'WINNER 2023',
            '_recapcha' => false,
            '_banner' => false,
            'view' => 'awards-winner'
        ];

        return view('template-app',$data);
    }

    public function winneraward13()
    {
        $data = [
            'title' => 'ผลงานที่ได้รับรางวัล ปี 2565',
            '_recapcha' => false,
            '_banner' => false,
            'view' => 'awards-winner-13'
        ];

        return view('template-app',$data);

    }

    public function winneraward14()
    {
        $data = [
            'title' => 'ผลงานที่ได้รับรางวัลอุตสาหกรรมท่องเที่ยวไทย ครั้งที่ 14 ปี 2566',
            '_recapcha' => false,
            '_banner' => false,
            'view' => 'awards-winner-14'
        ];

        return view('template-app',$data);

    }

    public function indexBackend()
    {
        $data['title']  = 'สถิติการใช้งาน';
        $data['view']   = 'administrator/dashboard/index';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function error_403()
    {
        return view('errors/html/error_403_c');
    }

    public function error_404()
    {
        return view('errors/html/error_404_c');
    }
}
