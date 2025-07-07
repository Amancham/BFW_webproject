<?php 
require_once('Database.php');

class UserController {
    private $pdo;
    private $user;

    public function __construct($user) {
        $this->pdo = Database::getInstance();
        $this->user = $user;
    }

    public function load_user($uid) 
    {
    $sql = "SELECT * FROM user WHERE uid = " . $uid . ";";
    foreach ($this->pdo->query($sql) as $row) 
        {
            $_SESSION['uid'] = $row['uid'];
            return new User($row);
        }
    }

    public function check_login() 
    {
        
    }

    public function do_login() 
    {

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
            $sql = "INSERT INTO user (username, email, password, roles) VALUES ('" . $user->getUsername() . "', '" . $user->getEmail() . "', '" . $user->getPassword() . "', '".$user->getRoles()."');";
            $this->pdo->exec($sql);
        } else {
            $sql = "UPDATE player SET username = '" . $user->getUsername() . "', password = '" . $user->getPassword() . "', email = '" . $user->getEmail() . "', pwreset = " . $user->getPwreset() . ", role = " . $user->getRole() . ", created_at = " . $user->getCreated_at() . " WHERE uid = " . $user->getUid() . ";";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }
    }

    public function change_password() 
    {

    }

}