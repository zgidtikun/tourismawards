<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

// px(session()->user);
//set My Spreadsheet
$FILE_NAME  = "Low Carbon";
$DATE       = date('Y-m-d');
$TIME       = date('H:i:s');
$STAFF      = session()->user;
$TITLE      = "Low Carbon";

//new Spreadsheet
$spreadsheet = new Spreadsheet();

$sheet = $spreadsheet->getActiveSheet();

$rowHead = [
  // '#',
  'ลำดับที่',
  'รหัส',
  'ชื่อสถานประกอบการ',
  'คะแนน Responsibility and Safety &Health Administration',
  'คะแนน Low Corbon',
  'คะแนนที่ได้ 100 คะแนน',
];

//set Amount Column
$colExcel = colExcel(count($rowHead));
// pp($colExcel);
$end = end($colExcel);
// px($end);

//set Align
$sheet->getStyle('A1:' . $end . '3')->getAlignment()->setHorizontal('center');
$sheet->getStyle('A:B')->getAlignment()->setHorizontal('center');
// $sheet->getStyle('D:H')->getAlignment()->setHorizontal('center');

//set Bold
$sheet->getStyle('A1:' . $end . '3')->getFont()->setBold(true);

//set Company
$sheet->setTitle($FILE_NAME);
$sheet->setCellValue('A1', $FILE_NAME)->mergeCells('A1:' . $end . '1');
$sheet->setCellValue('A2', "")->mergeCells('A2:' . $end . '2');

//set Format
// $sheet->getStyle('X')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);

foreach ($colExcel as $k => $v) {
  //set Cell Head
  $sheet->setCellValue($v . "3", $rowHead[$k]);
  //set Width
  // $sheet->getColumnDimension($v)->setWidth(20); // Set Width Size PX
  $sheet->getColumnDimension($v)->setAutoSize(true); // Set Width Auto
}
// px($result);
if (!empty($result)) {

  // Row Start
  $i = 4;
  foreach ($result as $key => $value) {
    $total = ($value->score_prescreen_rs + $value->score_onsite_rs + $value->lowcarbon_score) * 100 / 45;
    $data = [
      ($key + 1),
      $value->code,
      $value->attraction_name_th,
      $value->score_prescreen_rs + $value->score_onsite_rs,
      $value->lowcarbon_score,
      $total,
    ];
    foreach ($colExcel as $k => $v) {
      $sheet->setCellValue($v . $i, $data[$k]);
    }
    $i++;
  }
}

// to Xlsx
$writer = new Xlsx($spreadsheet);

// Download
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"$FILE_NAME.xlsx\"");
header("Cache-Control: max-age=0");
$writer->save('php://output');
exit();
