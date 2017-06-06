<?php
require_once '../project.properties.php';
header("Content-Type: application/json");
if (session_status() == PHP_SESSION_NONE) {
              session_start();
}
if (isset($_SESSION['id']) ? $_SESSION['id'] != session_id() : true) {
    header('location: ../Content/Index.php');
}
$pdo = $DI->Resolve("PDO");
if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
   echo json_encode($DI->Resolve("ICourseService")->getTotalCredits($_SESSION['net_id'], $pdo));

}