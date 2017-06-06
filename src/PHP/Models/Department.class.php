<?php

class Department implements JsonSerializable
{
    private $Id,
            $Name,
            $Abbreviation;
    
    public static function GENED()
    {
        return new Department(-1, "General Education", "GENED");
    }
    public static function ELECTIVE()
    {
        return new Department(0, "Elective", "E");
    }
    public static function CMPSC()
    {
        return new Department(1, "Computer Science", "CMPSC");
    }
    public static function MATH()
    {
        return new Department(2, "Mathematics", "MATH");
    }

    public static function GetDepartment($id) {
        switch ($id) {
            case -1:
                return self::GENED();
            case 0:
                return self::ELECTIVE();
            case 1:
                return self::CMPSC();
            case 2:
                return self::MATH();
            case NULL: return null;
            default:
                return null;
        }
    }

    public function __construct($id, $name, $abbreviation)
    {
        if (!is_int($id)) {
            throw new InvalidArgumentException("Invalid id input");
        }
        if (!is_string($name)) {
            throw new InvalidArgumentException("Invalid name input");
        }
        if (!is_string($abbreviation)) {
            throw new InvalidArgumentException("Invalid abbreviation input");
        }

        $this->Id = $id;
        $this->Name = $name;
        $this->Abbreviation = $abbreviation;
    }
    public function getId()
    {
        return $this->Id;
    }
    public function setId($value)
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException("Invalid input");
        }
        $this->Id = $value;
    }
    public function getName()
    {
        return $this->Name;
    }
    public function setName($value)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException("Invalid input");
        }
        $this->Name = $value;
    }

    public function getAbbreviation()
    {
        return $this->Abbreviation;
    }

    public function setAbbreviation($value)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException("Invalid input");
        }
        $this->Abbreviation = $value;
    }

    public function jsonSerialize() {
        return [
            'Id' => $this->Id,
            'Name' => $this->Name,
            'Abbreviation' => $this->Abbreviation,
        ];
    }
}
