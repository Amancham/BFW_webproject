<?php 
class Tag 
{
    private $tag_id;
    private $tag_name;

    public function __construct($tag_id, $tag_name) 
    {
        $this->tag_id = $tag_id;
        $this->tag_name = $tag_name;
    }

    public function getTag_id()
    {
        return $this->tag_id;
    }
    public function getTag_name()
    {
        return $this->tag_name;
    }
    public function setTag_name($tag_name)
    {
        $this->tag_name = $tag_name;
    }
}