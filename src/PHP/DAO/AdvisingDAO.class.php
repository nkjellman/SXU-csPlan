<?php
require_once PROJECT_ROOT . 'PHP/Models/Advisor.class.php';
require_once 'BaseDAO.class.php';

class AdvisingDAO extends BaseDAO
{

    public function __construct(PDO &$pdo)
    {
        parent::__construct($pdo);
    }
  
    public function Create($model)
    {
        if ($model instanceof Advisor) {
            $returnValues = array();
            foreach ($model->getStudents() as $student) {
                array_push($returnValues,
                   parent::Execute("INSERT INTO advising (student, advisor) VALUES (?, ?);",
                                   array($student,$model->getNetId())));
                    return $returnValues;
            }
        }
    }
    public function Delete($model)
    {
        return parent::Execute($this->QueryMatch("DELETE FROM advising", $model));
    }
    protected function QueryMatch($stmt, $model)
    {
        if (is_null($model)) {
            throw new InvalidArgumentException("Null exception");
        }
        $sql = "$stmt WHERE 1=1 ";
        if ($model->getNetId() !== null) {
            $sql .= "AND advisor = '".$model->getNetId()."' ";
        }
        if ($model->getStudents() !== null && count($model->getStudents()) > 0) {
            $students = $model->getStudents();
            $countStudents = count($students);
            if ($countStudents > 1) {
                $sql .= "AND (student = '".$students[0]->getNetId()."' ";
                for ($i=1; $i < $countStudents; $i++) {
                    $sql .= "OR student = '".$students[$i]->getNetId()."' ";
                }
                $sql .= ")";
            } else {
                $sql .= "AND student = '".$students[0]->getNetId()."' ";
            }
        }
        
        return $sql;
    }
    public function Read($model, $fetch, $stmt = null, $result = null)
    {
        if ($stmt == null) {
             $stmt = "SELECT * FROM advising";
        }
        if ($result == null) {
            if ($model != null) {
                $result = parent::Fetch($this->QueryMatch($stmt, $model), $fetch);
            } else {
                return null;
            }
        }
        if (count($result) === 0 || $result === false) {
            return null;
        }
        switch ($fetch) {
            case parent::Single:
                $student = new Student();
                return $model->setNetId($result['advisor'])
                             ->addStudent($student->setNetId($result['student']));
            case parent::All:
                $returnArr = array();
                $array = array();
                foreach ($result as $row) {
                    $student = new Student();
                    $student->setNetId($row['student']);
                    if (!array_key_exists($row['advisor'], $array)) {
                        $array[$row['advisor']] = array();
                    }
                    array_push($array[$row['advisor']], $student);
                }
                foreach ($array as $adv => $studentArr) {
                    $advisor = new Advisor();
                    array_push($returnArr, $advisor->setNetId($adv)->setStudents($studentArr));
                }
                return $returnArr;
            default:
                throw new InvalidArgumentException("You're not supposed to be here...");
        }
    }
    public function Update($model)
    {
        throw new BadMethodCallException();
    }
}
