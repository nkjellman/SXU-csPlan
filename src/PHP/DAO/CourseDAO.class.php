<?php
require_once PROJECT_ROOT. 'PHP/Models/Course.class.php';
require_once PROJECT_ROOT. 'PHP/Models/Department.class.php';

require_once 'BaseDAO.class.php';

class CourseDAO extends BaseDAO {
     public function __construct(PDO &$pdo)
    {
        parent::__construct($pdo);
    }
  
    public function Create($model)
    {
        return parent::Execute("INSERT INTO courses (course_num, dept_id, name, credit_hours, elective, description) VALUES (?, ?, ?, ?, ?, ?);",
                           array($model->getNumber(), $model->getDepartment()->getId(), $model->getName(), $model->getCredits(), (int)$model->isElective(), $model->getDescription()));
    }
    public function Delete($model)
    {
        return parent::Execute($this->QueryMatch("DELETE FROM courses", $model));
    }
    protected function QueryMatch($stmt, $model)
    {
        if (is_null($model)) {
            throw new InvalidArgumentException("Null exception");
        }
        $sql = "$stmt WHERE 1=1 ";
        if ($model->getId() !== null) {
            $sql .= "AND course_id = ".$model->getId()." ";
        }
        if ($model->getNumber() !== null) {
                $sql .= "AND course_num = '".$model->getNumber()."' ";
            }
        if ($model->getDepartment() !== null && $model->getDepartment()->getId() !== null) {
            $sql .= "AND dept_id = ".$model->getDepartment()->getId()." ";
        }
        if ($model->getName() !== null) {
            $sql .= "AND name = '".$model->getName()."' ";
        }
        if ($model->getCredits() !== null) {
            $sql .= "AND credit_hours = '".$model->getCredits()."' ";
        }
        if ($model->isElective() !== null) {
            $sql .= "AND elective = '".(int)$model->isElective()."' ";
        }
        if ($model->getDescription() !== null) {
            $sql .= "AND description = '".$model->getDescription()."' ";
        }

        return $sql;
    }
    public function Read($model, $fetch, $stmt = NULL, $result = NULL)
    {
        if ($stmt == null) {
             $stmt = "SELECT * FROM courses";
        }
        if ($result == null) {
            if ($model != null) {
                $result = parent::Fetch($this->QueryMatch($stmt, $model), $fetch);
            }
            else return null;
        }
        switch ($fetch) {
            case parent::Single:
            if($result === false) return null;
                $model->setId((int)$result['course_id'])
                      ->setNumber((int)$result['course_num'])
                      ->setName($result['name'])
                      ->setDepartment(Department::GetDepartment((int)$result['dept_id']))
                      ->setCredits((int) $result['credit_hours'])
                      ->setElective((bool) $result['elective']);
                
                if (!is_null($result['description'])) {
                    $model->setDescription($result['description']);
                }
                return $model;
            case parent::All:
                $array = array();
                foreach ($result as $row) {
                    array_push($array, Course::CreateCourse((int)$row['course_id'], $row['name'], Department::GetDepartment((int)$row['dept_id']), 
                                                    array_key_exists('credit_hours',$row) ? (int) $row['credit_hours'] : null, (int) $row['course_num'],
                                                    array_key_exists('elective',$row) ? (bool) $row['elective'] : null,
                                                    array_key_exists('description',$row) ?  $row['description'] : null));
                }
                return $array;
            default:
                throw new InvalidArgumentException("You're not supposed to be here...");
        }
    }
    public function Update($model)
    {
        return parent::Execute("UPDATE courses SET course_num=?, dept_id=?, name=?, credit_hours=?, elective=?, description=? WHERE course_id=?;",
                               array($model->getNumber(), $model->getDepartment()->getId(), $model->getName(),  $model->getCredits(), (int)$model->isElective(), $model->getDescription(), $model->getId()));
    }
}