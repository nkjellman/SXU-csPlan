<?php
require_once '../project.properties.php';
header("Content-Type: application/json");
if (session_status() == PHP_SESSION_NONE) {
      session_start();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $obj = json_decode(file_get_contents('php://input'), true);
        $pdo = $DI->Resolve("PDO");
        $response=$DI->Resolve('ICourseService')->AddCourse($_SESSION['net_id'], $obj, $pdo);
        if (!is_null($response)) {
            echo json_encode($response);
        } else {
            throw new Exception("Error updating record");
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(new JSONException($e));
    }
}
