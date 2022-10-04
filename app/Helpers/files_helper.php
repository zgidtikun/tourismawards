<?php

function randomFileName($type)
{
    return date('Ymd').'_'.bin2hex(random_bytes(6)).'.'.$type;
}
