<?php

function renameClass($str)
{
    $stringCtrl = null;
    $arrCtrl = explode("-", $str);
    foreach ($arrCtrl as $value):
        $stringCtrl .= ucfirst($value);
    endforeach;

    return $stringCtrl;
}

function chk_array($array, $key)
{
    if (isset($array[$key]) && !empty($array[$key])) {
        return $array[$key];
    }

    return null;
}

function __autoload($class_name)
{
    $file = ABSPATH . '/classes/' . $class_name . '.php';

    if (!file_exists($file)) {
        require_once ABSPATH . '/includes/404.php';
        return;
    }

    require_once $file;
}
