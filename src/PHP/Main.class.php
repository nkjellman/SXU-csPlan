<?php
require_once '../project.properties.php';
require_once PROJECT_ROOT . 'PHP/DAO/AccountDAO.class.php';
require_once PROJECT_ROOT . 'PHP/DAO/AdvisingDAO.class.php';
require_once PROJECT_ROOT . 'PHP/DAO/BaseDAO.class.php';
require_once PROJECT_ROOT . 'PHP/DAO/CourseOfferingsDAO.class.php';
require_once PROJECT_ROOT . 'PHP/DAO/CourseDAO.class.php';
require_once PROJECT_ROOT . 'PHP/Models/Account.class.php';
require_once PROJECT_ROOT . 'PHP/Models/Student.class.php';
require_once PROJECT_ROOT . 'PHP/Models/Advisor.class.php';
require_once PROJECT_ROOT . 'PHP/Models/Course.class.php';
require_once PROJECT_ROOT . 'PHP/Models/Name.class.php';
require_once PROJECT_ROOT . 'PHP/Service/UserService.class.php';
require_once PROJECT_ROOT . 'PHP/Service/CourseService.class.php';
require_once PROJECT_ROOT . 'PHP/DAO/Queries/SearchCoursesQuery.class.php';
require_once PROJECT_ROOT . 'PHP/DAO/Queries/GetTotalCreditsQuery.class.php';
require_once PROJECT_ROOT . 'PHP/DAO/Queries/StudentsPendingApprovalQuery.class.php';
$pdo = $DI->Resolve("PDO");

$accountDAO = new AccountDAO($pdo);
$account = new Account();
var_dump($accountDAO->Create($account->setNetId('ma03601')->setName(new Name('Mustafa', 'Abdul-Kader'))->setEmail("email@email.com")->setType(1)));
print_r($pdo->errorInfo());
//test playground :=)-
