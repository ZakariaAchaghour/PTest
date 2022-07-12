<?php
namespace Category\Model\ValueObjects;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class CategoryId
{

    /**
     * @var UuidInterface
     */
    private $categoryId;

    public static function fromUuid(UuidInterface $categoryId): CategoryId {
        return new self($categoryId);
    }

    public static function fromString(string $categoryId) {
        if(!Uuid::isValid($categoryId)){
            throw new \InvalidArgumentException('Invalid uuid given');
        }
        return new self(Uuid::fromString($categoryId));
    }
    /**
     * @param UuidInterface $categoryId
     */
    public function __construct(UuidInterface $categoryId)
    {
        $this->categoryId = $categoryId;
    }

    public function toString(): string
    {
        return $this->categoryId->toString();
    }

}