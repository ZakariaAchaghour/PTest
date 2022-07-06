<?php
declare(strict_types=1);

namespace Product\Services;

use Nette\Utils\Strings;
use Assert\Assert;
use Category\Entity\Category;
use DateTime;
use Doctrine\ORM\EntityManager;
use Product\Entity\Price;
use Product\Entity\Product;
use Product\Entity\ProductCollection;
use Product\Services\ProductServiceInterface;

class ProductService implements ProductServiceInterface {


    private $categoryRepository;
    private $productRepository;

    private $entityManager;
    
    public function __construct(
        EntityManager $entityManager
        )
    {
        $this->entityManager = $entityManager;
        $this->categoryRepository = $entityManager->getRepository(Category::class);
        $this->productRepository = $entityManager->getRepository(Product::class);

    }

    /**
     * {@inheritDoc}
     */
    public function findAllProducts(){
        
        $products = $this->productRepository->findAll();
        $products = new ProductCollection($products);
        return $products->toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function findProduct($id) {
        $product = $this->productRepository->findById($id);
        return  $product;
    }
    /**
     * {@inheritDoc}
     */
    public function storeProduct($data){
        $name = $data['name'];
        $description = $data['description'];
        $slug = $data['slug'];
        $categories = $data['categories'];
        $price = $data['price'];
        Assert::that($name,'Name')
                ->notEmpty()
                ->string()
                ->minLength(3);
        Assert::that($description,'Description')
                ->notEmpty()
                ->string()
                ->minLength(3);
        Assert::that($categories,'Categories')
                ->isArray()
                ->notBlank();
        $product = new Product();
        $product->setName($name);
        $product->setDescription($description);
        $product->setPrice(new Price($price));
        $product->setCreatedAt(new DateTime());
        $product->setUpdatedAt(new DateTime());
        $product->setSlug($slug);
        if(empty($slug)){
            $product->setSlug(Strings::webalize($name));
        } 
        for ($i=0; $i < count($categories); $i++) { 
            $category = $this->categoryRepository->find($categories[$i]);
            $product->setCategory($category);
        }
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    
        var_dump($product);
        die;
       return $product->toArray();
    }
    /**
     * {@inheritDoc}
     */
    
    public function updateProduct($id,$data){
       
        $name = $data['name'];
        $description = $data['description'];
        $slug = $data['slug'];
        $categories = $data['categories'];
        $price = $data['price'];
        Assert::that($name,'Name')
                ->notEmpty()
                ->string()
                ->minLength(3);
        Assert::that($description,'Description')
                ->notEmpty()
                ->string()
                ->minLength(3);
        Assert::that($categories,'Categories')
                ->isArray()
                ->notBlank();
        $product = $this->findProduct($id);
        $product->setName($name);
        $product->setDescription($description);
        $product->setPrice(new Price($price));
        $product->setUpdatedAt(new DateTime());
        $product->setSlug($slug);
        if(empty($slug)){
            $product->setSlug(Strings::webalize($name));
        } 
        for ($i=0; $i < count($categories); $i++) { 
            $category = $this->categoryRepository->find($categories[$i]);
            $product->setCategory($category);
        }

            $this->entityManager->merge($product);
            $this->entityManager->flush();

            
        return $product->toArray();
    }

    public function deleteProduct($id){
        $product = $this->findProduct($id);
        $product->setDeletedAt(new DateTime());

        $this->entityManager->merge($product);
        $this->entityManager->flush();
        return null;
    }

    

}

