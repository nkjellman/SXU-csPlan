<?php
require_once '/../project.properties.php';
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
header("Content-Type: application/json");
try {
    $pdo = $DI->Resolve('PDO');
    $userService = $DI->Resolve('IUserService');
    echo json_encode($userService->GetAllUsers($_SESSION['net_id'], $pdo));
} catch (Exception $ex) {
    echo json_encode(new JSONException($ex));
}
