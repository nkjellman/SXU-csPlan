<?php
interface IUserService {
    function AddStudentRecord($netId, $obj, &$pdo);
    function GetAdvisorNames($netId,&$pdo);
    function HasRecord($netId, &$pdo);
    function GetAllUsers($netId,&$pdo);
    function GetUser($netId,&$pdo);
    function UpdateImage($netId, $image, $pdo);
    function GetStudentsForAdvisor($netId, $type, &$pdo);
}