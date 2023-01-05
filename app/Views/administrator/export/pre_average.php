<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

// px(session()->user);
//set My Spreadsheet
$FILE_NAME  = "สรุปคะแนน Pre-Screen";
$DATE       = date('Y-m-d');
$TIME       = date('H:i:s');
$STAFF      = session()->user;
$TITLE      = "สรุปคะแนนรอบ Pre-Screen (ค่าเฉลี่ย)";

$logTimeFileName = 'CheckTime';
$currentTime = '';
$logTime  = date('YmdHis');

// Export Log Start
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
  'ชื่อผลงาน',
  'ประเภทรางวัลฯ',
  'สาขา',
  'จังหวัด',
  'เกณฑ์การประเมิน',
  'คะแนนของกรรมการคนที่ 1',
  'คะแนนของกรรมการคนที่ 2',
  'ผลรวมคะแนนเฉลี่ยที่ได้รับ',
  'คะแนนเต็ม',
  'weight ค่าน้ำหนัก (แต่ละด้าน)',
  'คะแนนที่ได้โดยเฉลี่ย',
];

//set Amount Column
$colExcel = colExcel(count($rowHead));
// pp($colExcel);
$end = end($colExcel);
// px($end);

//set Align
$sheet->getStyle('A1:' . $end . '3')->getAlignment()->setHorizontal('center');
$sheet->getStyle('A:B')->getAlignment()->setHorizontal('center');
$sheet->getStyle('H:M')->getAlignment()->setHorizontal('center');

//set Bold
$sheet->getStyle('A1:' . $end . '3')->getFont()->setBold(true);

//set Company
$sheet->setTitle($FILE_NAME);
$sheet->setCellValue('A1', $TITLE)->mergeCells('A1:' . $end . '1');
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
  $j = 1;
  foreach ($result as $key => $value) {

    if (!empty($value['tourism'])) {
      $data = [
        $j++,
        $value['code'],
        $value['attraction_name_th'],
        $value['application_type_name'],
        $value['application_type_sub_name'],
        $value['address_province'],
        'Tourism Excellence (Product/Service)',
        $value['tourism'][1]->score_pre,
        @$value['tourism'][2]->score_pre,
        '',
        $value['tourism'][1]->pre_score_total,
        $value['tourism'][1]->weight,
        '',
      ];

      // pp($data);
      foreach ($colExcel as $k => $v) {
        $sheet->setCellValue($v . $i, $data[$k]);
      }
      $i++;
    }

    if (!empty($value['supporting'])) {
      $data = [
        $j++,
        $value['code'],
        $value['attraction_name_th'],
        $value['application_type_name'],
        $value['application_type_sub_name'],
        $value['address_province'],
        'Supporting Business & Marketing Factors',
        $value['supporting'][1]->score_pre,
        @$value['supporting'][2]->score_pre,
        '',
        $value['supporting'][1]->pre_score_total,
        $value['supporting'][1]->weight,
        '',
      ];

      // pp($data);
      foreach ($colExcel as $k => $v) {
        $sheet->setCellValue($v . $i, $data[$k]);
      }
      $i++;
    }

    if (!empty($value['responsibility'])) {
      $data = [
        $j++,
        $value['code'],
        $value['attraction_name_th'],
        $value['application_type_name'],
        $value['application_type_sub_name'],
        $value['address_province'],
        'Responsibility and Safety & Health Administration',
        $value['responsibility'][1]->score_pre,
        @$value['responsibility'][2]->score_pre,
        '',
        $value['responsibility'][1]->pre_score_total,
        $value['responsibility'][1]->weight,
        '',
      ];

      // pp($data);
      foreach ($colExcel as $k => $v) {
        $sheet->setCellValue($v . $i, $data[$k]);
      }
      $i++;
    }
  }
}

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

// Export Log End
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
