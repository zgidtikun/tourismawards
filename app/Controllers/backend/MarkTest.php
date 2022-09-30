<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

use App\Models\Admin;

class MarkTest extends BaseController
{
    public function index()
    {
        pp(session()->get());
        pp(checkPermission([4]));
        px(password_hash('0000', PASSWORD_DEFAULT));
        $model = new Admin();

        $page    = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 20;
        $total   = 200;

        $data = [
            'users' => $model->paginate(3),
            'pager' => $model->pager,
        ];
        px($model->pager);

        $pager = service('pager');
        $pager->setPath('path/for/my-group', 'my-group'); // Additionally you could define path for every group.
        $pager->makeLinks($page, $perPage, $total, 'template_name', 0, 'my-group');
        echo $pager->links();
    }
}
