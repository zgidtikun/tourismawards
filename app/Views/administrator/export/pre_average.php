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

$rowHead[] = 'ลำดับที่';
$rowHead[] = 'รหัส';
$rowHead[] = 'ชื่อสถานประกอบการ';
$rowHead[] = 'ประเภทรางวัลฯ';
$rowHead[] = 'สาขา';
$rowHead[] = 'จังหวัด';
$rowHead[] = 'เกณฑ์การประเมิน';
for ($i = 1; $i <= $count_committees; $i++) {
  $rowHead[] = 'คะแนนของกรรมการคนที่ ' . $i;
}

$rowHead[] = 'ผลรวมคะแนนเฉลี่ยที่ได้รับ';
$rowHead[] = 'คะแนนเต็ม';
$rowHead[] = 'weight ค่าน้ำหนัก (แต่ละด้าน)';
$rowHead[] = 'คะแนนที่ได้โดยเฉลี่ย';
// pp($rowHead);

//set Amount Column
$colExcel = colExcel(count($rowHead));
// pp($colExcel);
$end = end($colExcel);
// px($end);

//set Align
$sheet->getStyle('A1:' . $end . '3')->getAlignment()->setHorizontal('center');
$sheet->getStyle('A:B')->getAlignment()->setHorizontal('center');
$sheet->getStyle('H:N')->getAlignment()->setHorizontal('center');

//set Bold
$sheet->getStyle('A1:' . $end . '3')->getFont()->setBold(true);

//set Company
$sheet->setTitle($FILE_NAME);
$sheet->setCellValue('A1', $TITLE)->mergeCells('A1:' . $end . '1');
$sheet->setCellValue('A2', "")->mergeCells('A2:' . $end . '2');

//set Format
$sheet->getStyle('H:L')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
$sheet->getStyle('N')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);

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
  foreach ($result as $index => $value) {

    $data = [];
    if (!empty($value['tourism'])) {
      $data[] = $j++;
      $data[] = $value['code'];
      $data[] = $value['attraction_name_th'];
      $data[] = $value['application_type_name'];
      $data[] = $value['application_type_sub_name'];
      $data[] = $value['address_province'];
      $data[] = 'Tourism Excellence (Product/Service)';

      $score_pte = [];
      foreach ($value['tourism'] as $key => $val) {
        $data[] = @$val->score_pte;
        $score_pte[] = @$val->score_pte;
      }
      if (count($value['tourism']) <= $count_committees) {
        for ($n=0; $n < ($count_committees - count($value['tourism'])); $n++) { 
          $data[] = '';
        }
      }
      $data[] = array_sum($score_pte) / count($score_pte);
      $data[] = $value['estimate']['tourism']->sum_pre_score; // คะแนนเต็ม
      $data[] = '10';
      $data[] = $value['estimate']['tourism']->sum_tscore_pre;

      // pp($data);
      foreach ($colExcel as $k => $v) {
        $sheet->setCellValue($v . $i, $data[$k]);
      }
      $i++;
    }

    $data = [];
    if (!empty($value['supporting'])) {
      $data[] = $j++;
      $data[] = $value['code'];
      $data[] = $value['attraction_name_th'];
      $data[] = $value['application_type_name'];
      $data[] = $value['application_type_sub_name'];
      $data[] = $value['address_province'];
      $data[] = 'Supporting Business & Marketing Factors';

      $score_psb = [];
      foreach ($value['supporting'] as $key => $val) {
        $data[] = @$val->score_psb;
        $score_psb[] = @$val->score_psb;
      }
      if (count($value['supporting']) <= $count_committees) {
        for ($l=0; $l < ($count_committees - count($value['supporting'])); $l++) { 
          $data[] = '';
        }
      }
      $data[] = array_sum($score_psb) / count($score_psb);
      $data[] = $value['estimate']['supporting']->sum_pre_score; // คะแนนเต็ม
      $data[] = '10';
      $data[] = $value['estimate']['supporting']->sum_tscore_pre;

      // pp($data);
      foreach ($colExcel as $k => $v) {
        $sheet->setCellValue($v . $i, $data[$k]);
      }
      $i++;
    }

    $data = [];
    if (!empty($value['responsibility'])) {
      $data[] = $j++;
      $data[] = $value['code'];
      $data[] = $value['attraction_name_th'];
      $data[] = $value['application_type_name'];
      $data[] = $value['application_type_sub_name'];
      $data[] = $value['address_province'];
      $data[] = 'Responsibility and Safety & Health Administration';

      $score_prs = [];
      foreach ($value['responsibility'] as $key => $val) {
        $data[] = @$val->score_prs;
        $score_prs[] = @$val->score_prs;
      }
      if (count($value['responsibility']) <= $count_committees) {
        for ($m=0; $m < ($count_committees - count($value['responsibility'])); $m++) { 
          $data[] = '';
        }
      }
      $data[] = array_sum($score_prs) / count($score_prs);
      $data[] = $value['estimate']['responsibility']->sum_pre_score; // คะแนนเต็ม
      $data[] = '5';
      $data[] = $value['estimate']['responsibility']->sum_tscore_pre;

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
