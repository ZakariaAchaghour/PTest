<?php
declare(strict_types=1);

namespace Category\Services;

use Category\Entity\Category;

interface CategoryServiceInterface  {

    /**
     *
     * @return Category[]
     */
    public function findAllCategories();

    /**
     *
     * @return Category
     */
    public function findCategory($id); 

     /**
     *
     * @return Category
     */
    public function storeCategory($data); 

    /**
     *
     * @return Category
     */
    public function updateCategory($id,$data); 



    /**
     *
     * @return bool
     */
    public function deleteCategory($id); 


}

