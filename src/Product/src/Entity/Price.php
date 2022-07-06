<?php

declare(strict_types=1);

namespace Product\Entity;

use Assert\Assert;
use Assert\Assertion;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Price {

    /**
     * @ORM\Column(type="decimal",scale=2,nullable=false)
     * 
     */
    private $amount;

    public function __construct(float $amount)
    {
        Assert::that($amount, 'price')->float()->greaterThan(0);
        $this->amount = $amount;
    }
    

    public function getAmount(): ?float
    {
        return (float) $this->amount;
    }

    public function equals(Price $price): bool
    {
        return $this->amount === $price->amount;
    }
    public function __toString(): string
    {
        return ''.$this->amount;
    }

}