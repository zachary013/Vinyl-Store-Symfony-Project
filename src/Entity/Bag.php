<?php

namespace App\Entity;

use App\Repository\BagRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BagRepository::class)]
class Bag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::OBJECT)]
    private ?object $user = null;

    #[ORM\Column(type: Types::OBJECT)]
    private ?object $product = null;

    #[ORM\Column]
    private ?int $quantity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getUser(): ?object
    {
        return $this->user;
    }

    public function setUser(object $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getProduct(): ?object
    {
        return $this->product;
    }

    public function setProduct(object $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
}
