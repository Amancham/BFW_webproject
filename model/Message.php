<?php
require_once 'vendor/autoload.php';
class Message
{
    private $message;
    private $type;

    public function __construct($message, $type)
    {
        $this->message = $message;
        $this->type = $type;
    }

    public function getMessage()
    {
        return $this->message;
    }
    public function getType()
    {
        return $this->type;
    }
}