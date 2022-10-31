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
    echo $db->getLastQuery();
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

function adminName($id)
{
    $db = \Config\Database::connect();
    $result = $db->table('admin')->where('id', $id)->get()->getRowObject();
    return $result->name;
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
    if ($type == 1) {
        $application_form = $db->table('application_form')->where('status <= 2')->get()->getResultObject();
        return count($application_form);
    }
    return 0;
    
}

function show_404()
{
    header('Location: ' . base_url() . '/404');
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