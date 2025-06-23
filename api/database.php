


<?php
date_default_timezone_set('Asia/Manila'); 
class Database {
    
    // Database credentials
    private $host = 'localhost'; 
    private $db_name = 'u926430213_mh_office'; 
    private $username = 'u926430213_totski';
    private $password = 'Joven261993@'; 
    private $conn;

    // Get the database connection
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
          
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
