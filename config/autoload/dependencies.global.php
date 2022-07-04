<?php

declare(strict_types=1);

return [
    // Provides application-wide services.
    // We recommend using fully-qualified class names whenever possible as
    // service names.
    'dependencies' => [
        // Use 'aliases' to alias a service name to another service. The
        // key is the alias name, the value is the service to which it points.
        'aliases' => [
            // Fully\Qualified\ClassOrInterfaceName::class => Fully\Qualified\ClassName::class,
            Laminas\Db\Adapter\Adapter::class => Laminas\Db\Adapter\AdapterInterface::class
        ],
        // Use 'invokables' for constructor-less services, or services that do
        // not require arguments to the constructor. Map a service name to the
        // class name.
        'invokables' => [
            // Fully\Qualified\InterfaceName::class => Fully\Qualified\ClassName::class,
        ],
        // Use 'factories' for services provided by callbacks/factory classes.
        'factories' => [
            // Fully\Qualified\ClassName::class => Fully\Qualified\FactoryName::class,
            Laminas\Db\Adapter\AdapterInterface::class => \Laminas\Db\Adapter\AdapterServiceFactory::class
        ],
    ],
    'db' => [
        'driver' => 'Pdo', 
        'dsn' => 'mysqli:dbname=mezzio_02;hostname=localhost' ,
        'driver_options' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAME \'UTF8\''
        ]
    ]
];
