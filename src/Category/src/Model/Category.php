<?php
declare(strict_types=1);

namespace Category\Model;


use Category\Model\Events\CategoryWasCreated;
use Category\Model\ValueObjects\CategoryId;
use Category\Model\ValueObjects\Name;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;

class Category extends AggregateRoot
{

    /**
     * @var CategoryId
     */
    private $categoryId;

    /**
     * @var Name
     */
    private $name;

    public static function create(CategoryId $categoryId, Name $name): Category
    {
        $category = new Category();
        $category->recordThat(CategoryWasCreated::with($categoryId, $name));
        return $category;
    }
    protected function aggregateId(): string
    {
        // TODO: Implement aggregateId() method.
        return $this->categoryId->toString();
    }

    /**
     * @return CategoryId
     */
    public function getCategoryId(): CategoryId
    {
        return $this->categoryId;
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    protected function apply(AggregateChanged $event): void
    {
        switch (get_class($event)) {
            case CategoryWasCreated::class:
                //Simply assign the event payload to the appropriate properties
                $this->categoryId = $event->aggregateId();
                $this->name = $event->name();
                break;
            default:
                throw new \RuntimeException('Invalid event given');
        }
    }

}
