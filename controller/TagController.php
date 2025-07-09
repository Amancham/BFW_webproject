<?php
require_once('./model/Database.php');
require_once('./model/Tag.php');

class TagController 
{
    private $pdo;
    private $tag;

    public function __construct() 
    {
        $this->pdo = Database::getInstance();
        $this->tag = null;
    }

    public function getTag()
    {
        return $this->tag;
    }
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    public function list_tags()
    {
        //TODO: Call all tags and list them nicely
        $stmt = $this->pdo->query("SELECT * FROM tag");
        $rows = $stmt->rowCount();
        if($rows > 0) 
        {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function check_if_tag_exists($tag_name)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM tag WHERE name = ?");
        $stmt->execute([$tag_name]);
        $exists = $stmt->rowCount();
        if($exists > 0)
        {
            $_SESSION['msg'] = "Diesen Namen gibt es bereits.";
            $_SESSION['msg_tag'] = 'ERROR';
            return true;
        }
        else
        {
            return false;
        }
    }

    public function save_tag($tag_id, $tag_name)
    {
        if($tag_id === 0)
        {
            // insert
            $stmt = $this->pdo->prepare("INSERT INTO tag (name) VALUES (?)");
            $stmt->execute([$tag_name]);
            $_SESSION['msg'] = "Der neue Tag wurde erfolgreich gespeichert.";
            $_Session['msg_type'] = "SUCCESS";
        }
        else 
        {
            // update
            $stmt = $this->pdo->prepare("UPDATE tag SET name = ? WHERE tag_id = ?");
            $stmt->execute([$tag_name, $tag_id]);
            $_SESSION['msg'] = "Die Änderung wurde erfolgreich gespeichert.";
            $_Session['msg_type'] = "SUCCESS";
        }
    }
}