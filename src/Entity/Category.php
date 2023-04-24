<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $category_id;
    
    #[ORM\Column(length: 60)]
    private ?string $name;
    
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description;
    
    #[ORM\Column(length: 120, nullable: true)]
    private ?string $short_description;
    
    #[ORM\Column]
    private ?bool $is_active;
    
    #[ORM\Column]
    private ?bool $is_eliminate;
    
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_add;
    
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_upd;
    
    public function __construct()
    {
        $this->category_id = null;
        $this->is_active = true;
        $this->is_eliminate = false;
        $this->date_add = new \DateTime();
        $this->date_upd = new \DateTime();
    }
    
    /**
     * @return NULL
     */
    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    /**
     * @return mixed
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    /**
     * @return boolean
     */
    public function isIsActive(): ?bool
    {
        return $this->is_active;
    }

    /**
     * @return boolean
     */
    public function isIsEliminate(): ?bool
    {
        return $this->is_eliminate;
    }

    /**
     * @return \DateTime
     */
    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->date_add;
    }

    /**
     * @return \DateTime
     */
    public function getDateUpd(): ?\DateTimeInterface
    {
        return $this->date_upd;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @param mixed $short_description
     */
    public function setShortDescription($short_description): void
    {
        $this->short_description = $short_description;
    }

    /**
     * @param boolean $is_active
     */
    public function setIsActive($is_active): void
    {
        $this->is_active = $is_active;
    }

    /**
     * @param boolean $is_eliminate
     */
    public function setIsEliminate($is_eliminate): void
    {
        $this->is_eliminate = $is_eliminate;
    }

    /**
     * @param \DateTime $date_add
     */
    public function setDateAdd($date_add): void
    {
        $this->date_add = $date_add;
    }

    /**
     * @param \DateTime $date_upd
     */
    public function setDateUpd($date_upd): void
    {
        $this->date_upd = $date_upd;
    }
    
}