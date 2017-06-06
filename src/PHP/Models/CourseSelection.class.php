<?php
require_once 'CourseOffering.class.php';
class CourseSelection extends CourseOffering implements JsonSerializable
{
    private $Preference,
             $Comment,
             $Approved;
    
    /**
     *
     * @param string $netid
     * @param int $courseID
     * @param int $year
     * @param string $semester
     * @param string $pref
     * @param string $comnt
     * @return \CourseSelections
     * @throws InvalidArgumentException
     */
    public static function CreateSelection($courseID, $year, $semester, $pref = null, $comnt = null, $aprv = null)
    {
        if (!is_int($courseID)) {
            throw new InvalidArgumentException('Invalid Course ID input');
        }
        if (!is_int($year)) {
            throw new InvalidArgumentException('Invalid Year input');
        }
        if (!is_string($semester)) {
            throw new InvalidArgumentException('Invalid Semester input');
        }
        if (!is_bool($pref) && !is_null($pref)) {
            throw new InvalidArgumentException('Invalid Preference input');
        }

        if (!is_string($comnt) && !is_null($comnt)) {
            throw new InvalidArgumentException('Invalid Comment ID input');
        }
        if (!is_bool($aprv) && !is_null($aprv)) {
            throw new InvalidArgumentException('Invalid Approved input');
        }
        $c = new CourseSelection();
        if (!is_null($pref)) {
            $c->setPreference($pref);
        }
        if (!is_null($comnt)) {
            $c->setComment($comnt);
        }
        if (!is_null($aprv)) {
            $c->setApproved($aprv);
        }
        return $c->setId($courseID)
                 ->setYear($year)
                 ->setSemester($semester);
    }
    
    /**
     *
     * @param boolean $val
     * @return \CourseSelections
     * @throws InvalidArgumentException
     */
    public function setPreference($value)
    {
        if (!is_bool($value) && !is_null($value)) {
            throw new InvalidArgumentException('Invalid Preference input');
        }
        $this->Preference = $value;
        return $this;
    }
    
    public function getPreference()
    {
        return $this->Preference;
    }
    /**
     *
     * @param string $val
     * @return \CourseSelections
     * @throws InvalidArgumentException
     */
    public function setComment($val)
    {
        if (!is_string($val) && !is_null($val)) {
            throw new InvalidArgumentException('Invalid Comment input');
        }
        $this->st_comment = $val;
        return $this;
    }//end comment
        
    public function getComment()
    {
        return $this->Comment;
    }
    
    /**
     *
     * @param boolean $val
     * @return \CourseSelections
     * @throws InvalidArgumentException
     */
    public function setApproved($val)
    {
        if (!is_bool($val)) {
            throw new InvalidArgumentException('Invalid Approved input');
        }
        $this->Approved = $val;
        return $this;
    }
    
    public function getApproved()
    {
        return $this->Approved;
    }
        
    public function jsonSerialize()
    {
        return ['Id' => $this->Id,
        'Name' => $this->Name,
        'Department' => $this->Department,
        'Number' => $this->Number,
        'Credits' => $this->Credits,
        'Elective' => $this->Elective,
        'Description' => $this->Description,
        'Year' => $this->Year,
        'Semester' => $this->Semester,
        'Preference' => $this->Preference,
        'Comment' => $this->Comment,
        'Approved'=>$this->Approved];
    }
}//end Class
