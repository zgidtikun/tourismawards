<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use CodeIgniter\Files\File;

class News extends BaseController
{
    public function __construct()
    {
        // helper('main');
        // pp(session()->role);
        // if (session()->role == 2) {
        //     return redirect()->to('404');
        // }
    }

    public function index()
    {
        // pp(session()->get());
        $where = [];
        if (!empty($_GET["keyword"])) {
            $where['title'] = $_GET["keyword"];
        }
        $data['result'] = $this->db->table('news')->where($where)->get()->getResultObject();
        $data['category'] = $this->db->table('news_category')->get()->getResultObject();
        $category = [];
        foreach ($data['category'] as $key => $value) {
            $category[$value->id] = $value->name;
        }
        $data['category'] = $category;
        // px($data['category']);

        // Template
        $data['title']  = 'ข่าวประชาสัมพันธ์';
        $data['view']   = 'administrator/news/index';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function add()
    {
        $data['category'] = $this->db->table('news_category')->get()->getResultObject();

        // Template
        $data['title']  = 'ข่าวประชาสัมพันธ์';
        $data['view']   = 'administrator/news/edit';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function edit($id)
    {
        $data['result'] = $this->db->table('news')->where('id', $id)->get()->getRowObject();
        $data['category'] = $this->db->table('news_category')->get()->getResultObject();
        if (empty($data['result'])) {
            return redirect()->to(session()->_ci_previous_url);
        }

        // Template
        $data['title']  = 'ข่าวประชาสัมพันธ์';
        $data['view']   = 'administrator/news/edit';
        $data['ci']     = $this;

        return view('administrator/template', $data);
    }

    public function saveInsert()
    {
        $post = $this->input->getVar();
        $imagefile = $this->input->getFiles('image_cover');
        $img = $imagefile['image_cover'];
        // px($imagefile['image_cover']);

        if (empty($post['status'])) {
            $post['status'] = 0;
        }
        $data = [
            // 'id'            => $post[''],
            'title'         => $post['title'],
            'description'   => $post['description'],
            // 'image_cover'   => $post['image_cover'],
            'category_id'   => $post['category_id'],
            'status'        => $post['status'],
            'created_id'    => session()->id,
            'updated_id'    => session()->id,
            'created_by'    => session()->user,
            'updated_by'    => session()->user,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ];
        $result = $this->db->table('news')->insert($data);
        $insert_id = $this->db->insertID();

        if ($result) {
            if ($img->isValid() && !$img->hasMoved()) {
                $path = FCPATH . 'uploads/news/images/';
                $originalName = $img->getName();
                $extension = $img->guessExtension();
                $newName = genFileName($extension);
                $accept = ['jpg', 'jpeg', 'gif', 'png', 'webp'];
                if (in_array($extension, $accept)) {
                    $img->move($path, $newName);
                    $this->db->table('news')->where('id', $insert_id)->update(['image_cover' => $newName]);
                }
            }
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'บันทึกข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'บันทึกข้อมูลไม่สำเร็จ']);
        }
    }

    public function saveUpdate()
    {
        $post = $this->input->getVar();
        $imagefile = $this->input->getFiles('image_cover');
        $img = $imagefile['image_cover'];

        if ($img->isValid() && !$img->hasMoved()) {
            $path = FCPATH . 'uploads/news/images/';
            $extension = $img->guessExtension();
            $newName = genFileName($extension);
            $accept = ['jpg', 'jpeg', 'gif', 'png', 'webp'];
            if (in_array($extension, $accept)) {
                $img->move($path, $newName);
                $post['image_cover'] = $newName;
                @unlink($path . $post['image_cover_old']);
            }
        } else {
            $post['image_cover'] = $post['image_cover_old'];
        }

        if (empty($post['status'])) {
            $post['status'] = 0;
        }
        $data = [
            // 'id'            => $post[''],
            'title'         => $post['title'],
            'description'   => $post['description'],
            'image_cover'   => $post['image_cover'],
            'category_id'   => $post['category_id'],
            'status'        => $post['status'],
            'publish_start' => $post['publish_start'],
            'publish_end'   => $post['publish_end'],
            // 'created_id'    => session()->id,
            'updated_id'    => session()->id,
            // 'created_by'    => session()->user,
            'updated_by'    => session()->user,
            // 'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ];
        $result = $this->db->table('news')->where('id', $post['insert_id'])->update($data);
        if ($result) {
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'แก้ไขข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'แก้ไขข้อมูลไม่สำเร็จ']);
        }
    }

    public function delete()
    {
        $id = $this->input->getVar('id');
        $image_cover = $this->input->getVar('image_cover');
        $result = $this->db->table('news')->where('id', $id)->delete();
        if ($result) {
            $path = FCPATH . 'uploads/news/images/';
            @unlink($path . $image_cover);
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'ทำการลบข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'ทำการลบข้อมูลไม่สำเร็จ']);
        }
    }

    public function uploadImage()
    {
        $imagefile = $this->input->getFiles('file');
        $img = $imagefile['file'];
        if ($img->isValid() && !$img->hasMoved()) {
            $path = FCPATH . 'uploads/news/images/';
            $extension = $img->guessExtension();
            $newName = genFileName($extension);
            $accept = ['jpg', 'jpeg', 'gif', 'png', 'webp'];
            if (in_array($extension, $accept)) {
                $img->move($path, $newName);
                echo base_url() . '/uploads/news/images/' . $newName;
            }
        }
    }

    public function removeImage()
    {
        $path = $this->input->getVar('path');
        $path = FCPATH . 'uploads/news/images/' . $path;
        if (@unlink($path)) {
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'ทำการลบข้อมูลสำเร็จ']);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'ทำการลบข้อมูลไม่สำเร็จ']);
        }
    }

    public function saveCategory()
    {
        $post = $this->input->getVar();
        $result = $this->db->table('news_category')->insert($post);
        if ($result) {
            $result = $this->db->table('news_category')->get()->getResultObject();
            echo json_encode(['type' => 'success', 'title' => 'สำเร็จ', 'text' => 'บันทึกข้อมูลสำเร็จ', 'data' => $result]);
        } else {
            echo json_encode(['type' => 'error', 'title' => 'ผิดพลาด', 'text' => 'บันทึกข้อมูลไม่สำเร็จ', 'data' => null]);
        }
    }
}
