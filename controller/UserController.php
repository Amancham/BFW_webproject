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

    public function check_signup() 
    {

    }

    public function do_signup() 
    {

    }

    public function save_user($user) 
    {
        if ($user->getUid() == 0) {
            $stmt = $this->pdo->prepare("INSERT INTO user (username, email, password, roles) VALUES (?, ?, ?, ?)");
            $stmt->execute([$user->getUsername(), $user->getEmail(), $user->getPassword(), $user->getRoles()]);
            //$sql = "INSERT INTO user (username, email, password, roles) VALUES ('" . $user->getUsername() . "', '" . $user->getEmail() . "', '" . $user->getPassword() . "', '".$user->getRoles()."');";
            //$this->pdo->exec($sql);
        } else {
            $stmt = $this->pdo->prepare("UPDATE player SET username = ?, password = ?, email = ?, roles = ?, registered = ? WHERE uid = ?");
            $stmt->execute([$user->getUsername(), $user->getPassword(), $user->getEmail(), $user->getRoles(), $user->getRegistered(), $user->getUid()]);
            //$sql = "UPDATE player SET username = '" . $user->getUsername() . "', password = '" . $user->getPassword() . "', email = '" . $user->getEmail() . "', pwreset = " . $user->getPwreset() . ", role = " . $user->getRole() . ", created_at = " . $user->getCreated_at() . " WHERE uid = " . $user->getUid() . ";";
            //$stmt = $this->pdo->prepare($sql);
            //$stmt->execute();
        }
    }

    public function change_password() 
    {

    }

}