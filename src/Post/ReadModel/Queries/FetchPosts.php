<?php
declare(strict_types=1);

namespace Post\ReadModel\Queries;

use Prooph\Common\Messaging\PayloadTrait;
use Prooph\Common\Messaging\Query;

class FetchPosts extends Query
{
    /**
     * @var string
     */
    protected $messageName = 'fetch-posts';
    
    use PayloadTrait;
}
