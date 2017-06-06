<?php
require_once __DIR__.'/../project.properties.php';
require_once PROJECT_ROOT . 'PHP/Models/Enums/AccountType.enum.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
header("Content-Type: application/json");
try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $obj = json_decode(file_get_contents('php://input'), true);
        if (!is_null($obj)) {
            $pdo = $DI->Resolve("PDO");
            if ($DI->Resolve("IUserService")->AddStudentRecord($_SESSION['net_id'], $obj, $pdo)) {
                echo json_encode(array("Valid"=> true));
            } else {
                throw new Exception("Critical failure :(");
            }
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $pdo = $DI->Resolve("PDO");
        if ($DI->Resolve("IUserService")->HasRecord($_SESSION["net_id"], $pdo)) {
            echo json_encode(array("First"=> false));
        } else {
            echo json_encode(array("First"=> true,"Advisers" => $DI->Resolve("IUserService")->GetAdvisorNames($_SESSION["net_id"], $pdo)));
        }
    }
} catch (Exception $e) {
         echo json_encode(new JSONException($e));
}
