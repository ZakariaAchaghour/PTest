<?php

namespace Post\Model\ValueObjects;

use Assert\Assertion;

class Title
{

    /**
     * @var string
     */
    private $title;

    public static function fromString(string $title) {
        Assertion::notEmpty($title);
        return new self($title);
    }
    /**
     * @param string $title
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function toString():string
    {
        return $this->title;
    }

}