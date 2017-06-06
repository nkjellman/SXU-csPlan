<?php
require_once PROJECT_ROOT . 'PHP/Models/PlanRequirement.class.php';
require_once 'BaseDAO.class.php';


class PlanRequirementDao extends BaseDAO { 
    public function __construct(PDO &$pdo){
        parent::__construct($pdo);
    }
    public function Create($m) {
        return parent::Execute('INSERT INTO plan_requirements (course_id, '
                . 'major_id, year, transfer, group_id, elective) '
                . 'VALUES(?, ?, ?, ?, ?, ?);', array($m->getCourseId(), $m->getMajorId(), 
                     $m->getYear(), (int)$m->isTransfer(), $m->getGroupId(),
                     $m->getElective()));
    }
    
   
    public function Delete($m) {
        return parent::Execute($this->QueryMatch('DELETE FROM plan_requirements', $m));
    }//end delete function
    
    public function Update($m) {
        return parent::Execute('UPDATE plan_requirements SET course_id = ?, '
                . 'major_id = ?, year = ?, transfer = ?, group_id = ?, elective = ?'
                . ' WHERE course_id = ? AND major_id = ? AND year = ? '
                . 'AND transfer = ?;', array($m->getCourseId(), $m->getMajorId(), 
                     $m->getYear(), (int)$m->isTransfer(), $m->getGroupId(),
                     $m->getElective(), $m->getCourseId(), $m->getMajorId(), 
                     $m->getYear(), (int)$m->isTransfer()));
    }
    
    public function QueryMatch($stmt, $m) {
        if (is_null($m)) {
            throw new InvalidArgumentException("Null exception");
        }
        $sql = "$stmt WHERE 1=1 ";
        if($m->getCourseId() !== null) {
            $sql .= "AND course_id = ".$m->getCourseId(). " ";
        }
        if($m->getMajorId() !== null) {
            $sql .= "AND major_id = ".$m->getMajorId(). " ";
        }
        if($m->getYear() !== null) {
            $sql .= "AND year = ".$m->getYear(). " ";
        }
        if($m->isTransfer() !== null) {
            $sql .= "AND Transfer = ".(int)$m->isTransfer(). " ";
        }
        if($m->getGroupId() !== null) {
            $sql .= "AND group_id = ".$m->getGroupId(). " ";
        }
        if($m->getElective() !== null) {
            $sql .= "AND elective = ".$m->getElective(). " ";
        }
        return $sql;
    }//end QueryMatch
    
    public function Read($m, $fetch) {
        $result = parent::Fetch($this->QueryMatch("SELECT * FROM plan_requirements", $m), $fetch);
        switch ($fetch) {
            case parent::Single:
            if($result === false) return null;
                $m->setCourseId((int)$result['course_id'])
                        ->setMajorId((int)$result['major_id'])
                        ->setYear((int)$result['year'])
                        ->setTransfer((bool)$result['transfer'])
                        ->setGroupId((int)$result['group_id'])
                        ->setElective((bool)$result['elective']);
                return $m;
            case parent::All:
                $array = array();
                foreach ($result as $row) {
                    $plan = new Plan();
                    $plan->setCourseId((int)$resultp['course_id'])
                        ->setMajorId((int)$result['major_id'])
                        ->setYear((int)$result['year'])
                        ->setTransfer((bool)$result['transfer'])
                        ->setGroupId((int)$result['group_id'])
                        ->setElective((bool)$result['elective']);
                    array_push($array, $plan);
                }
                return $array;
            default:
                throw new InvalidArgumentException("You're not supposed to be here...");
        }//end Switch
    }//end read
//end update function
}//end CourseDao class 
try {
    $DI = DI::RegisterTypes();
    $conn = $DI->resolve("PDO");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage();
}
$p = new PlanRequirement();
$p = $p->Create(4, 2, 2017, FALSE, 1, null);
$pa = new PlanRequirementDao($conn);
$c = $pa->Read($p, 1);
echo json_encode($c);


