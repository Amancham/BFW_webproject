<?php
require('config.php');
$index = $twig->load('index.html.twig');

if(isset($_GET['do']))
{
    $do = $_GET['do'];
    switch($do)
    {
        case 'login':
            $login = $twig->load('user/login.html.twig');
            echo $login->render(['loggedin' => $loggedin, 'isadmin' => $isadmin]);
            break;
        case 'logout':
            session_unset(); 
            session_destroy();
            session_start(); 
            $loggedin = false;
            $isadmin = false;
            $_SESSION['msg'] = 'Du wurdest erfolgreich ausgeloggt.';
            $_SESSION['msg_type'] = 'SUCCESS';
            echo $temp_base->render(['loggedin' => $loggedin, 'isadmin' => $isadmin]);
            header("refresh: 0; url = index.php");
            break;
        case 'register':
            $register = $twig->load('user/register.html.twig');
            echo $register->render(['loggedin' => $loggedin, 'isadmin' => $isadmin]);
            break;
        case 'admin_dash':
            $dash = $twig->load('admin/dashboard.html.twig');
            break;
        case 'dashboard':
            $userdash = $twig->load('user/dashboard.html.twig');
            break;
    }

    if($do === 'admin_dash')
    {
        if(!$_SESSION['isadmin'])
        {
            die("Access not permitted!");
        }
        if(isset($_GET['add']))
        {
            $adding = $_GET['add'];
            switch($adding)
            {
                case 'tag':
                    $add_tag = $twig->load('admin/add_tag.html.twig');
                    //echo $add_tag->renderBlock('body');
                    echo $add_tag->render(['loggedin' => $loggedin, 'isadmin' => $isadmin]);
                    break;
                case 'exercise':
                    break;
                default:
                    
            }
        } else {
        
            $tagControl = new TagController();
            
            $taglist = $tagControl->list_tags();
            $userlist = $action->list_users();

            echo $twig->render('admin/dashboard.html.twig', ['loggedin' => $loggedin, 'isadmin' => $isadmin, 'tags' => $taglist, 'users' => $userlist]);
            //echo $dash->render(['loggedin' => $loggedin, 'isadmin' => $isadmin, 'tags' => $tags]);
        }
    }
} else {
    echo $index->render(['loggedin' => $loggedin, 'isadmin' => $isadmin]);
}

