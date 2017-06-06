<?php
require PROJECT_ROOT . 'PHP/Models/Student.class.php';
class StudentDAO extends BaseDAO {
      
    public function __construct(PDO &$pdo)
    {
        parent::__construct($pdo);
    }
  
    public function Create($model)
    {
        return parent::Execute("INSERT INTO students (net_id, major_id, year, transfer) VALUES (?, ?, ?, ?);",
                           array($model->getNetId(), $model->getMajor(), $model->getYear(), $model->isTransfer()));
    }
    public function Delete($model)
    {
        return parent::Execute($this->QueryMatch("DELETE FROM students", $model));
    }
    protected function QueryMatch($stmt, $model)
    {
        if (is_null($model)) {
            throw new InvalidArgumentException("Null exception");
        }
        $sql = "$stmt WHERE 1=1 ";
        if ($model->getNetId() !== null) {
            $sql .= "AND net_id = '".$model->getNetId()."' ";
        }
        if ($model->getMajor() !== null) {
            $sql .= "AND major_id = ".$model->getMajor()." ";
        }
        if ($model->getYear() !== null) {
            $sql .= "AND year = ".$model->getYear()." ";
        }
         if ($model->isTransfer() !== null) {
            $sql .= "AND transfer = ".$model->getTransfer()." ";
        }
        return $sql;
    }
    public function Read($model, $fetch, $stmt = NULL, $result = NULL)
    {
        if($stmt == NULL) {
             $stmt = "SELECT * FROM students";
        }
        if($result == NULL) {
             $result = parent::Fetch($this->QueryMatch($stmt, $model), $fetch);
        }
        switch ($fetch) {
            case parent::Single:
                $model->setNetId($result['net_id'])
                      ->setMajor((int) $result['major_id'])
                      ->setYear((int) $result['year']);
                      if(!is_null($result['transfer'])) $model->setTransfer((bool) $result['transfer']);
                return $model;
            case parent::All:
                $array = array();
                foreach ($result as $row) {
                    $student = new Student();
                    $student->setNetId($result['net_id'])
                            ->setMajor((int) $result['major_id'])
                            ->setYear((int) $result['year']);
                      if(!is_null($result['transfer'])) $student->setTransfer((bool) $result['transfer']);
                    array_push($array,$student);
                }
                return $array;
            default:
                throw new InvalidArgumentException("You're not supposed to be here...");
        }
    }
    public function Update($model)
    {
        return parent::Execute("UPDATE students SET major_id=?, year=?, transfer=? WHERE net_id=?;",
                               array($model->getMajor(),$model->getYear(),$model->getTransfer(), $model->getNetId()));
    }
}
?>

