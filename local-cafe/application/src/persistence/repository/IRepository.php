<?php
namespace src\persistence\repository;

use src\domain\Cafe;


interface IRepository 
{
    function fetchAll();

    function add(Cafe $cafe);

    function delete($id);

    function update(Cafe $cafe);
}