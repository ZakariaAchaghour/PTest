<?php 

namespace Category;

use Category\Handler\ListHandler;
use Psr\Container\ContainerInterface;
use Mezzio\Application;
class RoutesDelegator 
{
    public function __invoke(ContainerInterface $container, $serviceName, callable $callback) : Application 
    {
        $app = $callback();
        // setup routes 
      
        $app->get('/api/v1/categories',ListHandler::class,'users.list');
      
        return $app;
    }
}