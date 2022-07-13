<?php

declare(strict_types=1);

use \Prooph\EventStore\Pdo\PersistenceStrategy\MySqlAggregateStreamStrategy;
use \Prooph\EventStoreBusBridge\EventPublisher;
use \Laminas\ServiceManager\Factory\InvokableFactory;
use Post\App\Commands\ChangeTitlePost;
use \Prooph\EventStore\Pdo\Container\PdoConnectionFactory;
use \Post\Model\Post;
use \Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Post\Response\JsonResponse;
use Post\App\Commands\CreatePost;
use Post\App\Handlers\ChangePostTitleHandler;
use Post\App\Handlers\CreateHandler;
use Post\App\Handlers\ListHandler;
use Post\Container\ReadModel\Finder\PostsFinderFactory;
use Post\Infrastructure\PostRepositoryImpl;
use Post\Model\Repository\PostRepository;
use Post\ReadModel\Finder\PostsFinder;
use Post\ReadModel\Queries\FetchPosts;
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

// return [
//     'prooph' => [
//         'middleware' => [
//             'query' => [
//                 'response_strategy' => JsonResponse::class,
//                 'message_factory' => \Prooph\Common\Messaging\FQCNMessageFactory::class,
//             ],
//             'command' => [
//                 'response_strategy' => JsonResponse::class,
//                 'message_factory' => \Prooph\Common\Messaging\FQCNMessageFactory::class,
//             ],
//             'event' => [
//                 'response_strategy' => JsonResponse::class,
//                 'message_factory' => \Prooph\Common\Messaging\FQCNMessageFactory::class,
//             ],
//             'message' => [
//                 'response_strategy' => JsonResponse::class,
//                 'message_factory' => \Prooph\Common\Messaging\FQCNMessageFactory::class,
//             ],
//         ],
//         'event_sourcing' => [
//             'aggregate_repository' => [
//                 'post_collection' => [
//                     'repository_class' => PostRepositoryImpl::class,
//                     'aggregate_type' => Post::class,
//                     'aggregate_translator' => \Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator::class,
//                     'stream_name' => 'user_stream',
//                 ],
//             ],
//         ],
//         'event_store' => [
//             'default' => [
//                 'plugins' => [
//                     \Prooph\EventStoreBusBridge\EventPublisher::class,
//                 ],
//             ],
//         ],
//         'service_bus' => [
//             'command_bus' => [
//                 'router' => [
//                     'routes' => [
//                         CreatePost::class => CreateHandler::class,
//                         \Category\App\Commands\CreateCategory::class => \Category\App\Handlers\CreateCategoryHandler::class
//                     ],
//                 ],
//                 'plugins' => [
//                     \Prooph\EventStoreBusBridge\TransactionManager::class
//                 ],
//             ],
//             'event_bus' => [
//                 'plugins' => [
//                     \Prooph\ServiceBus\Plugin\InvokeStrategy\OnEventStrategy::class,
//                 ],
//                 'router' => [
//                     'routes' => [
                       
//                         ],
//                         ],
//                 ],
//         ],
//         'pdo_connection' => [
//             'default' => [
//                 'schema' => 'mysql',
//                 'host' => '127.0.0.1',
//                 'port' => '3306',
//                 'user' => 'root',
//                 'password' => '',
//                 'dbname' => 'mezzio_2',
//                 'charset' => 'utf8',
//             ],
//         ],
//     ],
//     'dependencies' => [
//         'factories' => [
//             'pdo.connection' => PdoConnectionFactory::class,
//             AggregateTranslator::class => InvokableFactory::class,
//             CommandFactory::class => InvokableFactory::class,
//             JsonResponse::class => InvokableFactory::class,
//             \Prooph\EventStore\EventStore::class => \Prooph\EventStore\Pdo\Container\MySqlEventStoreFactory::class,
//             \Prooph\HttpMiddleware\CommandMiddleware::class => \Prooph\HttpMiddleware\Container\CommandMiddlewareFactory::class,
//             EventFactory::class => InvokableFactory::class,
//              MySqlAggregateStreamStrategy::class => InvokableFactory::class,
//              EventPublisher::class => EventPublisherFactory::class,
//              CommandBus::class => CommandBusFactory::class
//         ],
//     ]  
// ];

