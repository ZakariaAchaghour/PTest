<?php

declare(strict_types=1);

namespace Category;

use Category\Entity\Category;
use Category\Entity\CategoryCollection;
use Category\Handler\CreateHandler;
use Category\Handler\CreateHandlerFactory;
use Category\Handler\DeleteHandler;
use Category\Handler\DeleteHandlerFactory;
use Category\Handler\EditHandler;
use Category\Handler\EditHandlerFactory;
use Category\Handler\ListHandler;
use Category\Handler\ListHandlerFactory;
use Category\Handler\ShowHandler;
use Category\Handler\ShowHandlerFactory;
use Doctrine\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Mezzio\Hal\Metadata\MetadataMap;
use Mezzio\Hal\Metadata\RouteBasedCollectionMetadata;
use Mezzio\Hal\Metadata\RouteBasedResourceMetadata;
use Laminas\Hydrator\ReflectionHydrator;
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
            MetadataMap::class => $this->getHalMetadataMap(),
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
                ListHandler::class => ListHandlerFactory::class,
                CreateHandler::class => CreateHandlerFactory::class,
                EditHandler::class => EditHandlerFactory::class,
                DeleteHandler::class => DeleteHandlerFactory::class,
                ShowHandler::class => ShowHandlerFactory::class
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

    public function getHalMetadataMap()
    {
        return [
            [
                '__class__'      => RouteBasedResourceMetadata::class,
                'resource_class' => Category::class,
                'route'          => 'categories.show', // assumes a route named 'albums.show' has been created
                'extractor'      => ReflectionHydrator::class,
            ],
            [
                '__class__'           => RouteBasedCollectionMetadata::class,
                'collection_class'    => CategoryCollection::class,
                'collection_relation' => 'category',
                'route'               => 'categories.list', // assumes a route named 'albums.list' has been created
            ],
        ];
    }
}
