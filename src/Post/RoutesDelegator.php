<?php 

namespace Post;

use Post\Middleware\JsonPayload;
use Prooph\HttpMiddleware\CommandMiddleware;
use Psr\Container\ContainerInterface;
use Mezzio\Application;
use Post\App\Commands\CreatePost;


class RoutesDelegator 
{
    public function __invoke(ContainerInterface $container, $serviceName, callable $callback) : Application 
    {
        $app = $callback();
        //  $app->post('/api/v2/post',[JsonPayload::class,CommandMiddleware::class],'command.create.post')->setOptions(['values' => ['prooph_command_name' => CreatePost::class]]);
        return $app;
    }
}