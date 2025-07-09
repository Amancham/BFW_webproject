<?php
require('config.php');
// TODO: Sort through templates again. There is something going wrong here.
if(!isset($_GET['mode']));
{
    //die('Direct access to this file is not allowed');
}
if(isset($_GET['mode']));
{
    require_once('controller/UserController.php');
    $action = new UserController();
    require_once('controller/TagController.php');
    $tags = new TagController();
    $verify = $_GET['mode'];
    switch($verify) 
    {
        case 'login':
            if($action->check_login($_POST['email'], $_POST['pwd']))
            {
                $action->do_login($_POST['email']);
                //TODO: possibly set up a proper dashboard
                header("refresh: 0; url = index.php?do=dash");
            } else {
                header("refresh: 0; url = index.php?do=login");
            }
            break;
        case 'register':
            if($action->check_signup($_POST['email'], $_POST['pwd'], $_POST['pwd2']))
            {
                $action->do_signup($_POST['username'], $_POST['email'], $_POST['pwd']);
                header("refresh: 0; url = index.php?do=login");
            } else {
                header("refresh: 0; url = index.php?do=register");
            }
            break;
        case 'new_exercise':
            break;
        case 'new_solution':
            break;
        case 'new_comment':
            break;
        case 'new_tag':
            if($tags->check_if_tag_exists($_POST['tag_name']))
            {
                header("refresh: 0; url = index.php?do=admin_dash&add=tag");
            } else {
                $tags->save_tag(0, $_POST['tag_name']);
                header("refresh: 0; url = index.php?do=admin_dash");
            }
            break;
    }
}