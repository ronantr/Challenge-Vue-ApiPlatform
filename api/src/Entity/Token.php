<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Repository\TokenRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\VerifyTokenController;

#[ApiResource]
#[Post(uriTemplate: '/verify', controller: VerifyTokenController::class)]
#[ORM\Entity(repositoryClass: TokenRepository::class)]
class Token
{
  #[ORM\Id]
  #[ORM\Column(length: 255)]
  private ?string $id = null;

  #[ORM\Column]
  private ?\DateTimeImmutable $expire_at = null;

  #[ORM\ManyToOne(inversedBy: 'tokens')]
  #[ORM\JoinColumn(nullable: false)]
  private ?User $customer = null;

  public function getId(): ?string
  {
    return $this->id;
  }

  public function setId(string $value): self
  {
    $this->id = $value;

    return $this;
  }

  public function getExpireAt(): ?\DateTimeImmutable
  {
    return $this->expire_at;
  }

  public function setExpireAt(\DateTimeImmutable $expire_at): self
  {
    $this->expire_at = $expire_at;

    return $this;
  }

  public function getCustomer(): ?User
  {
    return $this->customer;
  }

  public function setCustomer(?User $customer): self
  {
    $this->customer = $customer;

    return $this;
  }
}