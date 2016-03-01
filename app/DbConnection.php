<?php

namespace SierraSql;

use Noodlehaus\Config;
use PDO;
use PDOException;
use FluentPDO;

class DbConnection
{
    public $fpdo;
    private static $instance = null;

    private function __construct($production = true)
    {
        $db_configs = Config::load('../app/config/database.php');

        if($production) {
            $db_config = $db_configs['production'];
        } else {
            $db_config = $db_configs['training'];
        }

        $host   = $db_config['db_host'];
        $port   = $db_config['db_port'];
        $user   = $db_config['db_user'];
        $pwd    = $db_config['db_password'];
        $db     = $db_config['db_db'];

        try {
            $pdo = new PDO("pgsql:dbname=$db;host=$host;port=$port", $user, $pwd);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->fpdo = new FluentPDO($pdo);   
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

    }
    
    public static function connect($production = true)
    {
        if(self::$instance == null) {
            self::$instance = new DbConnection($production);
        }
        
        return self::$instance;
    }
    
    public function logQuery()
    {
        $this->fpdo->debug = function($BaseQuery) {
        	echo "query: " . $BaseQuery->getQuery(false) . "<br>";
        	echo "parameters: " . implode(', ', $BaseQuery->getParameters()) . "<br>";
        	echo "rowCount: " . $BaseQuery->getResult()->rowCount() . "\n";
        };         
    }    

}