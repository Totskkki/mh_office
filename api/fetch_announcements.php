<?php
require_once 'database.php';

class AnnouncementFetcher
{
    private $conn;


    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAnnouncement()
    {
        try {
            $query = "SELECT `announceID`, `date`, `title`, `details`, `created_at`, `updated_at` FROM `tbl_announcements` ORDER BY `announceID` DESC";
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
}

header('Content-Type: application/json');


$Announcementfetch = new AnnouncementFetcher();

if (isset($_GET['fetch']) && $_GET['fetch'] == 'announcements') {

    $Announcementfetch->getAnnouncement();
} else {
    echo json_encode(['error' => 'Invalid request']);
}
