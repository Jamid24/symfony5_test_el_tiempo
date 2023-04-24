<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $product_id;

    #[ORM\Column(length: 100)]
    private ?string $name;

    #[ORM\Column(length: 13)]
    private ?string $ean13;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $reference;

    #[ORM\Column]
    private ?int $quantity;
    
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
        $this->product_id = null;
        $this->is_active = true;
        $this->is_eliminate = false;
        $this->quantity = 0;
        $this->date_add = new \DateTime();
        $this->date_upd = new \DateTime();
    }
    
    public function getProductId(): ?int
    {
        return $this->product_id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getEan13(): ?string
    {
        return $this->ean13;
    }

    public function setEan13(string $ean13): self
    {
        $this->ean13 = $ean13;
        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;
        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;
        return $this;
    }

    public function isIsEliminate(): ?bool
    {
        return $this->is_eliminate;
    }

    public function setIsEliminate(bool $is_eliminate): self
    {
        $this->is_eliminate = $is_eliminate;
        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->date_add;
    }

    public function setDateAdd(\DateTimeInterface $date_add): self
    {
        $this->date_add = $date_add;
        return $this;
    }

    public function getDateUpd(): ?\DateTimeInterface
    {
        return $this->date_upd;
    }

    public function setDateUpd(\DateTimeInterface $date_upd): self
    {
        $this->date_upd = $date_upd;
        return $this;
    }
        
}
