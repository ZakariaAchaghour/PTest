<?php

declare (strict_types=1);
namespace script;
use Post\Model\Events\PostWasCreated;
use Post\Model\Events\PostWasRenamed;
use Post\ReadModel\PostsReadModel;
use Prooph\EventStore\Projection\ProjectionManager;

error_reporting(E_ALL & ~E_NOTICE);
chdir(dirname(__DIR__));

require 'vendor/autoload.php';

$container = require 'config/container.php';

$projectionManager = $container->get(ProjectionManager::class);
/* @var ProjectionManager $projectionManager */

$readModel = new PostsReadModel($container->get('pdo.connection'));
$projection = $projectionManager->createReadModelProjection('posts', $readModel);
$projection
    ->fromCategory('stream_post')
    ->when([
        PostWasCreated::class => function ($state, PostWasCreated $event) {
            $this->readModel()->stack('insert', [
                'id' => $event->postId()->toString(),
                'title' => $event->title()->toString(),
                'content' => $event->content()->toString(),
            ]);
        },
        PostWasRenamed::class => function ($state, PostWasRenamed $event) {
            $this->readModel()->stack('renamePost', [
                'postId' => $event->aggregateId(),
                'title' => $event->title()->toString(),
            ]);
        },
    ])
    ->run();