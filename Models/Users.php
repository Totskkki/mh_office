<?php
class User {
    private $db;
    private $con;

    public function __construct(Database $db) {
        $this->db = $db;
        $this->con = $this->db->getConnection();
        session_start();
    }

    public function login($loginInput, $password) {
        $stmt = $this->con->prepare("SELECT user.*, personnel.*, position.*, user.UserType 
                                     FROM tbl_users AS user
                                     LEFT JOIN tbl_personnel AS personnel ON user.personnel_id = personnel.personnel_id
                                     LEFT JOIN tbl_position AS position ON position.personnel_id = position.position_id
                                     WHERE user.user_name = ? OR personnel.email = ? LIMIT 1");
        $stmt->execute([$loginInput, $loginInput]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $userID = $result['userID'];
            $failedAttempts = (int)($result['failed_attempts'] ?? 0);
            $lastAttemptTime = isset($result['last_attempt_time']) ? new DateTime($result['last_attempt_time']) : new DateTime();

            $currentTime = new DateTime();
            $lockoutTime = 5 * 60; // 5 minutes in seconds

            if ($failedAttempts >= 3 && ($currentTime->getTimestamp() - $lastAttemptTime->getTimestamp()) < $lockoutTime) {
                return 'Account locked. Please try again after 5 minutes.';
            }

            if (password_verify($password, $result['password'])) {
                session_regenerate_id(true);
                $this->resetFailedAttempts($userID);

                $_SESSION['user_id'] = $result['userID'];
                $_SESSION['first_name'] = $result['first_name'];
                $_SESSION['last_name'] = $result['lastname'];
                $_SESSION['user_name'] = $result['user_name'];
                $_SESSION['profile_picture'] = $result['profile_picture'];
                $_SESSION['login'] = true;
                $_SESSION['status'] = "Login successful!";
                $_SESSION['status_code'] = "success";
                $_SESSION['user_type'] = $result['UserType'];

                $this->logUserLogin($userID, $result['user_name'], $_SERVER['REMOTE_ADDR'], 1);

                return $this->redirectBasedOnUserType($_SESSION['user_type']);
            } else {
                $failedAttempts++;
                $this->incrementFailedAttempts($userID, $failedAttempts);
                $this->logUserLogin(null, $loginInput, $_SERVER['REMOTE_ADDR'], 0);

                return $failedAttempts >= 3 ? 'Account temporarily locked. Please try again after 5 minutes.' : 'Incorrect username or password.';
            }
        } else {
            return 'Incorrect username or password.';
        }
    }

    private function resetFailedAttempts($userID) {
        $stmt = $this->con->prepare("UPDATE tbl_users SET failed_attempts = 0, last_attempt_time = NULL WHERE userID = ?");
        $stmt->execute([$userID]);
    }

    private function incrementFailedAttempts($userID, $failedAttempts) {
        $stmt = $this->con->prepare("UPDATE tbl_users SET failed_attempts = ?, last_attempt_time = NOW() WHERE userID = ?");
        $stmt->execute([$failedAttempts, $userID]);
    }

    private function logUserLogin($userID, $username, $user_ip, $status) {
        $logQuery = "INSERT INTO tbl_user_log (userID, username, user_ip, status) VALUES (?, ?, ?, ?)";
        $stmtLog = $this->con->prepare($logQuery);
        $stmtLog->execute([$userID, $username, $user_ip, $status]);
    }

    private function redirectBasedOnUserType($userType) {
        switch ($userType) {
            case 'RHU':
                header("Location: RHU/dashboard-mho.php");
                exit;
            case 'BHW':
                header("Location: home.php");
                exit;
            case 'admin':
                header("Location: admin/dashboard.php");
                exit;
            default:
                return 'Unknown user type';
        }
    }

    public function sessionCheck() {
        if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
            $this->redirectBasedOnUserType($_SESSION['user_type']);
        }
    }

    public function sessionTimeout($timeoutDuration = 3600) {
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeoutDuration) {
            session_unset();
            session_destroy();
            echo "<script>alert('Your session has expired. Please log in again.');</script>";
            echo "<script>window.location = './index.php';</script>";
            exit;
        }
        $_SESSION['LAST_ACTIVITY'] = time();
    }
    public function logout() {
        if (isset($_SESSION['user_id'])) {
            $ldate = date('d-m-Y h:i:s A', time());

            // Update the user's log record with logout time
            $stmt = $this->con->prepare("UPDATE tbl_user_log SET logout = :logout WHERE userID = :uid ORDER BY logID DESC LIMIT 1");
            $stmt->bindParam(':logout', $ldate);
            $stmt->bindParam(':uid', $_SESSION['user_id']);
            $stmt->execute();

            // Clear the session
            $_SESSION = array();
            session_destroy();

            // Set a message for successful logout
            session_start(); // Restart session to set the message
            $_SESSION['errmsg'] = "You have successfully logged out.";

            // Redirect to login page
            header("Location: index.php");
            exit();
        } else {
            // Redirect if user is not logged in
            header("Location: index.php");
            exit();
        }
    }
    public function getAffectedRecordName($table, $recordId)
    {
        switch ($table) {
            case 'tbl_patients':
                $stmt = $this->con->prepare("SELECT patient_name FROM tbl_patients WHERE patient_id = ?");
                $stmt->execute([$recordId]);
                $result = $stmt->fetch();
                return $result['patient_name'] ?? 'Unknown';
            // Add other cases for additional tables if needed
            default:
                return 'Unknown';
        }
    }

    public function logAuditTrail($userId, $action, $description, $table, $recordId)
    {
        // Get IP address
        $ipAddress = $_SERVER['REMOTE_ADDR'];

        // Insert into audit trail
        $stmt = $this->con->prepare("INSERT INTO audit_trail (user_id, action, description, affected_table, affected_record_id, ip_address) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$userId, $action, $description, $table, $recordId, $ipAddress]);
    }
}
?>
