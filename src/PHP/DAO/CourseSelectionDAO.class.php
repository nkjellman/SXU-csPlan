<?php
require_once PROJECT_ROOT . 'PHP/Models/CourseSelection.class.php';
require_once 'BaseDAO.class.php';
class CourseSelectionDAO extends BaseDAO
{
    public function __construct(PDO &$pdo)
    {
        parent::__construct($pdo);
    }
    
    /**
     *
     * @param CourseSelection $model
     * @return type
     */
    public function Create($model)
    {
        $return = array();
        foreach ($model->getCourses() as $courses) {
            array_push($return, parent::Execute('INSERT INTO course_selections (net_id, course_id, '
                . 'year, semester, preference, st_comment, approved) '
                . 'VALUES(?, ?, ?, ?, ?, ?, ?);',
                array($model->getNetId(), $courses->getId(), $courses->getYear(),
                    $courses->getSemester(), (int) $courses->getPreference(), $courses->getComment(),
                    0)));
        }
      
        return $return;
    }
    
    /**
     *
     * @param CourseSelection $model
     * @return type
     */
    public function Delete($model)
    {
        $return = array();
        foreach ($model->getCourses() as $courses) {
            array_push($return, parent::Execute('DELETE FROM course_selections '
                . 'WHERE net_id=? AND course_id = ? AND year = ? AND semester = ?',
                array($model->getNetId(), $courses->getId(), $courses->getYear(),
                    $courses->getSemester())));
        }
        return $return;
    }
    
    /**
     *
     * @param CourseSelection $model
     * @return type
     */
    public function Update($model)
    {
        return parent::Execute('UPDATE course_selections SET net_id=?, course_id=?, '
                . 'year=?, semester=?, preference=?, st_comment=?, approved=? WHERE '
                . 'net_id=? AND course_id=? AND year=? AND semester=?;', array(
                    $model->getNetId(), $model->getCourses()[0]->getId(), $model->getCourses()[0]->getYear(),  $model->getCourses()[0]->getSemester(),
                (int)$model->getCourses()[0]->getPreference(),  $model->getCourses()[0]->getComment(), $model->getCourses()[0]->getApproved(),
                    $model->getNetId(), $model->getCourses()[0]->getId(),  $model->getCourses()[0]->getYear(), $model->getCourses()[0]->getSemester(),
                ));
    }//end Update
    
    public function QueryMatch($stmt, $model)
    {
       
        if (is_null($model)) {
            throw new InvalidArgumentException("Null exception");
        }
        $sql = "$stmt WHERE 1=1 ";
        
        if ($model->getNetId() !== null) {
            $sql .= "AND net_id = '".$model->getNetId(). "' ";
        }
        if ($model->getCourses() !== null && count($model->getCourses()) > 0) {
            $courses = $model->getCourses();
            $countCourses = count($courses);
            $sql .= "AND (course_id = '".$courses[0]->getId()."' ";
            if ($countCourses > 1) {
                for ($i=1; $i < $countCourses; $i++) {
                    $sql .= "OR course_id = '".$courses[$i]->getId()."' ";
                }
            }
                $sql .= ")";
        }
        return $sql;
    }
    public function Read($model, $fetch, $stmt = null, $result = null)
    {
        if ($stmt == null) {
            $stmt = 'SELECT * FROM course_selections';
        }
        if ($result == null) {
            $result = parent::Fetch($this->QueryMatch($stmt, $model), $fetch);
        }
        if ($result === false) {
              return null;
        }
        switch ($fetch) {
            case parent::Single:
                return $model->setNetId($result['net_id'])
                             ->setCourse(array(Courseselection::CreateSelection((int)$result['course_id'], (int) $result['year'], $result['semester'], (bool)$result['preference'], $result['st_comment'], (bool)$result['approved'])));
            case parent::All:
                $returnArr = array();
                $array = array();
                foreach ($result as $row) {
                    if (!array_key_exists($row['net_id'], $array)) {
                        $array[$row['net_id']] = array();
                    }
                    array_push($array[$row['net_id']], CourseSelection::CreateSelection((int)$row['course_id'], (int) $row['year'], $row['semester'], (bool)$row['preference'], $row['st_comment'], (bool)$row['approved']));
                }
                foreach ($array as $student => $courseArr) {
                    $advisor = new Student();
                    array_push($returnArr, $advisor->setNetId($student)->setCourses($courseArr));
                }
                return $returnArr;
            default:
                throw new InvalidArgumentException("You're not supposed to be here...");
        }//end switch
    }//end Read
}//end class
