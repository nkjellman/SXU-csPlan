<?php
class Prerequisite
{
    private $CourseId,
            $PrereqId,
            $Depth;
    
    /**
     * Prerequistes class constructor
     * @param int $courseid
     * @param int $prereqid
     * @param int $depth
    */
    public function __construct($courseid, $prereqid, $depth)
    {

        if (!is_int($courseid)) {
            throw new InvalidArgumentException("Invalid type");
        }

        if (!is_int($prereqid)) {
            throw new InvalidArgumentException("Invalid type");
        }

        if (!is_int($depth)) {
            throw new InvalidArgumentException("Invalid type");
        }


        $this->CourseId = $courseid;
        $this->PrereqId = $prereqid;
        $this->Depth = $depth;
    }
        
       public function getCourseId() {
           return $this->CourseId;
       }

       public function setCourseId($value) {
           if (!is_int($value)) {
            throw new InvalidArgumentException("Invalid type");
        }

        $this->CourseId = $value;
       }

       public function getPrereqId() {
           return $this->PrereqId;
       }

       public function setPrereqId($value) {
           if (!is_int($value)) {
            throw new InvalidArgumentException("Invalid type");
        }

        $this->PrereqId = $value;
       }

       public function getDepth() {
           return $this->Depth;
       }

       public function setDepth($value) {
           if (!is_int($value)) {
            throw new InvalidArgumentException("Invalid type");
        }

        $this->Depth = $value;
       }
}
