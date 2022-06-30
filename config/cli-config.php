<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$container = require 'config/container.php';
$entityManager = $container->get(EntityManager::class);

return  ConsoleRunner::createHelperSet($entityManager);



// return new HelperSet([
//     'em' => new EntityManagerHelper($container->get(EntityManager::class)),
// ]);
// return ConsoleRunner::createHelperSet($container->get(EntityManager::class));