<?php 
define('SECURE_ACCESS', true);

class Database 
{
    protected static $PDOINSTANCE;

    private function __construct() 
    {
        // TODO: needs fixing. ../assets/config needed for installation for some weird reason XD
        $CONFIGS = include_once('./assets/config');
        self::$PDOINSTANCE = new PDO("mysql:host=".$CONFIGS['HOST']."; dbname=".$CONFIGS['DB']."", $CONFIGS['USER'], $CONFIGS['PWD']);
    }

    public static function getInstance() 
    {
        if(!self::$PDOINSTANCE)
        {
            new Database();
            return self::$PDOINSTANCE;
        }
        else 
        {
            return self::$PDOINSTANCE;
        }
    }
}