<?php
declare(strict_types=1);

namespace Product\Services;


use Ramsey\Uuid\Uuid;

interface ProductServiceInterface  {

    /**
     *
     * @return Product[]
     */
    public function findAllProducts();

    /**
     *
     * @return Product
     */
    public function findProduct($id); 

     /**
     *
     * @return Product
     */
    public function storeProduct($data); 

    /**
     *
     * @return Product
     */
    public function updateProduct($id,$data); 



    /**
     *
     * @return bool
     */
    public function deleteProduct($id); 


}

