<?php

function randomFileName($type)
{
    return date('Ymd').'_'.bin2hex(random_bytes(6)).'.'.$type;
}

function setPathFile()
{
    $year = date('Y');
    $month = date('m');
    $day = date('d');
    $path = 'uploads/'.$year.'/'.$month.'/'.$day.'/';
    return $path;
}