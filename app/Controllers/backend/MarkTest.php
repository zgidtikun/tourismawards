<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

use App\Models\Admin;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MarkTest extends BaseController
{
    public function index()
    {
        // pp(session()->get());
        // pp(checkPermission([4]));
        // px(password_hash('0000', PASSWORD_DEFAULT));
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

    public function excel()
    {
        $taskModel = new Admin();
        $data['result'] = $taskModel->findAll();
        
        return view('backend/test/excel', $data);

        // $spreadsheet = new Spreadsheet();

        // $sheet = $spreadsheet->getActiveSheet();
        // $sheet->setCellValue('A1', 'Id');
        // $sheet->setCellValue('B1', 'Name');
        // $sheet->setCellValue('C1', 'Surname');
        // $rows = 2;

        // // px(range('A', 'B', 'C'));
        // foreach ($colExcel as $col) {
        //     pp($col);
        //     $sheet->getColumnDimension($col)->setAutoSize(true);
        // }

        // foreach ($tasks as $task) {
        //     $sheet->setCellValue('A' . $rows, $task->id);
        //     $sheet->setCellValue('B' . $rows, $task->name);
        //     $sheet->setCellValue('C' . $rows, $task->surname);
        //     $rows++;
        // }

        // $writer = new Xlsx($spreadsheet);
        // $writer->save('world.xlsx');
        // return $this->response->download('world.xlsx', null)->setFileName('sample.xlsx');
    }
}
