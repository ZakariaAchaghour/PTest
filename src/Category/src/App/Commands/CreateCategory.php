<?php

namespace Category\App\Commands;

use Category\Model\ValueObjects\CategoryId;
use Category\Model\ValueObjects\Name;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;

class CreateCategory extends Command
{
    use PayloadTrait;

    public function categoryId(): CategoryId
    {
        return CategoryId::fromString($this->payload['categoryId']);
    }
    public function name(): Name
    {
        return Name::fromString($this->payload['name']);
    }
}