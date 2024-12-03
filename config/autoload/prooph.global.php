<?php

declare(strict_types=1);

use \Prooph\EventStore\Pdo\PersistenceStrategy\MySqlAggregateStreamStrategy;
use \Prooph\EventStoreBusBridge\EventPublisher;
use \Laminas\ServiceManager\Factory\InvokableFactory;
use \Prooph\EventStore\Pdo\Container\PdoConnectionFactory;
use \Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Post\Container\ReadModel\Finder\PostsFinderFactory;
use Prooph\Common\Messaging\FQCNMessageFactory;
use Prooph\EventSourcing\Container\Aggregate\AggregateRepositoryFactory;
use Prooph\EventStore\EventStore;
use Prooph\EventStore\Pdo\Container\MySqlEventStoreFactory;
use Prooph\EventStore\Pdo\Container\MySqlProjectionManagerFactory;
use Prooph\EventStore\Pdo\PersistenceStrategy\MySqlSimpleStreamStrategy;
use Prooph\EventStore\Pdo\PersistenceStrategy\MySqlSingleStreamStrategy;
use Prooph\EventStore\Projection\ProjectionManager;

use Prooph\ServiceBus\Plugin\InvokeStrategy\FinderInvokeStrategy;
use Prooph\ServiceBus\Plugin\InvokeStrategy\OnEventStrategy;
use Prooph\SnapshotStore\Pdo\Container\PdoSnapshotStoreFactory;
use Prooph\SnapshotStore\SnapshotStore;



return [
    'prooph' => [
        'middleware' => [
            'query' => [
                'response_strategy' => JsonResponse::class,
                'message_factory' => \Prooph\Common\Messaging\FQCNMessageFactory::class,
            ],
            'command' => [
                'response_strategy' => JsonResponse::class,
                'message_factory' => \Prooph\Common\Messaging\FQCNMessageFactory::class,
            ],
            'event' => [
                'response_strategy' => JsonResponse::class,
                'message_factory' => \Prooph\Common\Messaging\FQCNMessageFactory::class,
            ],
            'message' => [
                'response_strategy' => JsonResponse::class,
                'message_factory' => \Prooph\Common\Messaging\FQCNMessageFactory::class,
            ],
        ],
        'pdo_snapshot_store' => [
            'default' => [
                'connection_service' => 'pdo.connection',
            ],
        ],
        'event_sourcing' => [
            'aggregate_repository' => [
            ],
        ],
        'event_store' => [
            'default' => [
                 'connection' => 'pdo.connection',
                // 'connection' => 'doctrine.pdo.connection',
                'message_factory' => FQCNMessageFactory::class,
                // 'persistence_strategy' => MySqlSingleStreamStrategy::class,
                'persistence_strategy' => MySqlSimpleStreamStrategy::class,
                // 'persistence_strategy' => MySqlAggregateStreamStrategy::class,
                'plugins' => [
                    EventPublisher::class,
                ],
            ],
        ],
        'pdo_connection' => [
            'default' => [
                'schema' => 'mysql',
                'host' => '127.0.0.1',
                'port' => '3306',
                'user' => 'root',
                'password' => '',
                'dbname' => 'mezzio_02',
                'charset' => 'utf8',
            ],
        ],
        'projection_manager' => [
            'default' => [
                // 'event_store' => MySqlEventStore::class,
                'connection' => 'pdo.connection',
            ],
        ],
        'service_bus' => [
            'command_bus' => [
                'router' => [
                    'routes' => [
                    ],
                ],
            ],
            'event_bus' => [
                'plugins' => [
                    \Prooph\ServiceBus\Plugin\InvokeStrategy\OnEventStrategy::class,
                ],
                'router' => [
                    'routes' => [
                       
                    ],
                ],
            ],
            'query_bus' => [
                'router' => [
                    'routes' => [
                       ],
                ],
                'plugins' => [
                    FinderInvokeStrategy::class,
                ],
            ],
        ],
    ],
    'dependencies' => [
       
        'factories' => [
            'pdo.connection' => PdoConnectionFactory::class,
            \Prooph\Common\Messaging\NoOpMessageConverter::class => InvokableFactory::class,
            \Prooph\Common\Messaging\FQCNMessageFactory::class => InvokableFactory::class,
            // prooph/psr7-middleware set up
            \Prooph\HttpMiddleware\CommandMiddleware::class => \Prooph\HttpMiddleware\Container\CommandMiddlewareFactory::class,
            \Prooph\HttpMiddleware\EventMiddleware::class => \Prooph\HttpMiddleware\Container\EventMiddlewareFactory::class,
            \Prooph\HttpMiddleware\QueryMiddleware::class => \Prooph\HttpMiddleware\Container\QueryMiddlewareFactory::class,
            \Prooph\HttpMiddleware\MessageMiddleware::class => \Prooph\HttpMiddleware\Container\MessageMiddlewareFactory::class,
            //prooph/service-bus set up
            \Prooph\ServiceBus\CommandBus::class => \Prooph\ServiceBus\Container\CommandBusFactory::class,
            \Prooph\ServiceBus\EventBus::class => \Prooph\ServiceBus\Container\EventBusFactory::class,
            \Prooph\ServiceBus\QueryBus::class => \Prooph\ServiceBus\Container\QueryBusFactory::class,
            //prooph/event-store-bus-bridge set up
            // \Prooph\EventStoreBusBridge\TransactionManager::class => \Prooph\EventStoreBusBridge\Container\TransactionManagerFactory::class,
            \Prooph\EventStoreBusBridge\EventPublisher::class => \Prooph\EventStoreBusBridge\Container\EventPublisherFactory::class,
            // \Prooph\Cli\Console\Helper\ClassInfo::class => \Prooph\ProophessorDo\Container\Console\Psr4ClassInfoFactory::class,
            // persistence strategies
            MySqlSingleStreamStrategy::class => InvokableFactory::class,
            MySqlSimpleStreamStrategy::class => InvokableFactory::class,
            EventStore::class => MySqlEventStoreFactory::class,
            ProjectionManager::class => MySqlProjectionManagerFactory::class,
            // CreateHandler::class => CreateHandlerFactory::class,
            MySqlAggregateStreamStrategy::class => InvokableFactory::class,
            JsonResponse::class => InvokableFactory::class,
            AggregateTranslator::class => InvokableFactory::class,
            OnEventStrategy::class => InvokableFactory::class,
            SnapshotStore::class => PdoSnapshotStoreFactory::class,

        ],

    ],
];