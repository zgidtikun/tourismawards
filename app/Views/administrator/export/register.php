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

$rowHead = [
  // '#',
  'ลำดับที่',
  'รหัส',
  'ชื่อสถานประกอบการ',
  'ประเภทรางวัลฯ',
  'สาขา',
  'วันที่สมัคร',
  'ที่อยู่',
  'จังหวัด',
  'อีเมล์ผู้ประกอบการ',
  'เบอร์โทร',
  'ชื่อผู้ประสาน',
  'ตำแหน่ง',
  'เบอร์โทรผู้ประสาน',
  'อีเมล์ผู้ประสาน',
  'สถานะ',
  'คะแนนที่ได้ (100 คะแนน)',
  'ผลรางวัลที่ได้รับ',
];

//set Amount Column
$colExcel = colExcel(count($rowHead));
// pp($colExcel);
$end = end($colExcel);
// px($end);

//set Align
$sheet->getStyle('A1:' . $end . '3')->getAlignment()->setHorizontal('center');
$sheet->getStyle('A:B')->getAlignment()->setHorizontal('center');
$sheet->getStyle('F')->getAlignment()->setHorizontal('center');
$sheet->getStyle('O')->getAlignment()->setHorizontal('center');

//set Bold
$sheet->getStyle('A1:' . $end . '3')->getFont()->setBold(true);

//set Company
$sheet->setTitle($FILE_NAME);
$sheet->setCellValue('A1', $FILE_NAME)->mergeCells('A1:' . $end . '1');
$sheet->setCellValue('A2', "")->mergeCells('A2:' . $end . '2');

//set Format FORMAT_NUMBER_00
$sheet->getStyle('H')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
$sheet->getStyle('K')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);

foreach ($colExcel as $k => $v) {
  //set Cell Head
  $sheet->setCellValue($v . "3", $rowHead[$k]);
  //set Width
  // $sheet->getColumnDimension($v)->setWidth(20); // Set Width Size PX
  $sheet->getColumnDimension($v)->setAutoSize(true); // Set Width Auto
}
// px($result);s
if (!empty($result)) {

  // Row Start
  $i = 4;
  foreach ($result as $key => $value) {

    $status = '';
    if ($value->status == 1) {
      $status = 'รอตรวจสอบ';
    } else if ($value->status == 2) {
      $status = 'ขอข้อมูลเพิ่มเติม';
    } else if ($value->status == 3) {
      $status = 'อนุมัติ';
    } else if ($value->status == 4) {
      $status = 'ไม่อนุมัติ';
    }

    $total = $value->score_prescreen_tt + $value->score_onsite_tt;
    $awards = '';
    if ($total >= 85) {
      $awards = 'รางวัลยอดเยี่ยม (Thailand Tourism Gold Award)';
    } else if ($total >= 75 && $total <= '84.99') {
      $awards = 'รางวัลดีเด่น (Thailand Tourism Silver Award)';
    } else if ($total >= 65 && $total <= '74.99') {
      $awards = 'เกียรติบัตรรางวัลอุตสาหกรรมท่องเที่ยวไทย (Thailand Tourism Certificate)';
    } else {
      $awards = '';
      $total = '';
    }

    $address = [
      // 'address'           => '',
      'address_number'    => $value->address_no,
      // 'address_soi'       => '',
      'address_road'      => $value->address_road,
      // 'address_moo'       => '',
      'subdistrict'       => $value->address_sub_district,
      'district'          => $value->address_district,
      'province'          => $value->address_province,
      'postcode'          => $value->address_zipcode,
    ];

    $data = [
      $key + 1,
      $value->code,
      $value->attraction_name_th,
      applicationType($value->application_type_id),
      applicationTypeSub($value->application_type_sub_id),
      $value->created_at,
      mainAddress($address),
      $value->address_province,
      $value->user_email,
      $value->user_mobile,
      $value->knitter_name,
      $value->knitter_position,
      $value->knitter_tel,
      $value->knitter_email,
      $status,
      $total,
      $awards,
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
