<?php

namespace Category\Model\Repository;

use Category\Model\Category;
use Category\Model\ValueObjects\CategoryId;

Interface CategoryRepository
{
    public function save(Category $category): void;

    public function get(CategoryId $categoryId): Category;
}