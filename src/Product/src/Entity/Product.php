<?php
declare(strict_types=1);

namespace Product\Entity;

use Category\Entity\Category;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;

/**
 * @ORM\Entity(repositoryClass="ProductRepository"))
 * @ORM\Table(name="products")
 */
class Product {

    /**
     * @var \Ramsey\Uuid\UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    private $id;
   /**
     * @ORM\Column(type="string",nullable=false)
     * @var string
     */
    private $name;
   /**
     * @ORM\Column(type="string",nullable=false)
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="decimal",scale=2,nullable=false)
     * 
     */
    private $price;
      /**
     * @ORM\Column(type="datetime",name="created_at",nullable=false)
     * @var DateTime
     */
    private $createdAt;
      /**
     * @ORM\Column(type="datetime",name="updated_at",nullable=true)
     * @var DateTime
     */
    private $updatedAt;
      /**
     * @ORM\Column(type="datetime",name="deleted_at",nullable=true)
     * @var DateTime
     */
    private $deletedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products" , fetch="EAGER")
     * @ORM\JoinColumn(name="category_id",nullable=false, referencedColumnName="id")
     */
    private $category;
    

    public function __construct()
    {

    }
    
    public function getId()
    {
        return $this->id;
    }
 
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
 
    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

     /**
     * @param \DateTime $created
     * @throws \Exception
     */
    public function setCreatedAt(\DateTime $created = null): void
    {
        if (!$created && empty($this->getId())) {
            $this->createdAt = new \DateTime("now");
        } else {
            $this->createdAt = $created;
        }
    }
   

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

   /**
     * @param \DateTime $modified
     * @throws \Exception
     */
    public function setUpdatedAt(\DateTime $updatedAt = null): void
    {
        if (!$updatedAt) {
            $this->updatedAt = new \DateTime("now");
        } else {
            $this->updatedAt = $updatedAt;
        }
    }

    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

     /**
     * @param \DateTime $modified
     * @throws \Exception
     */
    public function setDeletedAt(\DateTime $deletedAt = null): void
    {
        if (!$deletedAt) {
            $this->deletedAt = new \DateTime("now");
        } else {
            $this->deletedAt = $deletedAt;
        }
    }
     
    public function getPrice()
    {
        return $this->price;
    }

     
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory()
    {
        
        return $this->category;
    }

     
    public function setCategory(Category $category)
    {
        $category->addProduct($this);
        $this->category = $category;

        return $this;
    }

    public function setProduct(array $requestBody) :void {
        $this->setName($requestBody['name']);
        $this->setDescription($requestBody['description']);
        $this->setPrice($requestBody['price']);
        $this->setUpdatedAt(new DateTime());
    }
    
   
}