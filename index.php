<?php
    require_once("admin/models/config.php");
    define('SYSPATH', 'system/');
    require SYSPATH."client.php";
    require SYSPATH."site.php";
    if(!isUserLoggedIn()) {
        require('site/action/home.php'); 
    }
    else{
    $action = input_get('action');
    if($action == false) require('site/action/homepage.php');
    else
    {
        if (file_exists('site/action/'.$action.'.php'))
            require('site/action/'.$action.'.php');
        else
            require('site/action/show_404.php');}
    }
?>