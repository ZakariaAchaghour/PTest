<?php

declare(strict_types=1);

namespace Category;

use Category\Handler\ListHandler;
use Category\Handler\ListHandlerFactory;
use Doctrine\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
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
            'templates'    => $this->getTemplates(),
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
            'factories'  => [
                ListHandler::class => ListHandlerFactory::class
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'category'    => [__DIR__ . '/../templates/'],
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
                        'Category\Entity' => 'category_entity',
                    ],
                ],
                'category_entity' => [
                    'class' => AnnotationDriver::class,
                    'cache' => 'array',
                    'paths' => [__DIR__ . '/Entity'],
                ],
            ],
        ];
    }
}
