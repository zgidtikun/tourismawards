<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

// px(session()->user);
//set My Spreadsheet
$FILE_NAME  = "ข้อเสนอแนะกรรมการ";
$DATE       = date('Y-m-d');
$TIME       = date('H:i:s');
$STAFF      = session()->user;
$TITLE      = "ข้อเสนอแนะกรรมการ";

//new Spreadsheet
$spreadsheet = new Spreadsheet();

$sheet = $spreadsheet->getActiveSheet();

$rowHead = [
  // '#',
  'ลำดับที่',
  'รหัส',
  'ชื่อสถานประกอบการ',
  'ประเภทรางวัลฯ',
  'สาขา',
  'จังหวัด',
  'คำถาม',
  'คำตอบ',
  'ชื่อผู้ประเมิน',
  'เกณฑ์การประเมิน',
  'ข้อเสนอแนะ (Pre-Screen)',
  'ข้อเสนอแนะ (ลงพื้นที่)',
];

//set Amount Column
$colExcel = colExcel(count($rowHead));
// pp($colExcel);
$end = end($colExcel);
// px($end);

//set Align
$sheet->getStyle('A1:' . $end . '3')->getAlignment()->setHorizontal('center');
$sheet->getStyle('A:B')->getAlignment()->setHorizontal('center');

$sheet->getStyle('G:H')->getAlignment()->setWrapText(true);
$sheet->getStyle('K')->getAlignment()->setWrapText(true);

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
  if (in_array($v, ['H'])) {
    $sheet->getColumnDimension($v)->setWidth(100); // Set Width Size PX
  } else {
    $sheet->getColumnDimension($v)->setAutoSize(true); // Set Width Auto
  }
}
// px($result);
if (!empty($result)) {

  // Row Start
  $i = 4;
  foreach ($result as $key => $value) {

    if ($value->assessment_group_id == 1) {
      $assessment = 'Tourism Excellence (Product/Service)';
    } else if ($value->assessment_group_id == 2) {
      $assessment = 'Supporting Business & Marketing Factors';
    } else if ($value->assessment_group_id == 3) {
      $assessment = 'Responsibility and Safety & Health Administration';
    } else if ($value->assessment_group_id == 4) {
      $assessment = 'Low Carbon & Sustainability';
    }

    $data = [
      ($key + 1),
      $value->code,
      $value->attraction_name_th,
      $value->application_type_name,
      $value->application_type_sub_name,
      $value->address_province,
      ($value->question),
      $value->reply,
      $value->estimate_name,
      $assessment,
      $value->comment_pre,
      $value->comment_onsite,
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
