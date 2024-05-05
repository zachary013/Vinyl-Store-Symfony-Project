<?php
// src/Entity/User.php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 180)]
    private ?string $email = null;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $username = null; // New username property


    #[ORM\Column(type: "json")]
    private array $roles = [];

    #[ORM\Column(type: "string")]
    private ?string $password = null;

    #[ORM\Column(type: "boolean")]
    private bool $isVerified = false;

    /**
     * @var Collection<Product>
     *
     * #[ORM\ManyToMany(targetEntity: Product::class)]
     * #[ORM\JoinTable(name: "user_bag",
     *      joinColumns: [#[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]],
     *      inverseJoinColumns: [#[ORM\JoinColumn(name: "product_id", referencedColumnName: "id")]]
     * )]
     */
    private Collection $bag;

    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
        $this->bag = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER'; // Ensure every user has ROLE_USER

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<Product>
     */
    public function getBag(): Collection
    {
        return $this->bag;
    }

    public function addToBag(Product $product): void
    {
        if (!$this->bag->contains($product)) {
            $this->bag->add($product);
        }
    }

    public function removeFromBag(Product $product): void
    {
        $this->bag->removeElement($product);
    }
}
