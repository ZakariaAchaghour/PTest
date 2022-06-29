<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Helper\HelperSet;

$container = require 'config/container.php';

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet(
    $container->get('doctrine.entity_manager.orm_default')
);



// return new HelperSet([
//     'em' => new EntityManagerHelper($container->get(EntityManager::class)),
// ]);
// return ConsoleRunner::createHelperSet($container->get(EntityManager::class));