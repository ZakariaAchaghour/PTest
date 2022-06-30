<?php
declare(strict_types=1);

namespace Category\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="categories")
 */
class Category 
{

  /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     * @var integer
     */
    protected $id;
    /**
     * @ORM\Column(type="string", nullable=false, length=255)
     */
    protected $name;
     /**
     * @ORM\Column(name="created_at" ,type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="updated_at",type="datetime")
     */
    protected $modifiedAt;

    /**
     * @ORM\Column(name="deleted_at",type="datetime")
     */
    protected $deletedAt;

    public function getId (): int{
        return $this->id;
    }

    public function getName (): string{
        return $this->name;
    }

    public function setName(string $name): void 
    {
        $this->name = $name;
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


    public function setCategory(array $reuestBody) :void {
        $this->setName($reuestBody['name']);
        $this->setModifiedAt(new DateTime());
    }


}