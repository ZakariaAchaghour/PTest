<?php
namespace Category\Model\ValueObjects;


use Assert\Assertion;

class Name
{

    /**
     * @var string
     */
    private $name;

    public static function fromString(string $name) {
        Assertion::notEmpty($name);
        return new self($name);
    }
    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function toString():string
    {
        return $this->name;
    }

}