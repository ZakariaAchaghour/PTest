<?php

namespace Category\Model\Events;

use Category\Model\ValueObjects\CategoryId;
use Category\Model\ValueObjects\Name;
use Prooph\EventSourcing\AggregateChanged;

class CategoryWasCreated extends AggregateChanged
{
    /**
     * @var CategoryId
     */
    private $categoryId;

    /**
     * @var Name
     */
    private $name;

    public static function with(CategoryId $categoryId, Name $name): CategoryWasCreated
    {
        $event = self::occur($categoryId->toString(),[
            'name' => $name->toString()
        ]);
        $event->categoryId = $categoryId;
        $event->name = $name;
        return $event;
    }

    /**
     * @return CategoryId
     */
    public function categoryId(): CategoryId
    {
        if ($this->categoryId === null) {
            $this->categoryId = CategoryId::fromString($this->aggregateId());
        }
        return $this->categoryId;
    }

    /**
     * @return Name
     */
    public function name(): Name
    {
        if ($this->name === null) {
            $this->name = Name::fromString($this->payload['name']);
        }
        return $this->name;
    }
}