<?php
require_once __DIR__.'/../project.properties.php';
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
header("Content-Type: application/json");
try {
    $pdo = $DI->Resolve('PDO');
    $courseService = $DI->Resolve('ICourseService');
    echo json_encode($courseService->thisShouldHaveBeenDoneEarlier($pdo));
} catch (Exception $ex) {
    echo json_encode(new JSONException($ex));
}
