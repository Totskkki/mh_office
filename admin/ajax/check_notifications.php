<?php 
	include '../config/connection.php';


    try {
        $today = date('Y-m-d');
        
        // Query for unread notifications
        $query = "
            SELECT COUNT(*) AS total 
            FROM `tbl_doctor_schedule`
            WHERE 
                (`is_available` = 2 AND `date_schedule` >= :today)
                OR (`leave_start_date` IS NOT NULL AND `leave_end_date` IS NOT NULL AND `leave_end_date` >= :today)
                AND `is_available` NOT IN (3, 4)
                AND `notified` = 0
        ";
        $stmt = $con->prepare($query);
        $stmt->execute(['today' => $today]);
        $unreadCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
        // Mark notifications as read
        if ($unreadCount > 0) {
            $updateQuery = "
                UPDATE `tbl_doctor_schedule`
                SET `notified` = 1
                WHERE 
                    (`is_available` = 2 AND `date_schedule` >= :today)
                    OR (`leave_start_date` IS NOT NULL AND `leave_end_date` IS NOT NULL AND `leave_end_date` >= :today)
                    AND `is_available` NOT IN (3, 4)
                    AND `notified` = 0
            ";
            $updateStmt = $con->prepare($updateQuery);
            $updateStmt->execute(['today' => $today]);
        }
    
        echo json_encode(['success' => true, 'count' => $unreadCount]);
    } catch (PDOException $ex) {
        echo json_encode(['success' => false, 'message' => $ex->getMessage()]);
    }