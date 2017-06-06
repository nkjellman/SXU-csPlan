<?php
require_once '../project.properties.php';
header("Content-Type: application/json");
session_start();
if (isset($_SESSION['id']) ? $_SESSION['id'] != session_id() : true) {
    header('location: ../Content/Index.php');
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $pdo =  $DI->Resolve("PDO");
    echo json_encode($DI->Resolve("IUserService")->GetStudentsForAdvisor($_SESSION['net_id'], $_GET['type'],$pdo));
}
