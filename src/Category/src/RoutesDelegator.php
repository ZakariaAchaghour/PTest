<?php 

namespace Category;

use Category\Handler\CreateHandler;
use Category\Handler\DeleteHandler;
use Category\Handler\EditHandler;
use Category\Handler\ListHandler;
use Category\Handler\ShowHandler;
use Psr\Container\ContainerInterface;
use Mezzio\Application;
class RoutesDelegator 
{
    public function __invoke(ContainerInterface $container, $serviceName, callable $callback) : Application 
    {
        $app = $callback();
        // setup routes 
      // {id:[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}}[/]
        $app->get('/api/v1/categories',ListHandler::class,'categories.list');
        $app->get('/api/v1/categories/{id}',ShowHandler::class,'categories.show');
        $app->delete('/api/v1/categories/{id}',DeleteHandler::class,'categories.delete');
        $app->put('/api/v1/categories/{id}',EditHandler::class,'categories.edit');
        $app->post('/api/v1/categories',CreateHandler::class,'categories.create');

        return $app;
    }
}