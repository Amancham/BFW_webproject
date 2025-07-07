<?php
session_start(); 
if(!isset($_SESSION['uid'])) {
    $_SESSION['uid'] = 0;
    $_SESSION['isadmin'] = FALSE;
}
require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader, [
    //'cache' => 'cache',
    'debug' => true,
]);

$template = $twig->load('base.html.twig');
$menu_template = $twig->load('menu.html.twig');


if($_SESSION['uid'] === 0)
{
    $loggedin = FALSE;
    $isadmin = FALSE;
    echo $template->render();
    echo $menu_template->render(['loggedin' => $loggedin, 'isadmin' => $isadmin]);
}
else 
if ($_SESSION['uid'] !== 0) {
    $loggedin = TRUE;
    $isadmin = FALSE;
    if($_SESSION['isadmin'])
    {
        $isadmin = TRUE;
    }
    echo $template->render();
    echo $twig->render($menu, ['loggedin' => $loggedin, 'isadmin' => $isadmin]);
}


