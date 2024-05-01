<?php

namespace App\Entity;

use PDO;

class Db
{
    // constants for database connection
    const DSN = 'mysql:dbname=a23www301;host=mysql.studev.groept.be';
    const USERNAME = "a23www301";
    const PASSWORD = "ra3wnmlO";
    private PDO $connection;
    private static Db $instance;

    private function __construct()
    {
        $this->connection=new PDO(self::DSN,self::USERNAME,self::PASSWORD);
    }
    public static function getConnection():PDO{
        if(!isset(self::$instance)){
            self::$instance=new Db();
        }
        return self::$instance->connection;
    }
}
