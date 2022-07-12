<?php
declare(strict_types=1);

namespace Post\Model\Events;

use Post\Model\ValueObjects\Content;
use Post\Model\ValueObjects\PostId;
use Post\Model\ValueObjects\Title;
use Prooph\Common\Messaging\PayloadTrait;
use Prooph\EventSourcing\AggregateChanged;

class PostWasCreated extends AggregateChanged
{

   /**
    * @var string
    */
   protected $messageName = 'post-was-created';

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

    public static function with(PostId  $postId, Title $title, Content $content): PostWasCreated
    {
        $event = self::occur($postId->toString(),[
            'title' => $title->toString(),
            'content' => $content->toString()
        ]);
        $event->postId = $postId;
        $event->title = $title;
        $event->content = $content;
        return $event;
    }

    /**
     * @return PostId
     */
    public function postId(): PostId
    {
        if ($this->postId === null) {
            $this->postId = PostId::fromString($this->aggregateId());
        }
        return $this->postId;
    }

    /**
     * @return Title
     */
    public function title(): Title
    {
        if ($this->title === null) {
            $this->title = Title::fromString($this->payload['title']);
        }
        return $this->title;
    }

    /**
     * @return Content
     */
    public function content(): Content
    {
        if ($this->content === null) {
            $this->content = Content::fromString($this->payload['content']);
        }
        return $this->content;
    }

}