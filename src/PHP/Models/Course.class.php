<?php
require_once 'Department.class.php';

class Course implements JsonSerializable
{
    protected $Id,
              $Name,
              $Department,
              $Credits,
              $Number,
              $Elective,
              $Description;



    public function __construct()
    {
    }

    /**
     * constructs the course classs with the given params:
     * @param int $id sets the course_id
     * @param string $name sets the name
     * @param Department $department sets the Department
     * @param int $credits sets the credit_hours
     * @param int $number sets the course_num
     * @param int $elective sets the elective
     */

    public static function CreateCourse($id, $name, Department $department, $credits, $number, $elective, $description)
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
        return $course;
    }

    public function getId()
    {
        return $this->Id;
    }

    public function setId($value)
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException("Invalid Type");
        }

        $this->Id = $value;
        return $this;
    }

    public function getName()
    {
        return $this->Name;
    }

    public function setName($value)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException("Invalid Type");
        }

        $this->Name = $value;
        return $this;
    }

    public function getDepartment()
    {
        return $this->Department;
    }

    public function setDepartment(Department $value)
    {
        if (is_null($value)) {
            throw new InvalidArgumentException("Invalid Type");
        }

        $this->Department = $value;
        return $this;
    }

    public function getCredits()
    {
        return $this->Credits;
    }

    public function setCredits($value)
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException("Invalid Type");
        }

        $this->Credits = $value;
        return $this;
    }

    public function getNumber()
    {
        return $this->Number;
    }

    public function setNumber($value)
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException("Invalid Type");
        }

        $this->Number = $value;
        return $this;
    }

    public function isElective()
    {
        return $this->Elective;
    }

    public function setElective($value)
    {
        if (!is_bool($value)) {
            throw new InvalidArgumentException("Invalid Type");
        }

        $this->Elective = $value;
        return $this;
    }

    public function getDescription()
    {
        return $this->Description;
    }

    public function setDescription($value)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException("Invalid Type");
        }

        $this->Description = $value;
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
            'Elective' => $this->Elective,
            'Description' => $this->Description
        ];
    }
}
