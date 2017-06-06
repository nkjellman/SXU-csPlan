<?php

require __DIR__ . '/../PHP/DAO/CourseSelectionDAO.class.php';
require __DIR__ . '/../PHP/DAO/CourseSelection.CoursesDAO.php';
require_once __DIR__ . '/../PHP/DependencyInjection/DI.php';

//this should not be a private method in the ajax call.  
//It should be converted to a service.
/**
 * displays all the courses the student has selected 
 * @param string $id
 * @return json
 */
function selectPlan($u, $c) {
    //the user has the correct permissions then go ahead and execute the query 
    if ($u->permissions == AccountTypes::Student) {
        $plan = new CourseSelectionCoursesDAO($c);
        $pl = $plan->planQuery($u->net_id);
        echo json_encode($pl);
    }
}
//here is another comment for Jorge.
//end selectPlan
//takes the di container and creates a pdo and autheticates the user
try {
    $DI = DI::RegisterTypes();
    $conn = $DI->resolve("PDO");
    $auth = $DI->resolve('MockAuthorizationService');
    $user = $auth->getLoggedInUser();
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
selectPlan($user, $conn);
?>

