<?php
class Database {
    private $host = "localhost";
    private $db = "mh_office";
    private $user = "root";
    private $password = "";
    private $con;

    public function __construct() {
        try {
            $this->con = new PDO("mysql:dbname={$this->db};host={$this->host}", $this->user, $this->password);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connected successfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit;
        } 
    }

    public function getConnection() {
        return $this->con;
    }
}
?>
