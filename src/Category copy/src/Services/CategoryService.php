<?php
declare(strict_types=1);

namespace Category\Services;

use Nette\Utils\Strings;
use Assert\Assert;
use Category\Entity\Category;
use Category\Entity\CategoryCollection;
use Doctrine\ORM\EntityManager;
use DateTime;
use Product\Entity\Product;

class CategoryService implements CategoryServiceInterface {


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
    public function findAllCategories(){
        
        $categories = $this->categoryRepository->findAll();
        $categories = new CategoryCollection($categories);
        return $categories->toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function findCategory($id) {
        $category = $this->categoryRepository->findById($id);
        return  $category;
    }
    /**
     * {@inheritDoc}
     */
    public function storeCategory($data){
         $products = isset($data['products']) ? $data['products']: [];
         $name = $data['name'];
         $slug = isset($data['slug']) ? $data['slug'] : '';
         $parent_id = isset($data['parent_id'])? $data['parent_id'] : '';

        $category = new Category();
        $category->setName($name);
        $category->setCreatedAt(new DateTime());
        $category->setModifiedAt(new DateTime());

        if(!empty($slug)){
            $category->setSlug($name);
        }else{
            $slug = Strings::webalize($name);
            $category->setSlug($slug);
        }
        for ($i=0; $i < count($products); $i++) { 
            $product = $this->productRepository->findById($products[$i]);
            $category->setProduct($product);
        }
       
        // parnet_id no in 
        if(!empty($parent_id)){
            $parent = $this->findCategory($parent_id);
            $category->setParent($parent);
        }else{
            $category->setParent(NULL);
        }

        $this->entityManager->persist($category);
        $this->entityManager->flush();
    
       return $category->toArray(false);
    }
    /**
     * {@inheritDoc}
     */
    
    public function updateCategory($id,$data){
        $products = isset($data['products']) ? $data['products']: [];
         $name = $data['name'];
         $slug = isset($data['slug']) ? $data['slug'] : '';
         $parent_id = isset($data['parent_id'])? $data['parent_id'] : '';
        
            $category = $this->findCategory($id);
            $category->setName($data['name']);
            $category->setModifiedAt(new DateTime());
            if(!empty($slug)){
                $category->setSlug($name);
            }else{
                $slug = Strings::webalize($name);
                $category->setSlug($slug);
            }
            for ($i=0; $i < count($products); $i++) { 
           
                $product = $this->productRepository->findById($products[$i]);
               
                $category->setProduct($product);
            }
            // parnet_id no in 
            if(!empty($parent_id)){
                $parent = $this->findCategory($parent_id);
                $category->setParent($parent);
            }else{
                $category->setParent(NULL);
            }

            $this->entityManager->merge($category);
            $this->entityManager->flush();

        return $category->toArray(false);
    }

    public function deleteCategory($id){
        $category = $this->findCategory($id);
        $category->setDeletedAt(new DateTime());

        $this->entityManager->merge($category);
        $this->entityManager->flush();
        return null;
    }

    

}

