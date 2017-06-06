<?php

class Plan implements JsonSerializable {

    private $MajorId,
            $Electives,
            $Year,
            $Transfer;
    
    
    public function Create($majorid, $electives, $year, $transfer)
    {
        if (!is_int($majorid)) {
            throw new InvalidArgumentException("Invalid Major_ID Type");
        }

        if (!is_int($electives)) {
            throw new InvalidArgumentException("Invalid Elective Type");
        }

        if (!is_int($year)) {
            throw new InvalidArgumentException("Invalid Year Type");
        }

        if (!is_bool($transfer)) {
            throw new InvalidArgumentException("Invalid Transfer Type");
        }
        $c = new Plan();
        $c->MajorId = $majorid;
        $c->Electives = $electives;
        $c->Year = $year;
        $c->Transfer = $transfer;
        return $c;
    }

    public function getMajorId() {
        return $this->MajorId;
    }

    public function setMajorId($value) {
        if (!is_int($value)) {
            throw new InvalidArgumentException("Invalid Major Type");
        }   

          $this->MajorId = $value;
          return $this;
    }

    public function getElectives() {
        return $this->Electives;
    }

    public function setElectives($value) {
        if (!is_int($value)) {
            throw new InvalidArgumentException("Invalid Elective Input");
        }

        $this->Electives = $value;
        return $this;
    }

     public function getYear() {
        return $this->Year;
    }

    public function setYear($value) {
        if (!is_int($value)) {
            throw new InvalidArgumentException("Invalid Year Type");
        }   

          $this->Year = $value;
          return $this;
    }

    public function getTransfer() {
        return $this->Transfer;
    }

    public function setTransfer($value) {
        if (!is_bool($value)) {
              throw new InvalidArgumentException("Invalid Tranfer Input");
        }
        $this->Transfer = $value;
            return $this;
    }
    
    public function jsonSerialize() {
         return [
            'Id' => $this->MajorId,
            'Elective' =>$this->Electives,
            'Year' =>$this->Year,
            'Transfer'=>$this->Transfer
        ];
    }
}
