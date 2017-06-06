<?php
require_once __DIR__.'\..\project.properties.php';
header("Content-Type: application/json");
if (session_status() == PHP_SESSION_NONE) {
      session_start();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $obj = json_decode(file_get_contents('php://input'), true);
        $pdo = $DI->Resolve("PDO");
        echo json_encode($DI->Resolve("ICourseService")->GetUnapprovedCourseOfferingsUnderStudent($_SESSION['net_id'], $obj['net_id'], $pdo));
    } catch (Exception $e) {

    }
}
