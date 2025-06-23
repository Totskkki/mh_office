<?php
header('Content-Type: application/json');
date_default_timezone_set('Asia/Manila');

require_once 'database.php';

class ScheduleFetcher
{
    private $conn;

    // Constructor
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }


    public function getDoctorSchedule($userID)
    {
        try {
            // Prepare the query to select the required columns
            $query = "SELECT *
                      FROM tbl_doctor_schedule
                      WHERE userID = :userID 
                                      
                      ";

            // Prepare the statement
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":userID", $userID, PDO::PARAM_INT);
            $stmt->execute();

            // Fetch all schedules
            $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Check if any schedules are found
            if ($schedules) {
                foreach ($schedules as &$schedule) {

                    $schedule['date_schedule'] = $schedule['date_schedule'];
                    $schedule['leave_start_date'] = $schedule['leave_start_date'];
                    $schedule['leave_end_date'] = $schedule['leave_end_date'];

                    if (isset($schedule['schedules']) && !empty($schedule['schedules'])) {
                        $decodedSchedules = json_decode($schedule['schedules'], true);


                        if (json_last_error() === JSON_ERROR_NONE) {
                            $schedule['schedules'] = $decodedSchedules;
                        } else {

                            error_log("JSON decoding error: " . json_last_error_msg());
                            $schedule['schedules'] = [];
                        }
                    } else {

                        $schedule['schedules'] = [];
                    }
                }

                // Output the schedule data as JSON
                echo json_encode($schedules, JSON_UNESCAPED_UNICODE);
            } else {
                // If no schedules found, send 404 response
                http_response_code(404);
                echo json_encode(['error' => 'No schedules found']);
            }
        } catch (PDOException $e) {
            // Handle database errors
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        } catch (Exception $e) {
            // Handle other exceptions
            http_response_code(500);
            echo json_encode(['error' => 'Data Processing Error', 'message' => $e->getMessage()]);
        }
    }


    // Method to get availability status
    private function getAvailabilityStatus($isAvailable)
    {
        switch ($isAvailable) {
            case 0:
                return 'Not Available';
            case 1:
                return 'Available';
            case 2:
                return 'Pending';
            case 3:
                return 'Approved';
            case 4:
                return 'Rejected';
            default:
                return 'Unknown';
        }
    }


    public function getAnnouncement()
    {
        try {
            $date = date('Y-m-d');

            $query = "SELECT `announceID`, `date`, `title`, `details`, `created_at`, `updated_at` 
            FROM `tbl_announcements`
            WHERE created_at <= $date
             ORDER BY `announceID` DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log(print_r($announcements, true));

            // Return the fetched announcements as JSON wrapped in an object
            echo json_encode(['announcements' => $announcements]);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function applyForLeave($userID, $leaveDate, $message, $startTime, $endTime)
    {
        try {
            // Check if the leave date is already scheduled for the doctor
            $checkQuery = "SELECT COUNT(*) FROM tbl_doctor_schedule WHERE userID = :userID AND date_schedule = :leaveDate";
            $checkStmt = $this->conn->prepare($checkQuery);
            $checkStmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $checkStmt->bindParam(':leaveDate', $leaveDate);
            $checkStmt->execute();
            $existingScheduleCount = $checkStmt->fetchColumn();

            if ($existingScheduleCount > 0) {
                return ['success' => false, 'message' => 'Leave cannot be applied. A schedule already exists for this date.'];
            }

            // Insert leave into the schedule table
            $query = "INSERT INTO tbl_doctor_schedule (userID, date_schedule, `message`, start_time, end_time, is_available)
                      VALUES (:userID, :leaveDate, :message, :startTime, :endTime, 2)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->bindParam(':leaveDate', $leaveDate);
            $stmt->bindParam(':message', $message);
            $stmt->bindParam(':startTime', $startTime);
            $stmt->bindParam(':endTime', $endTime);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Leave applied successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to apply for leave'];
            }
        } catch (PDOException $e) {
            return ['error' => 'Database Error', 'message' => $e->getMessage()];
        }
    }

    public function countNotifications($userID)
    {
        try {
            // Query to get the count of notifications
            $query = "SELECT COUNT(*)   
                      FROM tbl_doctor_schedule 
                      WHERE userID = :userID AND (is_available = 3 OR is_available = 4)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->execute();

            // Fetch the count
            $notificationCount = $stmt->fetchColumn();

            // Return the count as a response
            return ['success' => true, 'notificationCount' => (int) $notificationCount];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Database Error: ' . $e->getMessage()];
        }
    }
    public function getpatientTodayscount()
    {

        $date = date('Y-m-d');

        $queryToday = "SELECT count(*) as `today` 
            from `tbl_patient_visits` 
            where `visit_date` = '$date';";

        $todaysCount = 0;
        $stmtToday = $this->conn->prepare($queryToday);
        $stmtToday->execute();
        $r = $stmtToday->fetch(PDO::FETCH_ASSOC);
        $todaysCount = $r['today'];

        echo json_encode(['today_patient_count' => $todaysCount]);
    }
    public function totalcheckup()
    {
        try {
            // SQL query to count total checkups and fetch complaints data where status is 'Done'
            $query = "SELECT COUNT(tbl_checkup.checkupID) as total_checkups, c.* 
                      FROM tbl_checkup
                      LEFT JOIN tbl_complaints c ON c.patient_id = tbl_checkup.patient_id
                      WHERE c.status = 'Done'
                      GROUP BY c.patient_id";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


            $response = [];


            if ($result) {
                $response = [
                    'total_checkups' => count($result),
                    'complaints' => $result
                ];
            } else {
                $response = [
                    'total_checkups' => 0,
                    'complaints' => []
                ];
            }


            echo json_encode($response);
        } catch (PDOException $e) {


            echo json_encode([
                'error' => 'Database Error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function totalAnimalbite()
    {
        $query = "SELECT COUNT(tbl_animal_bite_care.animal_biteID ) as total_bite, c.* 
                      FROM tbl_animal_bite_care
                      LEFT JOIN tbl_complaints c ON c.patient_id = tbl_animal_bite_care.patient_id
                      WHERE c.status = 'Done'
                      GROUP BY c.patient_id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $response = [];


        if ($result) {
            $response = [
                'total_bite' => count($result),
                'complaints' => $result
            ];
        } else {
            $response = [
                'total_bite' => 0,
                'complaints' => []
            ];
        }

        echo json_encode($response);
    }
    public function totalprenatal()
    {
        $query = "SELECT COUNT(tbl_prenatal.prenatalID ) as total_prenatal, c.* 
                  FROM tbl_prenatal
                  LEFT JOIN tbl_complaints c ON c.patient_id = tbl_prenatal.patient_id
                  WHERE c.status = 'Done'
                  GROUP BY c.patient_id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $response = [];


        if ($result) {
            $response = [
                'total_prenatal' => count($result),
                'complaints' => $result
            ];
        } else {
            $response = [
                'total_prenatal' => 0,
                'complaints' => []
            ];
        }

        echo json_encode($response);
    }
    public function totalbirthing()
    {
        $query = "SELECT COUNT(tbl_birth_info.birth_info_id ) as total_birth, c.* ,tbl_birth_info.birthing_status
                  FROM tbl_birth_info
                  LEFT JOIN tbl_complaints c ON c.patient_id = tbl_birth_info.patient_id
                  WHERE tbl_birth_info.birthing_status = 'done'
                  GROUP BY c.patient_id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $response = [];


        if ($result) {
            $response = [
                'total_birth' => count($result),
                'complaints' => $result
            ];
        } else {
            $response = [
                'total_birth' => 0,
                'complaints' => []
            ];
        }

        echo json_encode($response);
    }
    public function totalimmunization()
    {
        $query = "SELECT COUNT(tbl_immunization_records.immunID ) as total_vaccine, c.* 
                  FROM tbl_immunization_records
                  LEFT JOIN tbl_complaints c ON c.patient_id = tbl_immunization_records.patient_id
                  WHERE c.status = 'Done' AND c.consultation_purpose = 'Vaccination and Immunization'
                  GROUP BY c.patient_id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $response = [];


        if ($result) {
            $response = [
                'total_vaccine' => count($result),
                'complaints' => $result
            ];
        } else {
            $response = [
                'total_vaccine' => 0,
                'complaints' => []
            ];
        }

        echo json_encode($response);
    }
}


header('Content-Type: application/json');


$scheduleFetcher = new ScheduleFetcher();



if (isset($_GET['userID'])) {
    $userID = $_GET['userID'];
    $scheduleFetcher->getDoctorSchedule($userID);
} elseif (isset($_GET['fetch']) && $_GET['fetch'] == 'announcements') {

    $scheduleFetcher->getAnnouncement();
} elseif (isset($_GET['count']) && $_GET['count'] == 'patientcounttoday') {
    $scheduleFetcher->getpatientTodayscount();
} elseif (isset($_POST['action']) && $_POST['action'] == 'applyForLeave') {
    if (isset($_POST['userID'], $_POST['leaveDate'], $_POST['message'], $_POST['startTime'], $_POST['endTime'])) {
        $userID = $_POST['userID'];
        $leaveDate = $_POST['leaveDate'];
        $message = $_POST['message'];
        $startTime = $_POST['startTime'];
        $endTime = $_POST['endTime'];
        $result = $scheduleFetcher->applyForLeave($userID, $leaveDate, $message, $startTime, $endTime);

        // Send response based on the result
        echo json_encode($result);
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    }
} elseif (isset($_GET['total_checkups'])) {
    $scheduleFetcher->totalcheckup();
    
} elseif (isset($_GET['total_bite'])) {
    $scheduleFetcher->totalAnimalbite();

} elseif (isset($_GET['total_prenatal'])) {
    $scheduleFetcher->totalprenatal();


}elseif (isset($_GET['total_birth'])) {
    $scheduleFetcher->totalbirthing();

}elseif (isset($_GET['total_vaccine'])) {
    $scheduleFetcher->totalimmunization();
}
else {
    echo json_encode(['error' => 'Invalid request']);
}
