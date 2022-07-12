<?php

declare(strict_types=1);

namespace Category\App\Handlers;

use Category\App\Commands\CreateCategory;
use Category\Model\Category;
use Category\Model\Repository\CategoryRepository;
use Psr\Http\Server\RequestHandlerInterface;

/**
 *
 */
class CreateCategoryHandler
{
    /**
     * @var
     */
    private $categoryRepository;

    /**
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->$categoryRepository = $categoryRepository;
    }

    /**
     * @param CreateCategory $command
     * @return void
     */
    public function handle(CreateCategory $command): void
    {

        $category = Category::create($command->categoryId(), $command->name());

        $this->categoryRepository->save($category);
    }
}
