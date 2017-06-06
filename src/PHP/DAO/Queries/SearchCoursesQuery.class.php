<?php
require_once 'IQuery.interface.php';
require_once PROJECT_ROOT . 'PHP/Models/Department.class.php';
require_once PROJECT_ROOT . 'PHP/Models/CourseOffering.class.php';
class SearchCoursesQuery implements IQuery
{
    private $Course;
    public function __construct($year, $semester, $name, $number, $dept)
    {
        if(!is_int($year) && !is_null($year)) throw new InvalidArgumentException("Invalid year");
        if(!is_string($semester) && !is_null($semester)) throw new InvalidArgumentException("Invalid Semester");
        if(!is_string($name) && !is_null($name)) throw new InvalidArgumentException("Invalid name");
        if(!is_int($number) && !is_null($number)) throw new InvalidArgumentException("Invalid numer");
        if(!($dept instanceof Department) && !is_null($dept)) throw new InvalidArgumentException("Invalid department");

        $this->Course = new CourseOffering();
        if(!is_null($year)) $this->Course->setYear($year);
        if(!is_null($semester)) $this->Course->setSemester($semester);
        if(!is_null($name)) $this->Course->setName($name);
        if(!is_null($number)) $this->Course->setNumber($number);
        if(!is_null($dept)) $this->Course->setDepartment($dept);
    }
    public function getQuery(&$pdo)
    {
        $stmt = $pdo->prepare("CALL spSearchCourses(?, ?, ?, NULL, ?, ?)");
        $stmt->execute(array($this->Course->getYear(),$this->Course->getSemester(),$this->Course->getName(),$this->Course->getNumber(),is_null($this->Course->getDepartment()) ? null : $this->Course->getDepartment()->getAbbreviation()));
        return $stmt;
    }
}
