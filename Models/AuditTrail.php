<?php

class AuditTrail {
    private $con;

    public function __construct($db) {
        $this->con = $db;
    }

    public function logAuditTrail($userId, $action, $description, $table, $recordId) {
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $query = "INSERT INTO audit_trail (user_id, action, description, affected_table, affected_record_id, ip_address) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->con->prepare($query);
        $stmt->execute([$userId, $action, $description, $table, $recordId, $ipAddress]);
    }
}
