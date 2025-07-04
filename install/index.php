<?php
if(file_exists('lock')) 
{
    die('Cannot run installation while "Lock" file is present in installation folder.');
}
require_once '../vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader, [
    'cache' => '../cache',
]);

$template = $twig->load('install/blank.html.twig');

echo $twig->render('install/blank.html.twig', ['titletext' => 'Installationsanweisungen']);
//echo $template->renderBlock('title', );

if(!file_exists('../assets/config')) 
{

    $array = [
        'titletext' => 'Datenbank Setup'
    ];
    $twig->render('install/blank.html.twig', $array);
    echo $template->renderBlock('body', []);
}
else 
{
    require_once '../model/Database.php';
    $pdo = Database::getPdo();
}