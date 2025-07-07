<?php
session_start(); 
if(!isset($_SESSION['uid'])) {
    $_SESSION['uid'] = 0;
}
require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader, [
    'cache' => 'cache',
]);

$template = $twig->load('base.html.twig');

echo $twig->display('base.html.twig');
