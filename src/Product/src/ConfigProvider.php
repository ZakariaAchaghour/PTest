<?php

declare(strict_types=1);

namespace Product;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Persistence\Mapping\Driver\MappingDriverChain;
use Laminas\Hydrator\ReflectionHydrator;
use Mezzio\Hal\Metadata\MetadataMap;
use Mezzio\Hal\Metadata\RouteBasedCollectionMetadata;
use Mezzio\Hal\Metadata\RouteBasedResourceMetadata;
use Product\Entity\Product;
use Product\Entity\ProductCollection;
use Product\Handler\CreateHandler;
use Product\Handler\CreateHandlerFactory;
use Product\Handler\DeleteHandler;
use Product\Handler\DeleteHandlerFactory;
use Product\Handler\EditHandler;
use Product\Handler\EditHandlerFactory;
use Product\Handler\ListHandler;
use Product\Handler\ListHandlerFactory;
use Product\Handler\ShowHandler;
use Product\Handler\ShowHandlerFactory;
use Product\Services\ProductServiceFactory;
use Product\Services\ProductServiceInterface;

/**
 * The configuration provider for the Product module
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
                ShowHandler::class => ShowHandlerFactory::class,
                EditHandler::class => EditHandlerFactory::class,
                DeleteHandler::class => DeleteHandlerFactory::class,
                CreateHandler::class => CreateHandlerFactory::class,
                ProductServiceInterface::class => ProductServiceFactory::class 
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
                'product'    => [__DIR__ . '/../templates/'],
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
                        'Product\Entity' => 'product_entity',
                    ],
                ],
                'product_entity' => [
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
                'resource_class' => Product::class,
                'route'          => 'products.show', // assumes a route named 'albums.show' has been created
                'extractor'      => ReflectionHydrator::class,
            ],
            [
                '__class__'           => RouteBasedCollectionMetadata::class,
                'collection_class'    => ProductCollection::class,
                'collection_relation' => 'product',
                'route'               => 'products.list', // assumes a route named 'albums.list' has been created
            ],
        ];
    }
}
