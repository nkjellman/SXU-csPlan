<?php
require_once 'Course.class.php';
class CourseOffering extends Course
{
    protected $Year,
              $Semester,
              $Total;
    
    /**
     *
     * @param string $courseID
     * @param int $year
     * @param string $semester
     * @return \CourseOfferings
     * @throws InvalidArgumentException
     */
    public static function CreateCourseOffering($id, $name, Department $department, $credits, $number, $elective, $description, $year, $semester)
    {
        if (!is_int($id) && !is_null($id)) {
            throw new InvalidArgumentException("Invalid Type");
        }

        if (!is_string($name)) {
            throw new InvalidArgumentException("Invalid Type");
        }

        if (is_null($department)) {
            throw new InvalidArgumentException("Invalid Type");
        }

        if (!is_int($credits) && !is_null($credits)) {
            throw new InvalidArgumentException("Invalid Type");
        }

        if (!is_int($number)) {
            throw new InvalidArgumentException("Invalid Type");
        }

        if (!is_bool($elective) && !is_null($elective)) {
            throw new InvalidArgumentException("Invalid Type");
        }

        if (!is_string($description) && !is_null($description)) {
            throw new InvalidArgumentException("Invalid Type");
        }
        if (!is_int($year)) {
            throw new InvalidArgumentException('Invalid Year input');
        }
        if (!is_string($semester)) {
            throw new InvalidArgumentException('Invalid Semester Imput');
        }
        $course = new Course();
        $course->setDepartment($department);
        if (!is_null($id)) {
            $course->setId($id);
        }
        if (!is_null($elective)) {
            $course->setElective($elective);
        }
        if (!is_null($credits)) {
            $course->setCredits($credits);
        }
        if (!is_null($number)) {
            $course->setNumber($number);
        }
        if (!is_null($name)) {
            $course->setName($name);
        }
        if (!is_null($description)) {
            $course->setDescription($description);
        }
        return $course->setYear($year)->setSemester($semester);
    }
      
      /**
       *
       * @return int year
       */
    public function getYear()
    {
        return $this->Year;
    }
      
      /**
       *
       * @param int $value
       * @return \CourseOfferings
       * @throws InvalidArgumentExceptionz
       */
    public function setYear($value)
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException('Invalid Year Input');
        }
        $this->Year = $value;
        return $this;
    }
          /**
       *
       * @return int year
       */
    public function getTotal()
    {
        return $this->Year;
    }
      
      /**
       *
       * @param int $value
       * @return \CourseOfferings
       * @throws InvalidArgumentExceptionz
       */
    public function setTotal($value)
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException('Invalid Year Input');
        }
        $this->Total = $value;
        return $this;
    }
      /**
       *
       * @return string semeseter
       */
    public function getSemester()
    {
        return $this->Semester;
    }
     /**
       *
       * @param string $val
       * @return \CourseOfferings
       * @throws InvalidArgumentException
       */
    public function setSemester($value)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('Invalid Semester input');
        }
        $this->Semester = $value;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'Id' => $this->Id,
            'Name' => $this->Name,
            'Department' => $this->Department,
            'Number' => $this->Number,
            'Credits' => $this->Credits,
            'Elective' =>$this->Elective,
            'Description' =>$this->Description,
            'Year' => $this->Year,
            'Semester' => $this->Semester,
            'Total' => $this->Total
        ];
    }
}
