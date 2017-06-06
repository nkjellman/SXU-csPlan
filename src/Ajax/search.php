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
   echo json_encode($DI->Resolve("ICourseService")->SearchCourses($_SESSION['net_id'],array_key_exists('Year',$_GET) ? (int) $_GET['Year'] : null,
                                                        array_key_exists('Semester',$_GET) ? $_GET['Semester'] : null,
                                                        array_key_exists('Name',$_GET) ? $_GET['Name'] : null,
                                                        array_key_exists('Number',$_GET) ? (int) $_GET['Number'] : null,
                                                        array_key_exists('Department',$_GET) ?  $_GET['Department'] : null,
                                                        array_key_exists('All',$_GET) ?  (bool) $_GET['All'] : null,
                                                        $pdo));
 }