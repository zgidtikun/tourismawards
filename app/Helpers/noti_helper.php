<?php 

function instance_db()
{
    $db = \Config\Database::connect();
    return $db;
}

function instance_noti()
{
    $obj = new \App\Models\Notification();
    return $obj;
}

function set_noti($target,$data)
{
    $noti = instance_noti();
}

function get_noti($target,$by,$max)
{
    $noti = instance_noti();

}

?>