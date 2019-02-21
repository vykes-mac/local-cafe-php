<?php
namespace src\persistence\db;

use src\domain\Cafe;


interface Persistence
{
    public function fetchAll();
    
    public function insert(Cafe $cafe);

    public function delete($id);

    public function update(Cafe $cafe);
}

final class Db implements Persistence
{
    private $mysqli;
    
    public function __construct()
    {
       $this->mysqli = new \mysqli("localhost", "root","root", "cafe"); 
    }

    public function fetchAll()
    {
        $cafeList = array();

        $sql = "CALL getAllCafes();";

        $result = $this->mysqli->query($sql);

        if(!$result) {
            echo "Error: Query fail";
            exit;
        }

        while($cafe = $result->fetch_assoc()){
            array_push($cafeList,$cafe);
        }

        return $cafeList;

        $this->mysqli->close();
    }
    
    public function insert(Cafe $cafe)
    {
        $sql = "Call addCafe('$cafe->name', '$cafe->location')";
        $res =  $this->mysqli->query($sql);
        $id = $res->fetch_assoc()['id'];
       
        if($id < 0){
            echo "Error inserting";
            exit;
        }

        $cafe->setId($id);
        
        return $cafe;

        $this->mysqli->close();
    }

    public function delete($id)
    {
        $sql = "Call removeCafe($id)";
        $res = $this->mysqli->query($sql);

        if($res!==true){
            $id = -1;
        }

        return $id;
    }

    public function update(Cafe $cafe)
    {
        $sql = "Call updateCafe({$cafe->getId()}, '$cafe->name', '$cafe->location')";
        $res = $this->mysqli->query($sql);

        if($res!==true){
            $cafe->setId(-1);
        }

        return $cafe;
    }
}


