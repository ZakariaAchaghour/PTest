<?php

declare(strict_types=1);

use \Prooph\EventStore\Pdo\PersistenceStrategy\MySqlAggregateStreamStrategy;
use \Prooph\EventStoreBusBridge\EventPublisher;
use \Laminas\ServiceManager\Factory\InvokableFactory;
use \Prooph\EventStoreBusBridge\Container\EventPublisherFactory;
use \Prooph\EventStore\Pdo\Container\PdoConnectionFactory;
use \Post\Infrastructure\EventStorePostCollection;
use \Post\Model\Post;
use \Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
// use \Post\Infrastructure\EventFactory;
// use \Post\Infrastructure\CommandFactory;
use Post\Response\JsonResponse;
use Post\App\Commands\CreatePost;
use Post\App\Handlers\CreateHandler;
use Post\Container\CreateHandlerFactory;
use Post\Infrastructure\PostRepositoryImpl;
use Post\Model\Repository\PostRepository;
use Prooph\Common\Messaging\FQCNMessageFactory;
use Prooph\EventSourcing\Container\Aggregate\AggregateRepositoryFactory;
use Prooph\EventStore\EventStore;
use Prooph\EventStore\Pdo\Container\MySqlEventStoreFactory;
use Prooph\EventStore\Pdo\Container\MySqlProjectionManagerFactory;
use Prooph\EventStore\Pdo\MySqlEventStore;
use Prooph\EventStore\Projection\ProjectionManager;
use Prooph\EventStoreBusBridge\Container\TransactionManagerFactory;
use Prooph\EventStoreBusBridge\TransactionManager;
use Prooph\HttpMiddleware\CommandMiddleware;
use Prooph\HttpMiddleware\Container\CommandMiddlewareFactory;
use Prooph\ServiceBus\CommandBus;
use Prooph\ServiceBus\Container\CommandBusFactory;
use Prooph\ServiceBus\Container\QueryBusFactory;
use Prooph\ServiceBus\EventBus;
use Prooph\ServiceBus\QueryBus;
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

return [
    'prooph' => [
        'event_store' => [
            'default' => [
                'connection' => 'pdo.connection',
                'message_factory' => FQCNMessageFactory::class,
                'persistence_strategy' => MySqlAggregateStreamStrategy::class,
                'plugins' => [
                    EventPublisher::class,
                ],
            ],
        ],
        'event_sourcing' => [
            'aggregate_repository' => [
                'post_collection' => [
                    'repository_class' => \Post\Infrastructure\PostRepositoryImpl::class,
                    'aggregate_type' => [
                       'post'=> Post::class,
                    ],
                    'aggregate_translator' => AggregateTranslator::class,
                    'stream_name' => 'post',
                    'one_stream_per_aggregate' => true,
                ],
            ],
        ],
        'middleware' => [
            'command' => [
                'response_strategy' => JsonResponse::class,
                'message_factory' => FQCNMessageFactory::class,
            ],
        ],
        'service_bus' => [
            'command_bus' => [
                'router' => [
                    'routes' => [
                      CreatePost::class => CreateHandler::class
                    ],
                ],
                // 'plugins' => [
                //     EventPublisher::class,
                // ],
            ],
            'event_bus' => [
                'plugins' => [
                    \Prooph\ServiceBus\Plugin\InvokeStrategy\OnEventStrategy::class,
                ],
            ],
            // 'query_bus' => [
            //     'router' => [
            //         'routes' => [
            //             'fetch-posts' => PostsFinder::class,
            //         ],
            //     ],
            //     'plugins' => [
            //         FinderInvokeStrategy::class,
            //     ]
            // ]
        ],
        'projection_manager' => [
            'default' => [
                'connection' => 'pdo.connection',
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
    ],
    'dependencies' => [
        'factories' => [
            'pdo.connection' => PdoConnectionFactory::class,
            // \Prooph\Common\Messaging\NoOpMessageConverter::class => InvokableFactory::class,
            \Prooph\Common\Messaging\FQCNMessageFactory::class => InvokableFactory::class,
            AggregateTranslator::class => InvokableFactory::class,
            // CommandFactory::class => InvokableFactory::class,
            CommandBus::class => CommandBusFactory::class,
            EventStore::class => MySqlEventStoreFactory::class,
            EventBus::class => InvokableFactory::class,
            PostRepository::class => [AggregateRepositoryFactory::class, 'post_collection'],
            CreateHandler::class => CreateHandlerFactory::class,
            \Prooph\HttpMiddleware\CommandMiddleware::class => \Prooph\HttpMiddleware\Container\CommandMiddlewareFactory::class,
            // EventFactory::class => InvokableFactory::class,
             MySqlAggregateStreamStrategy::class => InvokableFactory::class,
             ProjectionManager::class => MySqlProjectionManagerFactory::class,
             QueryBus::class => QueryBusFactory::class,
             CommandMiddleware::class => CommandMiddlewareFactory::class,
             JsonResponse::class => InvokableFactory::class,
              //prooph/event-store-bus-bridge set up
            \Prooph\EventStoreBusBridge\TransactionManager::class => \Prooph\EventStoreBusBridge\Container\TransactionManagerFactory::class,
            \Prooph\EventStoreBusBridge\EventPublisher::class => \Prooph\EventStoreBusBridge\Container\EventPublisherFactory::class,
        ],
    ]

];
