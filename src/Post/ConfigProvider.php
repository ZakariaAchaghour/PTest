<?php

declare(strict_types=1);

namespace Post;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Persistence\Mapping\Driver\MappingDriverChain;
use Post\App\Handlers\CreateHandler;
use Post\App\Handlers\ListHandler;
use Post\Container\CreateHandlerFactory;
use Post\Container\ListHandlerFactory;

/**
 * The configuration provider for the Category module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'doctrine' => $this->getDoctrineEntities(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'delegators' => [
                \Mezzio\Application::class => [
                    RoutesDelegator::class,
                ],
            ],
            'invokables' => [
                
            ],
            'aliases' => [
            ],
            'factories'  => [
                ListHandler::class => ListHandlerFactory::class,
                CreateHandler::class => CreateHandlerFactory::class
            ],
        ];
    }

   

    public function getDoctrineEntities() : array
    {
        return [
            'driver' => [
                'orm_default' => [
                    'class' => MappingDriverChain::class,
                    'drivers' => [
                        'Post\Entity' => 'post_entity',
                    ],
                ],
                'post_entity' => [
                    'class' => AnnotationDriver::class,
                    'cache' => 'array',
                    'paths' => [__DIR__ . '/Entity'],
                ],
            ],
        ];
    }
}
