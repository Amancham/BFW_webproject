<?php 
require_once('Database.php');

class UserController {
    private $pdo;
    private $user;

    public function __construct(User $user) {
        $this->pdo = Database::getInstance();
        $this->user = $user;
    }

    public function check_login() {

    }

    public function do_login() {

    }

    public function check_signup() {

    }

    public function do_signup() {

    }

    public function save_user($user) {

    }

}