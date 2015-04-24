<?php
    require_once("admin/models/config.php");
    define('SYSPATH', 'system/');
    require SYSPATH."client.php";
    require SYSPATH."site.php";
    
    $action = input_get('action');
    if (file_exists('site/action/'.$action.'.php'))
        require('site/action/'.$action.'.php');
    else
        require('site/action/show_404.php');
?>