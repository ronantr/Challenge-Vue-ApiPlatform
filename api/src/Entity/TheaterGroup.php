<?php

namespace App\Entity;

use App\Repository\TheaterGroupRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\User;
use App\Entity\MediaObject;

#[ApiResource(
normalizationContext: ['groups' => [User::READ]],
denormalizationContext: ['groups' => [User::WRITE]],
)]
#[Get]
#[GetCollection]
#[Post(
uriTemplate: '/join',
denormalizationContext: ['groups' => [TheaterGroup::WRITE]],
)]
#[Patch]
#[ORM\Entity(repositoryClass: TheaterGroupRepository::class)]
class TheaterGroup
{
  const READ = 'theaterGroup:read';
  const WRITE = 'theaterGroup:write';
  const PATCH = 'theaterGroup:patch';

  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column()]
  private ?int $id = null;

  #[ORM\OneToOne(inversedBy: 'theaterGroup', cascade: ['persist', 'remove'])]
  private ?User $representative = null;

  #[ORM\Column(options: ['default' => false])]
  #[ApiProperty(security: 'is_granted("ROLE_ADMIN")')]
  private ?bool $isVerified = false;

  #[ORM\Column(length: 255)]
  #[Groups([TheaterGroup::READ, TheaterGroup::WRITE])]
  private ?string $name = null;

  #[ORM\Column(length: 255)]
  #[Groups([TheaterGroup::READ, TheaterGroup::WRITE])]
  private ?string $phoneNumber = null;

  #[ORM\OneToOne(targetEntity: MediaObject::class)]
  #[ORM\JoinColumn(nullable: true)]
  #[ApiProperty]
  public ?MediaObject $receipt = null;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getRepresentative(): ?User
  {
    return $this->representative;
  }

  public function setRepresentative(?User $representative): self
  {
    $this->representative = $representative;

    return $this;
  }

  public function isVerified(): ?bool
  {
    return $this->isVerified;
  }

  public function setIsVerified(bool $isVerified): self
  {
    $this->isVerified = $isVerified;

    return $this;
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

  public function getPhoneNumber(): ?string
  {
      return $this->phoneNumber;
  }

  public function setPhoneNumber(string $phoneNumber): self
  {
      $this->phoneNumber = $phoneNumber;

      return $this;
  }
}