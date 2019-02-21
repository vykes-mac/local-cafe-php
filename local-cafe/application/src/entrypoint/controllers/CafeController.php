<?php
namespace src\entrypoint\controllers;

use src\persistence\repository\CafeRepository;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use src\persistence\db\Db;
use src\domain\Cafe;


final class CafeController
{
    private $repository;
    
    public function __construct()
    {
        $this->repository = new CafeRepository(new Db());
    }

    public function getAllCafes($request, $response, $args)
    {
        $cafes = $this->repository->fetchAll();
        return $response->withJson($cafes);
    }

    public function addNewCafe($request, $response)
    {
        $cafe = $this->createCafe($request);

        $cafe = $this->repository->add($cafe);

        $result = $this->createResponse($cafe);

        return $response->withJson($result);
    }

    public function deleteCafe($request, $response, $args)
    {
        $id = $args["id"];
       
        $id = $this->repository->delete($id);

        $result = array("id" => $id );
        
        return $response->withJson($result);
    } 

    public function updateCafe($request, $response, $args)
    {
        $id = $args["id"];
       
        $cafe = $this->createCafe($request);
        $cafe->setId($id);

        $cafe = $this->repository->update($cafe);

        $result = $this->createResponse($cafe);
        
        return $response->withJson($result);
    } 


    private function createCafe($request)
    {
        $json = $request->getBody();
        $data = json_decode($json, true);
      
        $cafe = new Cafe($data["name"], $data["location"]);

        return $cafe;
    }

    private function createResponse($cafe){
        
        $result = array(
            "id" => $cafe->getId(),
            "name" => $cafe->name,
            "location" => $cafe->location
        );

        return $result;
    }
}