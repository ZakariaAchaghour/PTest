<?php

namespace Post\Infrastructure;

use Post\Model\Post;
use Post\Model\Repository\PostRepository;
use Post\Model\ValueObjects\PostId;
use Prooph\EventSourcing\Aggregate\AggregateRepository;

class EventStorePostCollection extends AggregateRepository implements PostRepository
{

    public function save(Post $post): void
    {
        // TODO: Implement save() method.
        $this->saveAggregateRoot($post);
    }

    public function get(PostId $postId): Post
    {
        return $this->getAggregateRoot($postId->toString());
    }
}