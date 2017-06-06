<?php

class PageRequest {
    private $pageSize;
    private $pageNumber;
    private $sort;

    public function __construct($size) {
        $this->pageNumber = 1;
        $this->$pageSize = $size;            
    }

    public function __set($name, $value) {
        switch($name) {
            case "pageSize" : $this->pageSize = $value;
                break;
            case "pageNumber" : $this->pageNumber = $value;
                break;
            case "sort" : $this->sort = $value;
                break;
            default : throw new Exception("$name does not exist");
                break;
        }
    }

    public function __get($name) {
        switch ($name) {
            case "pageSize" : return $this->pageSize;
                break;
            case "pageNumber" : return $this->pageNumber;
                break;
            case "sort" : return $this->sort;
                break;
            default : throw new Exception("$name does not exist");
                break;
        }
    }


}

