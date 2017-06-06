<?php
require_once PROJECT_ROOT . 'PHP/Models/Plan.class.php';
require_once 'BaseDAO.class.php';

class PlanDao extends BaseDAO { 
    public function __construct(PDO &$pdo){
        parent::__construct($pdo);
    }
    public function Create($m) {
        return parent::Execute('INSERT INTO plans (major_id, electives, year, '
                . 'transfer) VALUES(?, ?, ?, ?);', array($m->getMajorId(), 
                    $m->getElectives(), $m->getYear(), (int)$m->getTransfer()));
    }
    
   
    public function Delete($m) {
        return parent::Execute($this->QueryMatch('DELETE FROM plans', $m));
    }//end delete function
    
    public function Update($m) {
        return parent::Execute('UPDATE plans SET major_id = ?, electives = ?, '
                . 'year = ?, transfer = ? WHERE major_id = ? AND year = ? '
                . 'AND transfer = ?;', array($m->getMajorId(), 
                    $m->getElectives(), $m->getYear(), (int)$m->getTransfer(), 
                    $m->getMajorId(), $m->getYear(), (int)$m->getTransfer()));
    }
    
    public function QueryMatch($stmt, $m) {
        if (is_null($m)) {
            throw new InvalidArgumentException("Null exception");
        }
        $sql = "$stmt WHERE 1=1 ";
        if($m->getMajorId() !== null) {
            $sql .= "AND major_id = ".$m->getMajorId(). " ";
        }
        if($m->getElectives() !== null) {
            $sql .= "AND electives = ".$m->getElectives(). " ";
        }
        if($m->getYear() !== null) {
            $sql .= "AND year = ".$m->getYear(). " ";
        }
        if($m->getTransfer() !== null) {
            $sql .= "AND Transfer = ".(int)$m->getTransfer(). " ";
        }
        return $sql;
    }//end QueryMatch
    
    public function Read($m, $fetch) {
        $result = parent::Fetch($this->QueryMatch("SELECT * FROM plans", $m), $fetch);
        switch ($fetch) {
            case parent::Single:
            if($result === false) return null;
                $m->setMajorId((int)$result['major_id'])
                      ->setElectives((int)$result['electives'])
                      ->setYear((int)$result['year'])
                      ->setTransfer((bool)$result['transfer']);
                return $m;
            case parent::All:
                $array = array();
                foreach ($result as $row) {
                    $plan = new Plan();
                    $plan->setMajorId((int)$result['major_id'])
                      ->setElectives((int)$result['electives'])
                      ->setYear((int)$result['year'])
                      ->setTransfer((bool)$result['transfer']);
                    array_push($array, $plan);
                }
                return $array;
            default:
                throw new InvalidArgumentException("You're not supposed to be here...");
        }//end Switch
    }//end read
//end update function
}//end CourseDao class 

