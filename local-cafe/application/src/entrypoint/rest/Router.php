<?php
namespace src\entrypoint\rest;
use src\entrypoint\controllers\CafeController;

final class Router
{
    private $app;
    
    public function __construct($app)
    {
        $this->app = $app;
    }
    
    public function configureRoutes()
    {
        $this->app->get('/', CafeController::class . ':getAllCafes');

        $this->app->post('/create', CafeController::class . ':addNewCafe');

        $this->app->delete('/cafe/{id}', CafeController::class . ':deleteCafe');

        $this->app->put('/update/{id}', CafeController::class . ':updateCafe');
    }
}