<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

// px(session()->user);
//set My Spreadsheet
$FILE_NAME  = "Export_file";
$DATE       = date('Y-m-d');
$TIME       = date('H:i:s');
$STAFF      = session()->user;
$TITLE      = "Export_file";

//new Spreadsheet
$spreadsheet = new Spreadsheet();

$sheet = $spreadsheet->getActiveSheet();

//set Align
$sheet->getStyle('A1:C4')->getAlignment()->setHorizontal('center');
// $sheet->getStyle('M')->getAlignment()->setHorizontal('center');

//set Bold
$sheet->getStyle('A1:C4')->getFont()->setBold(true);

//set Company
$sheet->setTitle($FILE_NAME);
$sheet->setCellValue('A1', $FILE_NAME)->mergeCells('A1:C1');
$sheet->setCellValue('A2', $TITLE)->mergeCells('A2:C2');
$sheet->setCellValue('A3', "")->mergeCells('A3:C3');

//set Format
$sheet->getStyle('A:N')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);

//set Amount Column
$colExcel = colExcel(3);
$rowHead = [
  // '#',
  'Name',
  'SurName',
  'SurName',
];

foreach ($colExcel as $k => $v) {
  //set Cell Head
  $sheet->setCellValue($v . "4", $rowHead[$k]);
  //set Width
  $sheet->getColumnDimension($v)->setWidth(20); // Set Width Size PX
  // $sheet->getColumnDimension($v)->setAutoSize(true); // Set Width Auto
}
// px($result);
if (!empty($result)) {

  // Row Start
  $i = 5;
  foreach ($result as $index => $value) {

    $data = [
      // $value->id,
      $value->name,
      $value->surname,
      $value->surname,
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
