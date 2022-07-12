<?php

namespace Post\Model\ValueObjects;

use Assert\Assertion;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
class PostId
{

      /**
     * @var UuidInterface
     */
    private $uuid;

    public static function generate(): PostId
    {
        return new self(Uuid::uuid4());
    }

    public static function fromString(string $postId): PostId 
    {
        if(!Uuid::isValid($postId)){
            throw new \InvalidArgumentException('Invalid uuid given');
        }
        return new self(Uuid::fromString($postId));
    }
   
    
    public function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

}