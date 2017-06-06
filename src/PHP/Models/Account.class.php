<?php
require_once __DIR__.'/Enums/AccountType.enum.php';
require_once __DIR__.'/Name.class.php';

class Account implements JsonSerializable
{
    protected $NetId,
              $Name,
              $Type,
              $Email,
              $Image;
              
    public static function CreateAccount($netId, Name $name, $type, $email, $image)
    {
        if (!is_string($netId)) {
            throw new InvalidArgumentException("Invalid NetId input");
        }
        if (!($name instanceof Name)) {
            throw new InvalidArgumentException("Invalid Name input");
        }
        if (!is_int($type) && !is_null($type)) {
            throw new InvalidArgumentException("Invalid Type input");
        }
        if (!is_string($email) && !is_null($email)) {
            throw new InvalidArgumentException("Invalid Email input");
        }
        if (!is_string($image) && !is_null($image)) {
            throw new InvalidArgumentException("Invalid Image input");
        }
        $acc = new Account();
        $acc->setNetId($netId)
            ->setName($name);
            
        if (!is_null($type)) {
            $acc->setType($type);
        }
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
        $this->Type = AccountType::__default;
    }
    public function getNetId()
    {
        return $this->NetId;
    }
    public function setNetId($value)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException("Invalid input");
        }
        $this->NetId = $value;
        return $this;
    }
    public function getName()
    {
        return $this->Name;
    }

    public function setName(Name $value)
    {
        if (!($value instanceof Name)) {
            throw new InvalidArgumentException("Invalid input");
        }
        $this->Name = $value;
        return $this;
    }
    public function getType()
    {
        return $this->Type;
    }
    public function setType($value)
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException("Invalid input");
        }
        $this->Type = $value;
        return $this;
    }
    public function getEmail()
    {
        return $this->Email;
    }

    public function setEmail($value)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException("Invalid input");
        }
        $this->Email = $value;
        return $this;
    }

    public function getImage()
    {
        return $this->Image;
    }

    public function setImage($value)
    {
        if (!is_string($value)) {
            throw new Exception("Invalid input");
        }
        $this->Image = $value;
        return $this;
    }
    public function jsonSerialize()
    {
        return [
        'Id' => $this->NetId,
        'Name' => $this->Name,
        'Type' => $this->Type,
        'Email' => $this->Email,
        'Image' => $this->Image
        ];
    }
}
