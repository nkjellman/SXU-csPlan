<?php
require_once '/../project.properties.php';
try {
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $obj = json_decode(file_get_contents('php://input'), true);
    if(is_null($obj)) {
        return;
    }
    $pdo = $DI->Resolve('PDO');
    $userService = $DI->Resolve('IUserService');
    echo json_encode($userService->DeleteAccount($_SESSION['net_id'],  $obj['deleted_net_id'], $pdo));
} catch (Exception $ex) {
    echo json_encode(new JSONException($ex));
}

