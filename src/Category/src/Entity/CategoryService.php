<?php
declare(strict_types=1);

namespace Category\Entity;

use Nette\Utils\Strings;
use Assert\Assert;
use DateTime;
use Doctrine\ORM\EntityManager;

class CategoryService implements CategoryServiceInterface {


    private $categoryRepository;
    private $entityManager;
    
    public function __construct(
        EntityManager $entityManager
        )
    {
        $this->entityManager = $entityManager;
        $this->categoryRepository = $entityManager->getRepository(Category::class);

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

        Assert::that($data['name'],'Name')
                ->notEmpty()
                ->string()
                ->minLength(3);
                // ->notEmpty('Name is required.')
                // ->string('Name expected to be string, type integer given.')
                // ->minLength(3,'Name should have at least 3 characters');
        $category = new Category();

            

        $category->setName($data['name']);
        $category->setCreatedAt(new DateTime());
        $category->setModifiedAt(new DateTime());
        $category->setSlug($data['slug']);
        if(empty($data['slug'])){
            $slug = Strings::webalize($data['name']);
            $category->setSlug($slug);
        } 
        if(!empty($data['parent_id'])){
            $parent = $this->findCategory($data['parent_id']);
            $category->setParent($parent);
        }else{
            $category->setParent(NULL);
        }
        $this->entityManager->persist($category);
        $this->entityManager->flush();
    
       return $category->toArray();
    }
    /**
     * {@inheritDoc}
     */
    
    public function updateCategory($id,$data){
       
        
        Assert::that($data['name'])
        ->notEmpty('Name is required.')
        ->string('Name expected to be string, type integer given.')
        ->minLength(3,'Name should have at least 3 characters');

        
            $category = $this->findCategory($id);
            $category->setName($data['name']);
            $category->setModifiedAt(new DateTime());
            $category->setSlug($data['slug']);

            if(empty($data['slug'])){
                $slug = Strings::webalize($data['name']);
                $category->setSlug($slug);
            } 

            $this->entityManager->merge($category);
            $this->entityManager->flush();

        return $category->toArray();
    }

    public function deleteCategory($id){
        $category = $this->findCategory($id);
        $category->setDeletedAt(new DateTime());

        $this->entityManager->merge($category);
        $this->entityManager->flush();
        return null;
    }

    

}

