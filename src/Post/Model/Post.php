<?php

declare(strict_types=1);

namespace Post\Model;

use Post\Model\Events\PostWasCreated;
use Post\Model\ValueObjects\Content;
use Post\Model\ValueObjects\PostId;
use Post\Model\ValueObjects\Title;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;

class Post extends AggregateRoot
{
    /**
     * @var PostId
     */
    private $postId;

    /**
     * @var Title
     */
    private $title;

    /**
     * @var Content
     */
    private $content;

    public static function create(PostId $postId, Title $title, Content $content): Post
    {
        $post = new Post();
        $post->recordThat(PostWasCreated::with($postId, $title,$content));
        return $post;
    }
    protected function aggregateId(): string
    {
        // TODO: Implement aggregateId() method.
        return $this->postId->toString();
    }

    /**
     * @return PostId
     */
    public function postId(): PostId
    {
        return $this->postId;
    }
    /**
     * @return Title
     */
    public function title(): Title
    {
        return $this->title;
    }

    /**
     * @return Content
     */
    public function content(): Content
    {
        return $this->content;
    }


    protected function apply(AggregateChanged $event): void
    {
        // TODO: Implement apply() method.
        if ($event instanceof PostWasCreated) {
            $this->postId = $event->postId();
            $this->title = $event->title();
            $this->content = $event->content();
        } else {
            throw new \RuntimeException('Invalid event given');
        }
        // switch (get_class($event)) {
        //     case PostWasCreated::class:
        //         //Simply assign the event payload to the appropriate properties
        //         $this->postId = $event->aggregateId();
        //         $this->title = $event->title();
        //         $this->content = $event->content();
        //         break;
        //     default:
        //         throw new \RuntimeException('Invalid event given');
        // }
    }
}