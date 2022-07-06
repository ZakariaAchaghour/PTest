<?php

namespace Product\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Tools\Pagination\Paginator;

 class ProductCollection extends ArrayCollection
{

    private $elements;
    public function __construct(array $elements = [])
    {
        $this->elements = $elements;
    }

    public function toArray()
    {   
        return array_map(function (Product $product) {
            return $product->toArray();
        }, $this->elements ?? []);
    }
}