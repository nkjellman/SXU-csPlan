<?php
require_once PROJECT_ROOT . 'PHP/Models/PlanGroup.class.php';


class PlanGroupDAO extends BaseDAO {
    public function __construct(\PDO &$pdo) {
        parent::__construct($pdo);
    }
    
    /**
     * 
     * @param PlanGroup $m
     * @return type
     */
    public function Create($m) {
        return parent::Execute('INSERT INTO plan_groups (group_id, num_required, '
                . 'major_id, year, transfer) VALUES (?, ?, ?, ?, ?);', array($m->getGroupId(), 
                    $m->getNumRequired(), $m->getMajorId(), $m->getYear(), 
                    (int)$m->isTransfer()));
    }
    
    /**
     * 
     * @param PlanGroup $m
     * @return type
     */
    public function Delete($m) {
        return parent::Execute($this->QueryMatch('DELETE FROM plan_groups', $m));
    }
    
    public function Update($m) { 
        return parent::Execute('UPDATE plan_groups SET group_id = ?, num_required = ?'
                . ', major_id = ?, year = ?, transfer = ? WHERE group_id = ?'
                . ' AND major_id = ? AND year = ? AND transfer = ?;', array($m->getGroupId(), 
                    $m->getNumRequired(), $m->getMajorId(), $m->getYear(), 
                    (int)$m->isTransfer(), $m->getGroupId(), $m->getMajorId(), 
                    $m->getYear(), (int)$m->isTransfer()));
    }
    
    public function QueryMatch($stmt, $m) {
        if (is_null($m)) {
            throw new InvalidArgumentException("Null exception");
        }
        $sql = "$stmt WHERE 1=1 ";
        if($m->getGroupId() !== null) {
            $sql .= "AND group_id = ".$m->getGroupId(). " "; 
        }
        if($m->getNumRequired() !== null) {
            $sql .= "AND num_required = ".$m->getNumRequired(). " "; 
        }
        if($m->getMajorId() !== null) {
            $sql .= "AND major_id = ".$m->getMajorId(). " ";
        }
        if($m->getYear() !== null) {
            $sql .= "AND year = ".$m->getYear(). " ";
        }
        if($m->isTransfer() !== null) {
            $sql .= "AND transfer = ".(int)$m->isTransfer(). " ";
        }
        return $sql;
    }
    
    public function Read($m, $fetch) {
        $result = parent::Fetch($this->QueryMatch("SELECT * FROM plan_groups", $m), $fetch);
        switch ($fetch) {
            case parent::Single:
            if($result === false) return null;
                $m->setGroupId((int)$result['group_id'])
                        ->setNumRequired((int)$result['num_required'])
                        ->setMajorId((int)$result['major_id'])
                        ->setYear((int)$result['year'])
                        ->setTransfer((bool)$result['transfer']);
                return $m;
            case parent::All:
                $array = array();
                foreach ($result as $row) {
                    $plan = new PlanGroup();
                    $plan->setGroupId((int)$result['group_id'])
                        ->setNumRequired((int)$result['num_required'])
                        ->setMajorId((int)$result['major_id'])
                        ->setYear((int)$result['year'])
                        ->setTransfer((bool)$result['transfer']);
                    array_push($array, $plan);
                }
                return $array;
            default:
                throw new InvalidArgumentException("You're not supposed to be here...");
        }//end Switch
    }
}