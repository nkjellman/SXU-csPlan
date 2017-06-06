<?php
require_once 'Enums/Major.enum.php';
require_once 'Account.class.php';

class Student extends Account implements JsonSerializable
{
    private $Major,
            $Year,
            $Transfer,
            $Advisor,
            $Courses;
    public static function CreateStudent($netId, Name $name, $email, $image, $major, $year, $transfer, $advisor)
    {
        if (!is_string($netId)) {
            throw new InvalidArgumentException("Invalid NetId input");
        }
        if (!($name instanceof Name)) {
            throw new InvalidArgumentException("Invalid Name input");
        }
        if (!is_string($email) && !is_null($email)) {
            throw new InvalidArgumentException("Invalid Email input");
        }
        if (!is_string($image) && !is_null($image)) {
            throw new InvalidArgumentException("Invalid Image input");
        }
        if (!is_int($major)) {
            throw new InvalidArgumentException("Invalid major input");
        }
        if (!is_int($year)) {
            throw new InvalidArgumentException("Invalid year input");
        }
        if (!is_bool($transfer)) {
            throw new InvalidArgumentException("Invalid transfer input");
        }
        if (!is_array($advisor) && !is_null($advisor)) {
            throw new InvalidArgumentException("Invalid advisor input");
        }
        $acc = new Student();
        $acc->setNetId($netId)
                ->setName($name)
                ->setType($type)
                ->setMajor($major)
                ->setYear($year)
                ->setTransfer($transfer);
        if (!is_null($email)) {
            $acc->setEmail($email);
        }
        if (!is_null($image)) {
            $acc->setImage($image);
        }
        if (!is_null($advisor)) {
            $acc->setAdvisor($advisor);
        }
        return $acc;
    }

    public function __construct()
    {
        $this->Courses = array (); 
        $this->Type = AccountType::Student;
    }
    public function getMajor()
    {
        return $this->Major;
    }
    public function setMajor($value)
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException("Invalid input");
        }
        $this->Major = $value;
        return $this;
    }
    public function getYear()
    {
        return $this->Year;
    }
    public function setYear($value)
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException("Invalid input");
        }
        $this->Year = $value;
        return $this;
    }
    public function isTransfer()
    {
        return $this->Transfer;
    }
    public function setTransfer($value)
    {
        if (!is_bool($value)) {
            throw new InvalidArgumentException("Invalid input");
        }
        $this->Transfer = $value;
        return $this;
    }
    public function getAdvisor()
    {
        return $this->Advisor;
    }
    public function setAdvisor(array $value)
    {
        if (is_null($value)) {
            throw new InvalidArgumentException("Invalid input value");
        }
        $this->Advisor = $value;
        return $this;
    }
    public function getCourses() {
        return $this->Courses;
    }
    public function setCourses(array $value) {
        if (is_null($value)) {
            throw new InvalidArgumentException("Invalid input value");
        }
        $this->Courses = $value; 
        return $this;
    }
    public function jsonSerialize() {
        return [
            'Id' => $this->NetId,
            'Name' => $this->Name,
            'Type' => $this->Type,
            'Email' => $this->Email,
            'Image' => $this->Image,
            'Courses' => $this->Courses
        ];
    }
}
