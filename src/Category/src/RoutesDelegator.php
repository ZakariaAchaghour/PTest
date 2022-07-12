<?php 

namespace Category;

use Category\App\Commands\CreateCategory;
use Category\App\Requests\CategoryRequest;
use Category\Handler\CreateHandler;
use Category\Handler\DeleteHandler;
use Category\Handler\EditHandler;
use Category\Handler\ListHandler;
use Category\Handler\ProductsCategoryHandler;
use Category\Handler\ShowHandler;
use Post\Middleware\JsonError;
use Post\Middleware\JsonPayload;
use Prooph\HttpMiddleware\CommandMiddleware;
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
        $app->get('/api/v1/categories/{id}/products',ProductsCategoryHandler::class,'categories.show.products');
        $app->delete('/api/v1/categories/{id}',DeleteHandler::class,'categories.delete');
        $app->put('/api/v1/categories/{id}',[CategoryRequest::class,EditHandler::class],'categories.edit');
//        $app->post('/api/v1/categories',[CategoryRequest::class,CreateHandler::class],'categories.create');
        $app->post('/api/v1/categories',[JsonPayload::class,CommandMiddleware::class],'create.category')->setOptions(['values' => ['prooph_command_name' => CreateCategory::class]]);

        return $app;
    }
}