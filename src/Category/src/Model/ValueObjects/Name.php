<?php
namespace Category\Model\ValueObjects;

use Assert\Assert;
use Assert\Assertion;

class Name
{

    /**
     * @var string
     */
    private $name;

    public static function fromString(string $name) {
        Assert::that($name)->notEmpty('The Name field is required.')
                                 ->string('The Name must be a string.')
                                 ->minLength(3,'The Name must be greater than 3 characters.');
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