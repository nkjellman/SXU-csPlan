<?php
  
class Container
{
  
    private $list;
  
    public function __construct()
    {
        $this->list = [];
    }
  
  /**
   * Registers object to container so it can be used at anytime later.
   * @param String $name
   * @param Object $object
   * @throws Exception
   */
    public function Register($name, $object)
    {
        if (!is_string($name)) {
            throw new Exception("Invalid Input");
        }
        if (!is_object($object)) {
            throw new Exception("Invalid input");
        }
        if (array_key_exists($name, $this->list)) {
            throw new Exception("Already Exists");
        }
        $this->list[$name] = $object;
        return $this;
    }
  
  /**
   * Returns object that you registered prior. Name must match exactly.
   * @param String $name
   * @return Object
   * @throws Exception
   */
  
    public function Resolve($name)
    {
        if (!is_string($name)) {
            throw new Exception("Invalid Input");
        }
        if (array_key_exists($name, $this->list)) {
            return $this->list[$name];
        }
    }
}
