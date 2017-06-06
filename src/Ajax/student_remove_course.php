<?php
require_once __DIR__.'/../project.properties.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header("Content-Type: application/json");
    $obj = json_decode(file_get_contents('php://input'), true);
    if ($obj != null) {
        try {
            $pdo = $DI->resolve("PDO");
            echo json_encode($DI->resolve("ICourseService")->RemoveCoursesFromSelection($_SESSION['net_id'], $obj, $pdo));
        } catch (Exception $e) {
            echo json_encode(new JSONException($e));
        }
    }
}