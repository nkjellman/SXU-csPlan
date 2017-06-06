<?php
require_once PROJECT_ROOT . 'PHP/Models/CourseOffering.class.php';
require_once 'BaseDAO.class.php';

class CourseOfferingsDAO extends BaseDAO
{
    
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
    }
    
    public function Create($m)
    {
        return parent::Execute('INSERT INTO course_offerings (course_id, year, semester) '
                . 'VALUES(?, ?, ?);', array($m->getId(), $m->getYear(), $m->getSemester()));
    }//end Create()
    
    public function Delete($m)
    {
        return parent::Execute($this->QueryMatch('DELETE FROM course_offerings',
                $m));
    }//end Delete()
    
    /**
     * updates the specified course_offerings
     * @param CourseOfferings $m
     * @return type
     */
    public function Update($m)
    {
        return parent::Execute('UPDATE course_offerings SET course_id = ?, year=?'
                . ' semester = ? WHERE course_id = ? AND year = ? AND semester=?',
                array($m->getId(), $m->getYear(), $m->getSemester(), $m->getId(),
                    $m->getYear(), $m->getSemester()));
    }//end update()
    
    public function QueryMatch($stmt, $model)
    {
        if (is_null($model)) {
            throw new InvalidArgumentException("Null exception");
        }
        $sql = "$stmt WHERE 1=1 ";
        if ($model->getId() !== null) {
            $sql .= "AND course_id = ".$model->getId()." ";
        }
        if ($model->getYear() !== null) {
            $sql .= "AND year= ".$model->getYear()." ";
        }
        if ($model->getSemester() !== null) {
            $sql .= "AND semester = '".$model->getSemester()."' ";
        }
        return $sql;
    }//end QueryMatch()
    
    public function Read($model, $fetch, $stmt = null, $result = null)
    {
        if ($stmt == null) {
             $stmt = "SELECT * FROM course_offerings";
        }
        if ($result == null) {
            if ($model != null) {
                $result = parent::Fetch($this->QueryMatch($stmt, $model), $fetch);
            } else {
                return null;
            }
        }
        switch ($fetch) {
            case parent::Single:
                $model->setId((int)$result['course_id'])
                      ->setYear((int)$result['year'])
                      ->setSemester($result['semester']);
                    if (array_key_exists('total',$result)) {                      
                    $course->setTotal((int) $result['total']);
                } else if(array_key_exists('students',$result)) {
                    $course->setTotal((int) $result['students']);
                }   
                return $model;
            case parent::All:
                $arr = array();
                foreach ($result as $row) {
                    $course = new CourseOffering();
                    $course->setId((int)$row['course_id'])
                          ->setYear((int)$row['year'])
                          ->setSemester($row['semester']);
                    array_push($arr, $course);
                    if (array_key_exists('total',$row)) {
                        $course->setTotal((int) $row['total']);
                    } else if(array_key_exists('students',$row)) {
                    $course->setTotal((int) $row['students']);
                }  
                }//end foreach
                return $arr;
            default:
                throw new InvalidArgumentException("You're not supposed to be here...");
        }//end switch
    }//end Read
}//courseOfferingsDao
