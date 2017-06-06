<?php

class PlanGroup implements JsonSerializable {
    private $groupId;
    private $numRequired;
    private $major_id;
    private $year;
    private $transfer;

    public function Create($groupid, $numrequired, $ma, $year, $trans) {
         if (!is_int($groupid)) {
            throw new InvalidArgumentException("Invalid Plan ID type");
         }
         if (!is_int($numrequired)) {
            throw new InvalidArgumentException("Invalid Number Required type");
        }
        if (!is_int($ma)) {
            throw new InvalidArgumentException("Invalid Major ID type");
         }
         if (!is_int($year)) {
            throw new InvalidArgumentException("Invalid Year type");
         }
         if (!is_bool($trans)) {
            throw new InvalidArgumentException("Invalid Transfer type");
         }
         $group = new PlanGroup();
        $group->setGroupId($groupid)
                ->setNumRequired($numrequired)
                ->setMajorId($ma)
                ->setYear($year)
                ->setTransfer($trans);
        return $group;
    }//end Create

    public function getGroupId() {
        return $this->groupId;
    }
    
    public function setGroupId($value) {
        if (!is_int($value)) {
            throw new InvalidArgumentException("Invalid type");
        }
        $this->groupId = $value;
        return $this;
    }

    public function getNumRequired() {
        return $this->numRequired;
    }
    
    public function setNumRequired($value) {
       if (!is_int($value)) {
            throw new InvalidArgumentException("Invalid type");
        }
        $this->numRequired = $value;
        return $this;
    }
    
    public function getMajorId() {
        return $this->major_id;
    }
    
    public function setMajorId($val) {
        if(!is_int($val)) {
            throw new InvalidArgumentException("Invalid Major Id");
        }
        $this->major_id = $val;
        return $this;
    }
    
    public function getYear() {
        return $this->year;
    }
    
     public function setYear($val) {
        if(!is_int($val)) {
            throw new InvalidArgumentException("Invalid Year");
        }
        $this->year = $val;
        return $this;
    }
    
    public function isTransfer() {
        return $this->transfer;
    }
    
    public function setTransfer($val) {
        if(!is_bool($val)) {
            throw new InvalidArgumentException("Invalid Transfer");
        }
        $this->transfer = $val;
        return $this;
    }
    
    public function jsonSerialize() {
        return [
            'Id' => $this->groupId,
            'Number Required' => $this->numRequired,
            'Major ID' => $this->major_id,
            'Year' => $this->year,
            'Transfer' => $this->transfer
        ];
    }
}//end class