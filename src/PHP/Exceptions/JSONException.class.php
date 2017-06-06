<?php
class JSONException implements JsonSerializable 
{
    private $Code,
            $Message,
            $Details;
    public function __construct($e, $details = null)
    {
        $this->Code = $e->getCode();
        $this->Message = $e->getMessage();
        $this->Details = $details;
        
    }
    public function jsonSerialize() {
        return [
            'Code' => $this->Code,
            'Message' => $this->Message,
            'Details' => $this->Details
        ];  
    }
}
