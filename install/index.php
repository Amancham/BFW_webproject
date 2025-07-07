<?php
if(file_exists('lock')) 
{
    die('Cannot run installation while "Lock" file is present in installation folder.');
}
require_once '../vendor/autoload.php';

$templateDir = '../templates';

$loader = new \Twig\Loader\FilesystemLoader($templateDir);
$loader->addPath($templateDir, 'install');

$twig = new \Twig\Environment($loader, [
    'cache' => '../cache',
    'debug' => true
]);

$template = $twig->load('install/blank.html.twig');


echo $twig->render('install/blank.html.twig');
//echo $template->renderBlock('title', );

if(!file_exists('../assets/config')) 
{
    $template = $twig->load('install/setup_db.html.twig');
    $twig->render('install/blank.html.twig');
    echo $template->renderBlock('title');
    echo $template->renderBlock('body');

    if((isset($_POST['server']) && isset($_POST['user']) && isset($_POST['pwd']) && isset($_POST['db'])) && 
        (!empty($_POST['server']) && !empty($_POST['user']) && !empty($_POST['pwd']) && !empty($_POST['db']))) {
            $server = $_POST['server'];
            $user = $_POST['user'];
            $pwd = $_POST['pwd'];
            $db = $_POST['db'];
            $file = '../assets/config';
            $contents = "<?php
    if(!defined('SECURE_ACCESS')) {
        die('Direct access not permitted');
    }
    return array(
        'HOST' => '".$server."',
        'USER' => '".$user."',
        'PWD' => '".$pwd."',
        'DB' => '".$db."'
    );
    ?>
    ";
            file_put_contents(
            $file,
            $contents
            );
            header("Location: index.php");
        }
}
else 
{
    require_once '../model/Database.php';
    $pdo = Database::getInstance();
    $sql = file_get_contents('database.sql');
    $pdo->exec($sql);

    $template = $twig->load('install/setup_admin.html.twig');
    $twig->render('install/blank.html.twig');
    echo $template->renderBlock('title');
    echo $template->renderBlock('body');

    if((isset($_POST['username']) && isset($_POST['email']) && isset($_POST['pwd'])) && 
        (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['pwd']))) {
            $pdo = Database::getInstance();
            $pwd_hashed = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
            $create_admin = "INSERT INTO user (username, email, password, roles) VALUES ('".$_POST['username']."', '".$_POST['email']."', '".$pwd_hashed."', '[\"ROLE_USER\", \"ROLE_ADMIN\"]');";
            $pdo->exec($create_admin);

            echo("<p>Admin-Account created successfully.</p>");

            file_put_contents(
                'lock',
                'Installation locked'
            );
            header("Location: ../index.php");
        }
}