<?php

declare(strict_types=1);

namespace Post\App\Commands;

use Post\Model\ValueObjects\Content;
use Post\Model\ValueObjects\PostId;
use Post\Model\ValueObjects\Title;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;

class ChangeTitlePost extends Command implements PayloadConstructable
{
    
    use PayloadTrait;


    public function postId(): PostId
    {
        // var_dump($this->payload);
        // die;
        return PostId::fromString($this->payload['postId']);
    }
    public function title(): Title
    {
        return Title::fromString($this->payload['title']);
    }

    

}