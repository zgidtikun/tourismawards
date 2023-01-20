<?php
global $db;
// Dump array
function dx($array)
{
    echo '<pre>';
    var_dump($array);
    echo '</pre>';
    exit;
}

// Print array
function pp($array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

// Print array
function px($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
    exit;
}

// ปริ้น SQL ล่าสุด
function pp_sql()
{
    $db = \Config\Database::connect();
    echo $db->getLastQuery() . ';';
    echo '<br>';
}

// ปริ้นค่า XML
function pxml($xml)
{
    echo '<pre>';
    echo htmlentities($xml);
    echo '</pre>';
}

function isAdmin()
{
    if (session()->role == 4) {
        return true;
    }
    return false;
}

function checkPermission($role = [])
{
    if (in_array(session()->role, $role)) {
        return true;
    }
    return false;
}

function roleName($id)
{
    $db = \Config\Database::connect();
    $result = $db->table('role')->where('id', $id)->get()->getRowObject();
    return $result->user_groups;
}

function adminName($id = "")
{
    if ($id == "") {
        return "";
    }
    $db = \Config\Database::connect();
    $result = $db->table('admin')->where('id', $id)->get()->getRowObject();
    return $result->name . " " . $result->surname;
}

function usersName($id = "")
{
    if ($id == "") {
        return "";
    }
    $db = \Config\Database::connect();
    $result = $db->table('users')->where('id', $id)->get()->getRowObject();
    return $result->name . " " . $result->surname;
}

function applicationType($id)
{
    $db = \Config\Database::connect();
    $result = $db->table('application_type')->where('id', $id)->get()->getRowObject();
    return @$result->name;
}

function applicationTypeSub($id)
{
    $db = \Config\Database::connect();
    $result = $db->table('application_type_sub')->where('id', $id)->get()->getRowObject();
    return @$result->name;
}

function countNotification($type)
{
    $db = \Config\Database::connect();

    $where = [];
    if (!empty(session()->award_type) && session()->award_type != "" && !isAdmin()) {
        $where['application_type_id'] = session()->award_type;
    }

    if ($type == 1) { // ตรวจสอบใบสมัคร
        $application_form = $db->table('application_form')->where('status', 2)->where($where)->get()->getResultObject();
        return count($application_form);
    } else if ($type == 2) { // แบบประเมินขั้นต้น (Prescreen)
        $application_form = $db->table('application_form AP')->select('AP.*, US.stage, US.status AS users_stage_status, US.duedate, C.application_form_id, C.assessment_round')->join('users_stage US', 'US.user_id = AP.created_by', 'left')->join('committees C', 'C.application_form_id = AP.id AND C.assessment_round = 1', 'left')->where('C.application_form_id', NULL)->where('US.stage', 1)->where('AP.status', 3)->where('US.status', 1)->where($where)->orderBy('AP.created_at', 'desc')->get()->getResultObject();
        return count($application_form);
    } else if ($type == 3) { // เพิ่มกรรมการรอบลงพื้นที่
        $application_form = $db->table('application_form AP')->select('AP.*, US.stage, US.status AS users_stage_status, US.duedate, C.application_form_id, C.assessment_round')->join('users_stage US', 'US.user_id = AP.created_by', 'left')->join('committees C', 'C.application_form_id = AP.id AND C.assessment_round = 2', 'left')->where('C.application_form_id', NULL)->where('US.stage', 2)->where('AP.status', 3)->where('US.status', 1)->where($where)->orderBy('AP.created_at', 'desc')->get()->getResultObject();
        // ->where('US.status = 1 OR US.status = 4 OR US.status = 5')
        return count($application_form);
    }
    return 0;
}

function show_404()
{
    header('Location: ' . base_url() . '/404');
    exit();
}

function show_403()
{
    header('Location: ' . base_url() . '/403');
    exit();
}

// รูปแบบวันที่ที่ใช้ในเอกสาร
function docDate($date, $format = 3, $lang = 'thailand')
{
    if (empty($date)) {
        return null;
    }
    if ($date == '0000-00-00') {
        return null;
    }
    if ($format == 1) {
        return FormatOne($date, $lang);
    } else if ($format == 2) {
        return FormatTwo($date, $lang);
    } else if ($format == 3) {
        return FormatTree($date, $lang);
    } else if ($format == 4) {
        return FormatFour($date, $lang);
    }
}

// 2020-01-30 (ค่าเริ่มต้น)
function FormatOne($date, $lang)
{
    return $date;
}

// 30 JAN. 2020
function FormatTwo($date, $lang)
{
    $strMonth = date("n", strtotime($date));
    $strDay = date("j", strtotime($date));
    $strHour = date("H", strtotime($date));
    $strMinute = date("i", strtotime($date));
    $strSeconds = date("s", strtotime($date));

    if ($lang == 'thailand') {
        $strYear = date("Y", strtotime($date)) + 543;
        $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    } else {
        $strYear = date("Y", strtotime($date));
        $strMonthCut = array("", "Jan.", "Feb.", "Mar.", "Apr.", "May.", "Jun.", "Jul.", "Aug.", "Sep.", "Oct.", "Nov.", "Dec.");
    }

    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}

// 30 มกราคม 2563
function FormatTree($date, $lang)
{
    $strMonth = date("n", strtotime($date));
    $strDay = date("j", strtotime($date));
    $strHour = date("H", strtotime($date));
    $strMinute = date("i", strtotime($date));
    $strSeconds = date("s", strtotime($date));

    if ($lang == 'thailand') {
        $strYear = date("Y", strtotime($date)) + 543;
        $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤษจิกายน", "ธันวาคม");
    } else {
        $strYear = date("Y", strtotime($date));
        $strMonthCut = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    }

    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}

// 30-01-2020
function FormatFour($date, $lang)
{
    $strMonth = date("n", strtotime($date));
    $strDay = date("j", strtotime($date));
    $strHour = date("H", strtotime($date));
    $strMinute = date("i", strtotime($date));
    $strSeconds = date("s", strtotime($date));

    if ($lang == 'thailand') {
        $strYear = date("Y", strtotime($date));
    } else {
        $strYear = date("Y", strtotime($date)) + 543;
    }

    $strMonth = sprintf('%02d', $strMonth);
    $strDay = sprintf('%02d', $strDay);
    return "$strDay-$strMonth-$strYear";
}

function dateFormatU($string)
{
    $dateTime = new DateTime($string, new DateTimeZone('Asia/Bangkok'));
    return $dateTime->format("U");
}

function dateFormatUTC()
{
    return  date("Y-m-d H:i:s") . '.000' . getStandardOffsetUTC(date_default_timezone_get());
}

function getStandardOffsetUTC($timezone)
{
    if ($timezone == 'UTC') {
        return '+0000';
    } else {
        $timezone = new DateTimeZone($timezone);
        $transitions = array_slice($timezone->getTransitions(), -3, null, true);

        foreach (array_reverse($transitions, true) as $transition) {
            if ($transition['isdst'] == 1) {
                continue;
            }
            return sprintf('%+03d%02u', $transition['offset'] / 3600, abs($transition['offset']) % 3600 / 60);
        }
        return false;
    }
}

function genFileName($type)
{
    return date('Ymd') . '_' . bin2hex(random_bytes(6)) . '.' . $type;
}

function pdfEncode($text)
{
    $text = preg_replace("/\xE2\x80\x8B/", "", $text);
    $text = iconv("utf-8", "cp874//TRANSLIT", $text);
    return $text;
}

function colExcel($numCol)
{
    $arrayCol = [];
    $textCol  = '';
    $round    = ceil($numCol / 25);
    $alphabet = range('A', 'Z');

    for ($i = 0; $i < ($round); $i++) {
        $loopExcel  = loopExcel($textCol, $numCol);
        $numCol     = $numCol - 25;
        $arrayCol   = array_merge($arrayCol, $loopExcel);
        $textCol    = $alphabet[$i];
    }
    return $arrayCol;
}

function loopExcel($textCol, $numCol)
{
    $arrayCol = [];
    $alphabet = range('A', 'Z');
    foreach ($alphabet as $key => $value) {
        if ($numCol > 0) {
            $arrayCol[] = $textCol . $value;
            $numCol--;
        }
    }
    return $arrayCol;
}

function subAddress($address)
{
    $result = [
        'address'       => '',
        'subdistrict'   => '',
        'district'      => '',
        'province'      => '',
        'postcode'      => '',
    ];

    $address = str_replace("\n", '', $address);
    $address = str_replace("\r", '', $address);

    // รหัสไปรษณีย์
    if (strpos($address, 'รหัสไปรษณีย์') !== false) {

        $explode = explode('รหัสไปรษณีย์', $address);
        $result['postcode'] = trim($explode[1]);
        $address = str_replace('รหัสไปรษณีย์' . $explode[1], '', $address);
    } else {

        $postcode = substr($address, -5);
        if (is_numeric($postcode)) {
            $result['postcode'] = $postcode;
            $address = str_replace($postcode, '', $address);
        }
    }

    // จังหวัด
    if (strpos($address, 'กรุงเทพมหานคร') !== false) {

        $result['province'] = 'กรุงเทพมหานคร';
        $address = str_replace('กรุงเทพมหานคร', '', $address);
    } else if (strpos($address, 'กรุงเทพฯ') !== false) {

        $result['province'] = 'กรุงเทพมหานคร';
        $address = str_replace('กรุงเทพฯ', '', $address);
    } else if (strpos($address, 'กรุงเทพ') !== false) {

        $result['province'] = 'กรุงเทพมหานคร';
        $address = str_replace('กรุงเทพ', '', $address);
    } else if (strpos($address, 'กทม.') !== false) {

        $result['province'] = 'กรุงเทพมหานคร';
        $address = str_replace('กทม.', '', $address);
    } else if (strpos($address, 'กทม') !== false) {

        $result['province'] = 'กรุงเทพมหานคร';
        $address = str_replace('กทม', '', $address);
    } else if (strpos($address, 'จังหวัด') !== false) {

        $explode = explode('จังหวัด', $address);
        $result['province'] = trim($explode[1]);
        $address = str_replace('จังหวัด' . $explode[1], '', $address);
    } else if (strpos($address, 'จ.') !== false) {

        $explode = explode('จ.', $address);
        $result['province'] = trim($explode[1]);
        $address = str_replace('จ.' . $explode[1], '', $address);
    }

    // อำเภอ
    if (strpos($address, 'เขต') !== false) {

        $explode = explode('เขต', $address);
        $result['district'] = trim($explode[1]);
        $address = str_replace('เขต' . $explode[1], '', $address);
    } else if (strpos($address, 'ข.') !== false) {

        $explode = explode('ข.', $address);
        $result['district'] = trim($explode[1]);
        $address = str_replace('ข.' . $explode[1], '', $address);
    } else if (strpos($address, 'อำเภอ') !== false) {

        $explode = explode('อำเภอ', $address);
        $result['district'] = trim($explode[1]);
        $address = str_replace('อำเภอ' . $explode[1], '', $address);
    } else if (strpos($address, 'อ.') !== false) {

        $explode = explode('อ.', $address);
        $result['district'] = trim($explode[1]);
        $address = str_replace('อ.' . $explode[1], '', $address);
    }

    // ตำบล
    if (strpos($address, 'แขวง') !== false) {

        $explode = explode('แขวง', $address);
        $result['subdistrict'] = trim($explode[1]);
        $address = str_replace('แขวง' . $explode[1], '', $address);
    } else if (strpos($address, 'ตำบล') !== false) {

        $explode = explode('ตำบล', $address);
        $result['subdistrict'] = trim($explode[1]);
        $address = str_replace('ตำบล' . $explode[1], '', $address);
    } else if (strpos($address, 'ต.') !== false) {

        $explode = explode('ต.', $address);
        $result['subdistrict'] = trim($explode[1]);
        $address = str_replace('ต.' . $explode[1], '', $address);
    }

    $result['address'] = trim($address);

    return $result;
}

function mainAddress($addressUse)
{
    $addressDefault = [
        'address'           => '',
        'address_number'    => '',
        'address_soi'       => '',
        'address_road'      => '',
        'address_moo'       => '',
        'subdistrict'       => '',
        'district'          => '',
        'province'          => '',
        'postcode'          => '',
    ];

    $address = array_merge($addressDefault, $addressUse);
    $addr = [];
    if (!empty($address['address'])) {
        $addr[] = trim($address['address']);
    }

    if (!empty($address['address_number'])) {
        $addr[] = 'เลขที่ ' . trim(str_replace('เลขที่', ' ', $address['address_number']));
    }

    if (!empty($address['address_soi'])) {
        $addr[] = 'ซอย ' . trim(str_replace('ซอย', ' ', $address['address_soi']));
    }

    if (!empty($address['address_road'])) {
        $addr[] = 'ถนน ' . trim(str_replace('ถนน', ' ', $address['address_road']));
    }

    if (!empty($address['address_moo'])) {
        $addr[] = 'หมู่ ' . trim(str_replace('หมู่', ' ', $address['address_moo']));
    }

    if (!empty($address['province']) && ($address['province'] == 'กรุงเทพมหานคร' || strpos($address['province'], 'กรุงเทพ') || strpos(($address['province']), 'กทม'))) {
        $addr[] = 'แขวง' . trim(str_replace('แขวง', ' ', $address['subdistrict']));
        $addr[] = 'เขต' . trim(str_replace('เขต', ' ', $address['district']));
        $addr[] = 'กรุงเทพมหานคร';
    } else if (!empty($address['province'])) {
        $addr[] = 'ตำบล' . trim(str_replace('ตำบล', ' ', $address['subdistrict']));
        $addr[] = 'อำเภอ' . trim(str_replace('อำเภอ', ' ', $address['district']));
        $addr[] = 'จังหวัด' . trim(str_replace('จังหวัด', ' ', $address['province']));
    }

    if (!empty($address['postcode'])) {
        $addr[] = 'รหัสไปรษณีย์ ' . trim(str_replace('รหัสไปรษณีย์', ' ', $address['postcode']));
    }

    return implode(' ', $addr);
}

function readFiles($dir)
{
    $file_name = [];
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if ($file != '.' && $file != '..') {
                    $file_name[] = $dir . $file;
                }
            }
            closedir($dh);
        }
    }
    return $file_name;
}

// function PasswordEncrypt($string)
// {
//     $salting = substr(md5(microtime()), -1) . $string;
//     return mySecretKey($salting, 'e');
// }

// function PasswordDecrypt($string)
// {
//     $encode = mySecretKey($string, 'd');
//     return substr($encode, 1);
// }

// function mySecretKey($string, $action = 'e')
// {
//     $output = false;
//     $encrypt_method = "AES-256-CBC";

//     $secret_key = 'n%&M|#3$y+A+rv_mRtz8c12K+&ju';
//     $secret_iv = '#K!@#Mark$&*(Hash)pass-$_$';

//     $key = hash('sha256', $secret_key);
//     $iv = substr(hash('sha256', $secret_iv), 0, 16);

//     if ($action == 'e') {
//         $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
//     } else if ($action == 'd') {
//         $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
//     }

//     return $output;
// }