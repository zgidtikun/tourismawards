<?php

namespace App\Controllers;
use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Amazing Thailand Safety and Health Administration (SHA)',
            '_recapcha' => false,
            '_banner' => true,
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

    public function judge()
    {
        $data = [
            'title' => 'คณะกรรมการ',
            '_recapcha' => false,
            '_banner' => false,
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
