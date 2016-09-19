<?php 
session_start();
class Gateway {
    public $dbh;
    private static $instance;
    
    private function __construct() {
        $config = parse_ini_file('db.ini');
        //echo $config['host'].$config['db_name'].$config['user'].$config['pass'];
        $connString = 'mysql:'.'host='.$config['host'].';'.'dbname='.$config['db_name'];

        $user = $config['user'];
        $password = $config['pass'];
        
        try {
            $this->dbh = new PDO($connString, $user, $password);    
        } catch (PDOException $e) {
            echo "There was an error connecting to the database. Please check back later.";
        }
        
    }
    
    public static function getInstance() {
        if (!isset(self::$instance)) {
            $obj = __CLASS__;
            // Instantiate an instance of this class
            self::$instance = new $obj;
        }
        // return instance of self
        return self::$instance;
    }
}


?>