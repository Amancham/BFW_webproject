<?php
session_start(); 
if(!isset($_SESSION['uid'])) {
    $_SESSION['uid'] = 0;
    $_SESSION['isadmin'] = FALSE;
}
if(!file_exists('assets/config')) 
{
    header("Location:install/index.php");
}
require_once 'vendor/autoload.php';
require_once 'controller/UserController.php';
require_once 'model/Message.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader, [
    //'cache' => 'cache',
    'debug' => true,
]);

$template = $twig->load('base.html.twig');
$menu_template = $twig->load('menu.html.twig');
$success_temp = $twig->load('success.html.twig');
$error_temp = $twig->load('error.html.twig');

if(isset($_SESSION['msg']) && isset($_SESSION['msg_type']))
{
    //TODO: Blocks are currently rendered outside of the base template??
    $msg = new Message($_SESSION['msg'], $_SESSION['msg_type']);
    if($msg->getType() === 'SUCCESS')
    {
        //load success template and reset message
        $message = $msg->getMessage();
        echo $success_temp->renderBlock('success', ['message' => $message]);
        $_SESSION['msg'] = null;
        $_SESSION['msg_type'] = null;
    } else {
        //load error template and reset message;
        $message = $msg->getMessage();
        echo $error_temp->renderBlock('error', ['message' => $message]);
        $_SESSION['msg'] = null;
        $_SESSION['msg_type'] = null;
    }
}

if($_SESSION['uid'] === 0)
{
    $loggedin = FALSE;
    $isadmin = FALSE;
    echo $template->render();
    echo $menu_template->render(['loggedin' => $loggedin, 'isadmin' => $isadmin]);
}
else if ($_SESSION['uid'] !== 0) {
    $action = new UserController(); 
    $user = $action->load_user($_SESSION['uid']);
    $loggedin = TRUE;
    $rollen = $user->getRoles();
    if(str_contains($user->getRoles(), 'ROLE_ADMIN'))
    {
        // TODO: Admin-Menu not being displayed, need to sort this out!
        $_SESSION['isadmin'] = TRUE;
        $isadmin = TRUE;
        echo $template->render();
        echo $menu_template->render(['loggedin' => $loggedin, 'isadmin' => $isadmin]);
    } else {
        $isadmin = FALSE;
        echo $template->render();
        echo $menu_template->render(['loggedin' => $loggedin, 'isadmin' => $isadmin]);
    }
}

if(isset($_GET['do']))
{
    $do = $_GET['do'];
    switch($do)
    {
        case 'login':
            $login = $twig->load('user/login.html.twig');
            echo $login->renderBlock('body');
            break;
        case 'logout':
            session_unset(); 
            session_destroy();
            session_start(); 
            $_SESSION['msg'] = 'Du wurdest erfolgreich ausgeloggt.';
            $_SESSION['msg_type'] = 'SUCCESS';
            header("refresh: 0; url = index.php");
            break;
        case 'register':
            $register = $twig->load('user/register.html.twig');
            echo $register->renderBlock('body');
            break;
        case 'dash':
            echo("Eingeloggt. Yay!");
            break;
    }
}
