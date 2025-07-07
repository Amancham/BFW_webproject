<?php 


class User
{
    private $uid;
    private $username;
    private $email;
    private $password;
    private $roles;
    private $registered;

    public function __construct($user_array) 
    {
        if(array_key_exists('uid', $user_array)) 
        {
            $this->uid = $user_array['uid'];
        }
        else 
        {
            $this->uid = 0;
        }
        $this->username = $user_array['username'];
        $this->email = $user_array['email'];
        $this->password = $user_array['password'];
        if(array_key_exists('roles', $user_array)) 
        {
            $this->role = $user_array['roles'];
        }
        else 
        {
            $this->role = ['ROLE_USER'];
        }
        if(array_key_exists('registered', $user_array)) 
        {
            $this->registered = $user_array['registered'];
        }
        else 
        {
            $this->registered = time();
        }
    }

    public function getUid() 
    {
        return $this->uid;
    }

    public function getUsername() 
    {
        return $this->username;
    }
    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getRoles()
    {
        return $this->roles;
    }
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

}