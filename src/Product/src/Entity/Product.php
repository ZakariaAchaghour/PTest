<?php
declare(strict_types=1);

namespace Product\Entity;

use Category\Entity\Category;
use Category\Entity\CategoryCollection;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Product\Repositories\ProductRepository;
use Shared\Model;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\Table(name="products")
 */
class Product implements Model {

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
    * @ORM\Column(type="string", nullable=false, length=255)
    */
    protected $slug;

   /**
     * @ORM\Column(type="string",nullable=false)
     * @var string
     */
    private $description;

    
     /**
     * @ORM\Embedded(class=Price::class)
     * @var Price
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
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinTable(name="product_category")
     */
    private $categories;
    

    public function __construct()
    {
        $this->categories = new ArrayCollection();
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

    public function getSlug (): string{
        return $this->slug;
    }

    public function setSlug(string $slug)
    {
        $this->slug = $slug;
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

     
    public function setPrice(Price $price)
    {
        $this->price = $price;
    }

    public function getCategories()
    {
        
        return $this->categories;
    }

     
    public function setCategory(Category $category)
    {
        $category->setProduct($this);
        $this->categories[] = $category;
        return $this;
    }

  
    public function toArray($withRelation)
    {
        $data = [
            'id'=>  $this->id,
            'name'=>  $this->name,
            'slug'=> $this->slug,
            'description'=> $this->description,
            'price' => $this->price->getAmount(),
            'created_at' => $this->createdAt
        ];
       
        if($withRelation && !$this->categories->isEmpty()){
            $data['categories'] = (new CategoryCollection($this->categories->getValues()))->toArray(false);
        }

        return $data;
    }
}