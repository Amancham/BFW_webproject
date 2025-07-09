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
            $_SESSION['msg'] = 'Du wurdest erfolgreich ausgeloggt.';
            $_SESSION['msg_type'] = 'SUCCESS';
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
        
            $tags = new TagController();
            
            $taglist = $tags->list_tags();

            if(!empty($taglist))
            {
                // render template
                $items = $taglist;
                $twig->load('admin/list.html.twig', ['taglist' => $items]);
            } else {
                $taglist = "Keine Tags angelegt.";
                $twig->load($dash, ['taglist' => $taglist]);
            }

            $userlist = $action->list_users();
            if(!empty($userlist))
            {
                // render template
                $items = $userlist;
                $twig->load('admin/list.html.twig', ['userlist.items' => $items]);
            } else {
                $userlist = "Keine Benutzer angelegt.";
                $twig->load($dash, ['userlist' => $userlist]);
            }
            //echo $dash->renderBlock('body');
            echo $dash->render(['loggedin' => $loggedin, 'isadmin' => $isadmin]);
        }
    }
} else {
    echo $index->render(['loggedin' => $loggedin, 'isadmin' => $isadmin]);
}

