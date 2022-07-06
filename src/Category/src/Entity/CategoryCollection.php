<?php
namespace Category\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class CategoryCollection extends ArrayCollection 
{
    private $elements;
    public function __construct(array $elements = [])
    {
        $this->elements = $elements;
    }

    public function toArray()
    {   
        return array_map(function (Category $category) {
            return $category->toArray();
        }, $this->elements ?? []);
    }

    public function first()
    {
        return reset($this->elements);
    }
    
}