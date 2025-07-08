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

    }

    public function save_tag($tag_id, $tag_name)
    {
        
    }
}