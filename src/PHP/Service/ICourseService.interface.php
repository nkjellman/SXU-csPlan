<?php
interface ICourseService
{
    function SearchCourses($netId, $year, $semester, $name, $num, $dept, $all, PDO &$pdo);
    function RemoveCourse($netId, $obj, PDO &$pdo);
    function AddCoursesToSelection($netId, $courses, PDO &$pdo);
    function RemoveCoursesFromSelection($netId, $courses, PDO &$pdo);
    function AddCourseOffering($netid, $obj, PDO &$pdo);
    function GetTotalCredits($netId, PDO &$pdo);
    function PredictCourses($netId, PDO &$pdo);
}
