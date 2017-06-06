<?php
require_once __DIR__.'/../project.properties.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header("Content-Type: application/json");
    try {
        $pdo = $DI->resolve("PDO");
        echo json_encode($DI->resolve("ICourseService")->GetCoursesFromSelection($_SESSION['net_id'], $pdo));
    } catch (Exception $e) {
        echo json_encode(new JSONException($e));
    }
}
