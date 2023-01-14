<?php
include_once("./util.php");
class DB_Connector
{
    var $pdo;

    function __construct()
    {
        $dsn = "mysql:host=" . util::$DBHOST . ";dbname=" . util::$DBNAME . "";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        try {
           $this->pdo = new PDO($dsn, util::$USERNAME, util::$PASS, $options);
            // echo "DB Connection successfully ! \n";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function connectDB(){
        return $this->pdo;
    }
    public function closeDB(){
        $this->pdo = null;
    }
}

?>