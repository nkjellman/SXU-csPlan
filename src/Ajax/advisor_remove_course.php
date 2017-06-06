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
        if ($DI->Resolve('ICourseService')->RemoveCourse($_SESSION['net_id'], $obj, $pdo)) {
            echo json_encode(array("Valid"=>true));
        } 
        else {
            throw new Exception("Error deleting record");
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(new JSONException($e));
    }
}
