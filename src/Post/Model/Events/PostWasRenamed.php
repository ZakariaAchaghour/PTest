<?php
namespace Post\Model\Events;

use Post\Model\ValueObjects\PostId;
use Post\Model\ValueObjects\Title;
use Prooph\EventSourcing\AggregateChanged;

class PostWasRenamed extends AggregateChanged
{


    public static function updateEmail(PostId  $postId, Title $title): self
    {
        return self::occur($postId->toString(),['title' => $title->toString()]);
    }

    public function title(): Title
    {
        $title = Title::fromString($this->payload['title']);
        return $title;
    }

    
}