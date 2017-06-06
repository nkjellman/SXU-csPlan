<?php
require_once '/../project.properties.php';
try {
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header("Content-Type: application/json");
    $obj = json_decode(file_get_contents('php://input'), true);
    if(is_null($obj)) {
        return;
    }
    $pdo = $DI->Resolve('PDO');
    $userService = $DI->Resolve('IUserService');
    echo json_encode($userService->ChangeRole($_SESSION['net_id'], $obj['netid'], (int)$obj['role'], $pdo));
    }
} catch (Exception $ex) {
    echo json_encode(new JSONException($ex));
}
