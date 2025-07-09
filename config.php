<?php
session_start(); 
if(!isset($_SESSION['uid'])) {
    $_SESSION['uid'] = 0;
    $_SESSION['isadmin'] = FALSE;
}
// make sure we are always sent to the installer unless the site is already set up.
if(!file_exists('assets/config')) 
{
    header("Location:install/index.php");
}

// all required files
require_once 'vendor/autoload.php';
require_once 'controller/UserController.php';
require_once 'controller/TagController.php';
require_once 'model/Message.php';

// template stuff
$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/templates');
$twig = new \Twig\Environment($loader, [
    //'cache' => 'cache',
    'debug' => true,
    'auto_reload' => true,
    'strict_variables' => true,
    'autoescape' => 'html',
]);

$temp_base = $twig->load('base.html.twig');
$success_temp = $twig->load('success.html.twig');
$error_temp = $twig->load('error.html.twig');

// Messaging across the board 
if(isset($_SESSION['msg']) && isset($_SESSION['msg_type']))
{
    //TODO: Blocks are currently rendered outside of the base template??
    // possibly make a true/false function to add wherever we need messaging
    // current problem is double-rendering of two templates. Needs changing
    $msg = new Message($_SESSION['msg'], $_SESSION['msg_type']);
    if($msg->getType() === 'SUCCESS')
    {
        //load success template and reset message
        $message = $msg->getMessage();
        echo $success_temp->render(['message' => $message]);
        $_SESSION['msg'] = null;
        $_SESSION['msg_type'] = null;
    } else {
        //load error template and reset message;
        $message = $msg->getMessage();
        echo $error_temp->renderBlock('body', ['message' => $message]);
        $_SESSION['msg'] = null;
        $_SESSION['msg_type'] = null;
    }
}

// Make sure the menu is always displayed correctly 
// always render with ['loggedin' => $loggedin, 'isadmin' => $isadmin]
if($_SESSION['uid'] === 0)
{
    $loggedin = FALSE;
    $isadmin = FALSE;
}
else if ($_SESSION['uid'] !== 0) {
    $action = new UserController(); 
    $user = $action->load_user($_SESSION['uid']);
    $loggedin = TRUE;
    $rollen = $user->getRoles();
    if(str_contains($user->getRoles(), 'ROLE_ADMIN'))
    {
        $_SESSION['isadmin'] = TRUE;
        $isadmin = TRUE;
    } else {
        $isadmin = FALSE;
    }
}