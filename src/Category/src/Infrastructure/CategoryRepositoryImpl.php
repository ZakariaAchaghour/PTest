<?php

namespace Category\Infrastructure;

use Category\Model\Category;
use Category\Model\Repository\CategoryRepository;
use Category\Model\ValueObjects\CategoryId;
use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Prooph\EventStore\EventStore;

class CategoryRepositoryImpl extends AggregateRepository implements CategoryRepository
{
    public function __construct(EventStore $eventStore)
    {
        //We inject a Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator that can handle our AggregateRoots
        parent::__construct(
            $eventStore,
            AggregateType::fromAggregateRootClass(Category::class),
            new AggregateTranslator(),
            null, //We don't use a snapshot store in the example
            null, //Also a custom stream name is not required
            true //But we enable the "one-stream-per-aggregate" mode
        );
    }

    public function save(Category $category): void
    {
        // TODO: Implement save() method.
        $this->saveAggregateRoot($category);

    }

    public function get(CategoryId $categoryId): Category
    {
        // TODO: Implement get() method.
        return $this->getAggregateRoot($categoryId->toString());

    }
}