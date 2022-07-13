<?php
declare(strict_types=1);

namespace Post\ReadModel\Queries;

use Post\Model\ValueObjects\PostId;
use Prooph\Common\Messaging\PayloadTrait;
use Prooph\Common\Messaging\Query;

class GetPostById extends Query
{
    use PayloadTrait;

    public function postId(): PostId
    {
        return $this->postId;
    }
}
