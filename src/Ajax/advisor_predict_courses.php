<?php
require_once '../project.properties.php';
header("Content-Type: application/json");
if (session_status() == PHP_SESSION_NONE) {
      session_start();
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $pdo = $DI->Resolve("PDO");
        echo json_encode($DI->Resolve('ICourseService')->PredictCourses($_SESSION['net_id'], $pdo));
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(new JSONException($e));
    }
}
