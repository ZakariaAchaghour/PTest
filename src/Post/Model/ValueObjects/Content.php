<?php

namespace Post\Model\ValueObjects;

use Assert\Assertion;

class Content
{

    /**
     * @var string
     */
    private $content;

    public static function fromString(string $content) {
        Assertion::notEmpty($content);
        return new self($content);
    } 
    /**
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function toString():string
    {
        return $this->content;
    }

}