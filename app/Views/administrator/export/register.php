<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

// px(session()->user);
//set My Spreadsheet
$FILE_NAME  = "ผลงานที่สมัครทั้งหมด";
$DATE       = date('Y-m-d');
$TIME       = date('H:i:s');
$STAFF      = session()->user;
$TITLE      = "ผลงานที่สมัครทั้งหมด";

//new Spreadsheet
$spreadsheet = new Spreadsheet();

$sheet = $spreadsheet->getActiveSheet();

//set Amount Column
$colExcel = colExcel(15);
// pp($colExcel);
$end = end($colExcel);
// px($end);

//set Align
$sheet->getStyle('A1:' . $end . '3')->getAlignment()->setHorizontal('center');
// $sheet->getStyle('M')->getAlignment()->setHorizontal('center');

//set Bold
$sheet->getStyle('A1:' . $end . '3')->getFont()->setBold(true);

//set Company
$sheet->setTitle($FILE_NAME);
$sheet->setCellValue('A1', $FILE_NAME)->mergeCells('A1:' . $end . '1');
$sheet->setCellValue('A2', "")->mergeCells('A2:' . $end . '2');

//set Format
// $sheet->getStyle('X')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);

$rowHead = [
  // '#',
  'ลำดับที่',
  'รหัส',
  'รหัส',
  'ประเภทรางวัลฯ',
  'สาขา',
  'ที่อยู่',
  'จังหวัด',
  'อีเมล์ผู้ประกอบการ',
  'เบอร์โทร',
  'ชื่อผู้ประสาน',
  'ตำแหน่ง',
  'เบอร์โทรผู้ประสาน',
  'อีเมล์ผู้ประสาน',
  'สถานะ',
  'ผลการตัดสินรางวัลฯ',
];

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
  $i = 5;
  foreach ($result as $key => $value) {

    $data = [
      $value->id,
      $value->id,
      $value->id,
      $value->id,
      $value->id,
      $value->id,
      $value->id,
      $value->id,
      $value->id,
      $value->id,
      $value->id,
      $value->id,
      $value->id,
      $value->id,
      $value->id,
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
