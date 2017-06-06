<?php
class Name implements JsonSerializable
{
  /**
    * @var string $First    First Name
    * @var string $Last    Last Name
    */
    private $First,
            $Last;
    /**
      * @param string $first First Name
      * @param string $first Last Name
      */
    public function __construct($first, $last)
    {
        if (!is_string($first)) {
            throw new InvalidArgumentException("Invalid first name input");
        }
        if (!is_string($last)) {
            throw new InvalidArgumentException("Invalid last name input");
        }
        $this->First = $first;
        $this->Last = $last;
    }
    public function getFirst()
    {
        return $this->First;
    }
    public function setFirst($value)
    {
        if (!is_string($first)) {
            throw new InvalidArgumentException("Invalid first name input");
        }
        $this->First = $first;
    }
    public function getLast()
    {
        return $this->Last;
    }
    public function setLast($value)
    {
        if (!is_string($last)) {
            throw new InvalidArgumentException("Invalid last name input");
        }
        $this->Last = $last;
    }
       
    public function jsonSerialize() {
        return [
            'First' => $this->First,
            'Last' => $this->Last
        ];
    }
}
