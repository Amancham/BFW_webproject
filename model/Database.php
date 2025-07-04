<?php 
define('SECURE_ACCESS', true);
$CONFIGS = include_once('assets/config');

class Database 
{
    private static $PDOINSTANCE;

    private function __construct() 
    {
        
    }

    public static function getPdo() 
    {
        if(!self::$PDOINSTANCE)
        {
            // create PDO 
            self::$PDOINSTANCE = new PDO("mysql:host=".$CONFIGS['HOST']."; dbname=".$CONFIGS['DB']."", $CONFIGS['USER'], $CONFIGS['PWD']);
        }
        else 
        {
            return self::$PDOINSTANCE;
        }
    }
}