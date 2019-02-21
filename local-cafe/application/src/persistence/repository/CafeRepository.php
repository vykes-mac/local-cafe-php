<?php
namespace src\persistence\repository;

use src\domain\Cafe;
use src\persistence\db\Persistence;

final class CafeRepository implements IRepository
{
    private $db;

    public function __construct(Persistence $db)
    {
        $this->db = $db;
    }
    
    function fetchAll()
    {
        return $this->db->fetchAll();
    }

    function add(Cafe $cafe)
    {
        return $this->db->insert($cafe);
    }

    function delete($id)
    {
        return $this->db->delete($id);
    }

    function update(Cafe $cafe)
    {
        return $this->db->update($cafe);
    }
}