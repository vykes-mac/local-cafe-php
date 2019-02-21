<?php
namespace src\domain;

final class Cafe
{
    private $id;
    public $name;
    public $location;

    public function __construct($name, $location)
    {
        $this->name = $name;
        $this->location = $location;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
}
