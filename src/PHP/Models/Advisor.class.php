<?php
require_once 'Account.class.php';
require_once 'Student.class.php';

class Advisor extends Account
{
    private $Students;
    public static function CreateAdvisor($netId, Name $name, $email, array $students)
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

        $acc = new Advisor();
        $acc->setNetId($netId)
            ->setName($name)
            ->setStudents($students);
            
        if (!is_null($email)) {
            $acc->setEmail($email);
        }
        if (!is_null($image)) {
            $acc->setImage($image);
        }
        return $acc;
    }
    public function __construct()
    {
           $this->Type = AccountType::Advisor;
           $this->Students = array();
    }
    public function getStudents()
    {
        return $this->Students;
    }
    public function setStudents(array $students)
    {
        $this->Students = $students;
        return $this;
    }
    public function addStudent(Student $student)
    {
        array_push($this->Students, $student);
        return $this;
    }
}
