<?php
class UserPage {
    private $con;
    private $userID;
    private $userType;

    public function __construct($db) {
        $this->con = $db->getConnection();
        session_start();
        $this->userID = $_SESSION['user_id'];
        $this->userType = $_SESSION['user_type'];
    }

    public function getHomeImage() {
        if ($this->userType === 'BHW') {
            try {
                $stmt = $this->con->prepare("SELECT home_img FROM tbl_user_page WHERE userID = :userID");
                $stmt->bindParam(':userID', $this->userID, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result['home_img'] ?? 'default.jpg';
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return 'default.jpg';
            }
        } else {
            return 'default.jpg';
        }
    }

    public function getAnnouncements() {
        try {
            $stmt = $this->con->prepare("SELECT `announceID`, `date`, `title`, `details` FROM `tbl_announcements` ORDER BY `date` ASC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}
?>
