<?php 
require_once('./model/Database.php');
require_once('./model/User.php');

class UserController {
    private $pdo;
    private $user;

    public function __construct() {
        $this->pdo = Database::getInstance();
        $this->user = null;
    }

    public function load_user($uid) 
    {
        $rows = $this->pdo->prepare("SELECT * FROM user WHERE uid = ?");
        $rows->execute([$uid]);
        foreach($rows as $row) 
        {
            $_SESSION['uid'] = $row['uid'];
            $this->user = new User($row);
            return $this->user;
        }
    }

    public function get_uid($email)
    {
        $rows = $this->pdo->prepare("SELECT * FROM user WHERE email = ?");
        $rows->execute([$email]);
        foreach($rows as $row) 
        {
            return $row['uid'];
        }
    }

    public function check_login($email, $password) 
    {
        $check = $this->pdo->prepare("SELECT password FROM user WHERE email = ?");
        $stmt = $check->execute([$email]);
        $rows = $check->fetchAll();
        $row_count = $check->rowCount();
        if($row_count > 0)
        {
            foreach ($rows as $row)
            {
                $password_hashed = $row['password'];
            }
            if (password_verify($password, $password_hashed))
            {
                return true;
            } else {
                return false;
            }
        }
        return false;

    }

    public function do_login($email) 
    {
        $new_id = $this->get_uid($email);
        $_SESSION['uid'] = $new_id;
        return $this->load_user($new_id);
    }

    public function check_signup($email, $pwd, $pwd2) 
    {
        if($pwd !== $pwd2)
        {
            $_SESSION['msg'] = "Passwort und Passwort Widerholung stimmen nicht überein.";
            $_SESSION['msg_type'] = 'ERROR';
            return false;
        }
        else if(strlen($pwd) < 8)
        {
            $_SESSION['msg'] = "Das Passwort muss mindestens 8 Zeichen lang sein.";
            $_SESSION['msg_type'] = 'ERROR';
            return false;
        } else {
            $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = ?");
            $stmt->execute([$email]);
            $rowcount = $stmt->rowCount();
            if($rowcount > 0)
            {
                $_SESSION['msg'] = "Diese E-Mail-Adresse ist bereits registriert.";
                $_SESSION['msg_type'] = 'ERROR';
                return false;
            } else {
                return true;
            }
        }
        return false;
    }

    public function do_signup($username, $email, $pwd) 
    {
        $hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);
        $new_user = [
            'uid' => 0,
            'username' => addslashes($username),
            'email' => addslashes($email),
            'password' => $hashed_pwd
        ];
        $user = new User($new_user);
        $this->save_user($user);
    }

    public function save_user($user) 
    {
        if ($user->getUid() == 0) {
            $stmt = $this->pdo->prepare("INSERT INTO user (username, email, password, roles) VALUES (?, ?, ?, ?)");
            $stmt->execute([$user->getUsername(), $user->getEmail(), $user->getPassword(), $user->getRoles()]);
        } else {
            $stmt = $this->pdo->prepare("UPDATE player SET username = ?, password = ?, email = ?, roles = ?, registered = ? WHERE uid = ?");
            $stmt->execute([$user->getUsername(), $user->getPassword(), $user->getEmail(), $user->getRoles(), $user->getRegistered(), $user->getUid()]);
        }
    }

}