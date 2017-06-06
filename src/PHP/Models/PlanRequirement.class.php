<?php
    
class PlanRequirement implements JsonSerializable {
    private  $CourseId,
             $MajorId,
             $Year,
             $Transfer,
             $Group_id,
             $Elective;
    
    public function Create($courseid, $majorid, $year, $transfer, $gid, $ele) 
    {

        if (!is_int($courseid)) {
            throw new InvalidArgumentException("Invalid Course ID type");
        }

        if (!is_int($majorid)) {
            throw new InvalidArgumentException("Invalid Major type");
        }

        if (!is_int($year)) {
            throw new InvalidArgumentException("Invalid Year type");
        }

        if (!is_bool($transfer)) {
            throw new InvalidArgumentException("Invalid Transfer type");
        }
        if (!is_int($gid) && !is_null($gid)) {
            throw new InvalidArgumentException("Invalid Group ID type");
        }
        if (!is_bool($ele) && !is_null($ele)) {
            throw new InvalidArgumentException("Invalid Year type");
        }
        $c = new PlanRequirement();
        
        $c->setCourseId($courseid)
                ->setMajorId($majorid)
                ->setYear($year)
                ->setTransfer($transfer)
                ->setGroupId($gid)
                ->setElective($ele);
        return $c;
    }


    public function getCourseId() {
        return $this->CourseId;
    }

    public function setCourseId($value) {
         if (!is_int($value)) {
            throw new InvalidArgumentException("Invalid Type");
        }   

        $this->CourseId = $value;
        return $this;
    }

    public function getMajorId() {
        return $this->MajorId;
    }

    public function setMajorId($value) {
        if (!is_int($value)) {
            throw new InvalidArgumentException("Invalid Type");
        }   
          $this->MajorId = $value;
          return $this;
    }
    
   public function getYear() {
        return $this->Year;
    }

    public function setYear($value) {
        if (!is_int($value)) {
            throw new InvalidArgumentException("Invalid Type");
        }   
          $this->Year = $value;
          return $this;
    }

    public function isTransfer() {
        return $this->Transfer;
    }

    public function setTransfer($value) {
        if (!is_bool($value)) {
            throw new InvalidArgumentException("Invalid Transfer input");
        }
        $this->Transfer = $value;
        return $this;
    }
    
    public function getGroupId() {
        return $this->Group_id;
    }
    
    public function setGroupId($val) {
        if(!is_int($val) && !is_null($val)) {
            throw new InvalidArgumentException('Invalid Group ID input');
        }
        $this->Group_id = $val;
        return $this;
    }
    
    public function getElective() {
        return $this->Elective;
    }
    
    public function setElective($val) {
        if(!is_bool($val) && !is_null($val)) {
          throw new InvalidArgumentException('Invalid Elective input');  
        }
        $this->Elective = $val;
        return $this;
    }
    
    public function jsonSerialize() {
        return [
            'Course Id' => $this->CourseId,
            'Major ID' => $this->MajorId,
            'Year' => $this->Year,
            'Transfer' => $this->Transfer,
            'Group Id'=>$this->Group_id,
            'Elective' => $this->Elective
        ];
    }
}