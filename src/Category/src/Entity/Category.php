<?php
declare(strict_types=1);

namespace Category\Entity;


use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Product\Entity\Product;
use Product\Entity\ProductCollection;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Category\Repositories\CategoryRepository;

use Ramsey\Uuid\Uuid;
use Shared\Model;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @ORM\Table(name="categories")
 */
class Category implements Model
{
   /**
     * @var Uuid
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    protected $id;
    /**
     * @ORM\Column(type="string", nullable=false, length=255)
     */
    protected $name;
    /**
    * @ORM\Column(type="string", nullable=false, length=255)
    */
    protected $slug;
     /**
     * @ORM\Column(name="created_at" ,type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="updated_at",type="datetime")
     */
    protected $modifiedAt;

    /**
     * @ORM\Column(name="deleted_at",type="datetime",nullable=true)
     */
    protected $deletedAt;

     /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="children", fetch="EAGER")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Category::class, mappedBy="parent", fetch="EAGER")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    
    private $children;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, mappedBy="categories" , fetch="EAGER")
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    public function getId (){
        return $this->id;
    }

    public function getName (): string{
        return $this->name;
    }

    public function setName(string $name): void 
    {
        $this->name = $name;
    }

    public function getSlug (): string{
        return $this->slug;
    }

    public function setSlug(string $slug): void 
    {
        $this->slug = $slug;
    }

   /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->created;
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

    /**
     * @return \DateTime
     */
    public function getModifiedAt(): \DateTime
    {
        return $this->modifiedAt;
    }

    /**
     * @param \DateTime $modified
     * @throws \Exception
     */
    public function setModifiedAt(\DateTime $modifiedAt = null): void
    {
        if (!$modifiedAt) {
            $this->modifiedAt = new \DateTime("now");
        } else {
            $this->modifiedAt = $modifiedAt;
        }
    }

     /**
     * @return \DateTime
     */
    public function getDeletedAt(): \DateTime
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

    public function getParent()
    {
       return $this->parent;
    }

    public function setParent($category)
    {
        $this->parent = $category;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function setChildren($children)
    {
        foreach ($children as $child) {
            $this->children[] = $child;
        }
    }
    public function getProducts()
    {
        return $this->products;
    }

    public function setProduct(Product $product)
    {
        $this->products[] = $product;
    }
   

   

    public function toArray($withRelation)
    {
        $data = [
            'id'=>  $this->id,
            'name'=>  $this->name,
            'slug'=> $this->slug,
            'created_at' => $this->createdAt
        ];
        if($withRelation && $this->parent!= NULL) {
            $parent = [
                'id' => $this->parent->id,
                'name' => $this->parent->name
            ];
            $data['parent'] = $parent;
        }
        if($withRelation && !$this->children->isEmpty()){
            $data['children'] = (new CategoryCollection($this->children->getValues()))->toArray(false);
        }
        if($withRelation && !$this->products->isEmpty()){
            $data['products'] = (new ProductCollection($this->products->getValues()))->toArray(false);
        }

        return $data;
    }
}