// return [
//     'prooph' => [
//         'event_store' => [
//             'default' => [
//                 'connection' => 'pdo.connection',
//                 'message_factory' => FQCNMessageFactory::class,
//                 'persistence_strategy' => MySqlAggregateStreamStrategy::class,
//                 'plugins' => [
//                     EventPublisher::class,
//                 ],
//             ],
//         ],
//         'event_sourcing' => [
//             'aggregate_repository' => [
//                 'post_collection' => [
//                     'repository_class' => \Post\Infrastructure\PostRepositoryImpl::class,
//                     'aggregate_type' => [
//                        'post'=> Post::class,
//                     ],
//                     'aggregate_translator' => AggregateTranslator::class,
//                     'stream_name' => 'post',
//                     'one_stream_per_aggregate' => true,
//                 ],
//             ],
//         ],
//         'middleware' => [
//             'command' => [
//                 'response_strategy' => JsonResponse::class,
//                 'message_factory' => FQCNMessageFactory::class,
//             ],
//         ],
//         'service_bus' => [
//             'command_bus' => [
//                 'router' => [
//                     'routes' => [
//                       CreatePost::class => CreateHandler::class
//                     ],
//                 ],
//                 // 'plugins' => [
//                 //     EventPublisher::class,
//                 // ],
//             ],
//             'event_bus' => [
//                 'plugins' => [
//                     \Prooph\ServiceBus\Plugin\InvokeStrategy\OnEventStrategy::class,
//                 ],
//             ],
//             // 'query_bus' => [
//             //     'router' => [
//             //         'routes' => [
//             //             'fetch-posts' => PostsFinder::class,
//             //         ],
//             //     ],
//             //     'plugins' => [
//             //         FinderInvokeStrategy::class,
//             //     ]
//             // ]
//         ],
//         'projection_manager' => [
//             'default' => [
//                 'connection' => 'pdo.connection',
//             ],
//         ],
//         'pdo_connection' => [
//             'default' => [
//                 'schema' => 'mysql',
//                 'host' => '127.0.0.1',
//                 'port' => '3306',
//                 'user' => 'root',
//                 'password' => '',
//                 'dbname' => 'mezzio_02',
//                 'charset' => 'utf8',
//             ],
//         ],
//     ],
//     'dependencies' => [
//         'factories' => [
//             'pdo.connection' => PdoConnectionFactory::class,
//             // \Prooph\Common\Messaging\NoOpMessageConverter::class => InvokableFactory::class,
//             \Prooph\Common\Messaging\FQCNMessageFactory::class => InvokableFactory::class,
//             AggregateTranslator::class => InvokableFactory::class,
//             // CommandFactory::class => InvokableFactory::class,
//             CommandBus::class => CommandBusFactory::class,
//             EventStore::class => MySqlEventStoreFactory::class,
//             EventBus::class => InvokableFactory::class,
//             PostRepository::class => [AggregateRepositoryFactory::class, 'post_collection'],
//             CreateHandler::class => CreateHandlerFactory::class,
//             \Prooph\HttpMiddleware\CommandMiddleware::class => \Prooph\HttpMiddleware\Container\CommandMiddlewareFactory::class,
//             // EventFactory::class => InvokableFactory::class,
//              MySqlAggregateStreamStrategy::class => InvokableFactory::class,
//              ProjectionManager::class => MySqlProjectionManagerFactory::class,
//              QueryBus::class => QueryBusFactory::class,
//              CommandMiddleware::class => CommandMiddlewareFactory::class,
//              JsonResponse::class => InvokableFactory::class,
//               //prooph/event-store-bus-bridge set up
//             \Prooph\EventStoreBusBridge\TransactionManager::class => \Prooph\EventStoreBusBridge\Container\TransactionManagerFactory::class,
//             \Prooph\EventStoreBusBridge\EventPublisher::class => \Prooph\EventStoreBusBridge\Container\EventPublisherFactory::class,
//         ],
//     ]

// ];


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
                'post_collection' => [
                    'repository_class' => PostRepositoryImpl::class,
                    'aggregate_type' => [
                        'post' => Post::class,
                    ],
                    'aggregate_translator' => \Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator::class,
                    'stream_name' => 'stream_post',
                    'one_stream_per_aggregate' => true,
                    'snapshot_store' => SnapshotStore::class,
                ],
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
                        CreatePost::class => CreateHandler::class,
                        ChangeTitlePost::class => ChangePostTitleHandler::class,
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
                        FetchPosts::class => ListHandler::class,
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
            PostRepository::class => [AggregateRepositoryFactory::class, 'post_collection'],
            // CreateHandler::class => CreateHandlerFactory::class,
            MySqlAggregateStreamStrategy::class => InvokableFactory::class,
            JsonResponse::class => InvokableFactory::class,
            AggregateTranslator::class => InvokableFactory::class,
            OnEventStrategy::class => InvokableFactory::class,
            SnapshotStore::class => PdoSnapshotStoreFactory::class,

            PostsFinder::class => PostsFinderFactory::class,
            FinderInvokeStrategy::class => InvokableFactory::class,

        ],

    ],
];