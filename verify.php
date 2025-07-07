<?php
session_start();
if(!isset($_GET['mode']));
{
    //die('Direct access to this file is not allowed');
}
if(isset($_GET['mode']));
{
    require_once('controller/UserController.php');
    $action = new UserController();
    $verify = $_GET['mode'];
    switch($verify) 
    {
        case 'login':
            if($action->check_login($_POST['email'], $_POST['pwd']))
            {
                $action->do_login($_POST['email']);
                header("refresh: 0; url = index.php?do=dash");
            } else {
                $_SESSION['msg'] = 'Die Login-Daten waren inkorrekt.';
                $_SESSION['msg_type'] = 'ERROR';
                header("refresh: 0; url = index.php?do=login");
            }
            break;
        case 'signup':
            break;
        case 'new_exercise':
            break;
        case 'new_solution':
            break;
        case 'new_comment':
            break;
        case 'new_tag':
            break;
    }
}