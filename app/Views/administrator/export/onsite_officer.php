<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

// px(session()->user);
//set My Spreadsheet
$FILE_NAME  = "คะแนนรอบลงพื้นที่";
$DATE       = date('Y-m-d');
$TIME       = date('H:i:s');
$STAFF      = session()->user;
$TITLE      = "คะแนนรอบลงพื้นที่ (ของกรรมการแต่ละท่าน)";

$logTimeFileName = 'CheckTime';
$currentTime = '';
$logTime  = date('YmdHis');

$timeStarted = microtime();
$timeStarted = explode(" ", $timeStarted);
$timeStarted = $timeStarted[1] + $timeStarted[0];
$currentTime = $timeStarted;
@mkdir(FCPATH . 'logs/backend-report', 0777, true);
$fp = fopen(FCPATH . 'logs/backend-report/' . $logTimeFileName . '_' . $logTime . '.txt', 'a+');

fwrite($fp, "======================Start checkTime======================\n");
fwrite($fp, "start time: " . date('Y-m-d H:i:s') . "\n\n");
fclose($fp);

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
  'หัวข้อการประเมิน',
  'เกณฑ์การประเมิน',
  'ค่าน้ำหนัก (รายข้อ)',
  'คะแนนที่ได้ (คะแนนดิบ)',
  'คะแนนที่ได้รับ (รอบลงพื้นที่)',
  'คะแนนเต็ม (รายข้อ)',
  'ชื่อผู้ประเมิน',
  'ข้อเสนอแนะ (รายข้อ)',
];

//set Amount Column
$colExcel = colExcel(count($rowHead));
// pp($colExcel);
$end = end($colExcel);
// px($end);

//set Align
$sheet->getStyle('A1:' . $end . '3')->getAlignment()->setHorizontal('center');
$sheet->getStyle('A:B')->getAlignment()->setHorizontal('center');
$sheet->getStyle('I:L')->getAlignment()->setHorizontal('center');

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
    if ($value->assessment_group_id == 1) {
      $assessment = 'Tourism Excellence (Product/Service)';
    } else if ($value->assessment_group_id == 2) {
      $assessment = 'Supporting Business & Marketing Factors';
    } else if ($value->assessment_group_id == 3) {
      $assessment = 'Responsibility and Safety & Health Administration';
    }

    $data = [
      ($key + 1), // 'ลำดับที่',
      $value->code, // 'รหัส',
      $value->attraction_name_th, // 'ชื่อสถานประกอบการ',
      $value->application_type_name,  // 'ประเภทรางวัลฯ',
      $value->application_type_sub_name,  // 'สาขา',
      $value->address_province, // 'จังหวัด',
      $value->question, // 'หัวข้อการประเมิน',
      $assessment,  // 'เกณฑ์การประเมิน',
      $value->weight, // 'ค่าน้ำหนัก (รายข้อ)',
      $value->score_onsite_origin,  // 'คะแนนที่ได้ (คะแนนดิบ)',
      $value->score_onsite_origin * $value->weight, // 'คะแนนที่ได้รับ (รอบลงพื้นที่)', คะแนนดิบ X ค่าน้ำหนักรายข้อ ... $value->tscore_onsite
      $value->onside_score, // 'คะแนนเต็ม (รายข้อ)',
      $value->estimate_name,  // 'ชื่อผู้ประเมิน',
      $value->comment_onsite, // 'ข้อเสนอแนะ (รายข้อ)',
    ];
    foreach ($colExcel as $k => $v) {
      $sheet->setCellValue($v . $i, $data[$k]);
    }
    $i++;
  }
}
// px($data);

$timeChecked = microtime();
$timeChecked = explode(" ", $timeChecked);
$timeChecked = $timeChecked[1] + $timeChecked[0];
$diffSec = $timeChecked - $currentTime;
$currentTime = $timeChecked;
$fp = fopen(FCPATH . 'logs/backend-report/' . $logTimeFileName . '_' . $logTime . '.txt', 'a+');
fwrite($fp, "Pre Export\n");
fwrite($fp, "now time: " . date('Y-m-d H:i:s') . "\n");
fwrite($fp, "diffTime: " . $diffSec . " sec.\n\n");
fclose($fp);

// to Xlsx
$writer = new Xlsx($spreadsheet);

// Download
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"$FILE_NAME.xlsx\"");
header("Cache-Control: max-age=0");
$writer->save('php://output');

$timeChecked = microtime();
$timeChecked = explode(" ", $timeChecked);
$timeChecked = $timeChecked[1] + $timeChecked[0];
$diffSec = $timeChecked - $currentTime;
$totalTime = $timeChecked - $timeStarted;
$fp = fopen(FCPATH . 'logs/backend-report/' . $logTimeFileName . '_' . $logTime . '.txt', 'a+');
fwrite($fp, "======================End Time Export======================\n");
fwrite($fp, "now time: " . date('Y-m-d H:i:s') . "\n");
fwrite($fp, "diffTime: " . $diffSec . " sec.\n\n");
fwrite($fp, "totalTime: " . $totalTime . " sec.\n\n");
fwrite($fp, "\n\n\n\n\n");
fclose($fp);
exit();
