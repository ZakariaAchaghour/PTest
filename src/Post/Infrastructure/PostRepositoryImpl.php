<?php

namespace Post\Infrastructure;

use Post\Model\Post;
use Post\Model\Repository\PostRepository;
use Post\Model\ValueObjects\PostId;
use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Prooph\EventStore\EventStore;

class PostRepositoryImpl extends AggregateRepository implements PostRepository
{

    // public function __construct(EventStore $eventStore)
    // {
    //     //We inject a Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator that can handle our AggregateRoots
    //     parent::__construct(
    //         $eventStore,
    //         AggregateType::fromAggregateRootClass(Post::class),
    //         new AggregateTranslator(),
    //         null, //We don't use a snapshot store in the example
    //         null, //Also a custom stream name is not required
    //         true //But we enable the "one-stream-per-aggregate" mode
    //     );
    // }
    public function save(Post $post): void
    {
        $this->saveAggregateRoot($post);
    }

    public function get(PostId $postId): Post
    {
        return $this->getAggregateRoot($postId->toString());
    }
}