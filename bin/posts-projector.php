<?php

declare (strict_types=1);

use Post\Model\Events\PostWasCreated;
use Post\ReadModel\PostsReadModel;
use Prooph\EventStore\Projection\ProjectionManager;

error_reporting(E_ALL & ~E_NOTICE);
chdir(dirname(__DIR__));
require 'vendor/autoload.php';


$projectionManager = $container->get(ProjectionManager::class);
/* @var ProjectionManager $projectionManager */

$readModel = new PostsReadModel($container->get('pdo.connection'));
$projection = $projectionManager->createReadModelProjection('posts', $readModel);
$projection
    ->fromCategory('post')
    ->when([
        'post-was-created' => function ($state, PostWasCreated $event) {
            $this->readModel()->stack('insert', [
                'id' => $event->postId()->toString(),
                'title' => $event->title()->toString(),
                'content' => $event->content()->toString(),
            ]);
        },
    ])
    ->run();
