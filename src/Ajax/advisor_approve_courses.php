<?php
require_once __DIR__.'/../project.properties.php';
if (session_status() == PHP_SESSION_NONE) {
        session_start();
}
header("Content-Type: application/json");
try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $obj = json_decode(file_get_contents('php://input'), true);
        if (!is_null($obj)) {
            $pdo = $DI->Resolve("PDO");
            if ($DI->Resolve("ICourseService")->ApproveCourses($_SESSION['net_id'], $obj, $pdo)) {
                echo json_encode(array("Valid"=> true));
            } else {
                throw new Exception("Critical failure :(");
            }
        }
    }
} catch (Exception $e) {
         echo json_encode(new JSONException($e));
}
