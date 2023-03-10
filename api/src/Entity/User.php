<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Regex;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ApiResource(
normalizationContext: ['groups' => [User::READ]],
denormalizationContext: ['groups' => [User::WRITE]],
)]
#[ApiFilter(
OrderFilter::class,
properties: ["firstName", "lastName", "email"],
)]
#[ApiFilter(
SearchFilter::class,
properties: [
'firstName' => 'partial',
'lastName' => 'partial',
'email' => 'partial',
],
)]
#[Get(
security: 'is_granted("ROLE_ADMIN") or object == user',
)]
#[GetCollection]
#[Post]
#[Post(
uriTemplate: "/register",
denormalizationContext: ['groups' => [User::REGISTER]],
output: false,
status: 201,
)]
#[Patch(
denormalizationContext: ['groups' => [User::PATCH]],
)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity('email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
  const READ = 'user:read';
  const WRITE = 'user:write';
  const PATCH = 'user:patch';
  const REGISTER = 'user:register';

  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column()]
  private ?int $id = null;

  #[ORM\Column(length: 180, unique: true, nullable: false)]
  #[Groups([User::READ, User::WRITE, User::REGISTER])]
  #[Email]
  #[NotBlank]
  #[Type('string')]
  private ?string $email = null;

  #[ORM\Column]
  #[Groups([User::READ])]
  private array $roles = [];

  /**
   * @var string The hashed password
   */
  #[ORM\Column(nullable: false)]
  #[Groups([User::WRITE, User::REGISTER])]
  #[NotBlank]
  #[NotCompromisedPassword]
  #[Type('string')]
  #[Regex(
  pattern: '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$/',
  message: 'Password must contain at least 8 characters, 1 uppercase letter, 1 lowercase letter, 1 number and 1 special character'
  )]
  private ?string $password = null;

  #[ORM\Column(length: 255)]
  #[Groups([User::READ, User::WRITE, User::PATCH, User::REGISTER, TheaterGroup::READ])]
  #[NotBlank]
  #[Type('string')]
  private ?string $firstName = null;

  #[ORM\Column(length: 255)]
  #[Groups([User::READ, User::WRITE, User::PATCH, User::REGISTER, TheaterGroup::READ])]
  #[NotBlank]
  #[Type('string')]
  private ?string $lastName = null;

  #[ORM\Column(options: ['default' => 0])]
  #[Patch([
    'security' => "is_granted('ROLE_ADMIN')",
    'security_message' => 'Only admins can update a credit'
  ])]
  #[Groups([User::READ, User::WRITE,User::PATCH])]
  private int $credit = 0;

  #[ORM\OneToMany(mappedBy: 'customer', targetEntity: Order::class)]
  private Collection $orders;

  #[ORM\OneToMany(mappedBy: 'user', targetEntity: Transaction::class)]
  private Collection $transactions;

  #[Groups([User::READ])]
  #[ORM\ManyToOne(inversedBy: 'users')]
  #[ORM\JoinColumn(nullable: true)]
  private ?Level $level = null;

  #[Groups([User::READ])]
  #[ORM\Column]
  private ?int $points = 0;

  #[ORM\OneToMany(mappedBy: 'customer', targetEntity: Token::class, orphanRemoval: true)]
  private Collection $tokens;

  #[ORM\Column(options: ['default' => false])]
  private ?bool $isVerified = false;

  #[ORM\OneToMany(mappedBy: 'representative', targetEntity: TheaterGroup::class, orphanRemoval: true)]
  #[Groups([User::READ])]
  private Collection $theaterGroups;

  #[ORM\OneToMany(mappedBy: 'owner', targetEntity: MediaObject::class)]
  private Collection $mediaObjects;

  public function __construct()
  {
    $this->orders = new ArrayCollection();
    $this->transactions = new ArrayCollection();
    $this->tokens = new ArrayCollection();
    $this->mediaObjects = new ArrayCollection();
    $this->theaterGroups = new ArrayCollection();

    $this->roles = ['ROLE_USER'];
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

  /**
   * A visual identifier that represents this user.
   *
   * @see UserInterface
   */
  public function getUserIdentifier(): string
  {
    return (string) $this->email;
  }

  /**
   * @see UserInterface
   */
  public function getRoles(): array
  {
    $roles = $this->roles;

    return array_unique($roles);
  }

  public function setRoles(array $roles): self
  {
    $this->roles = $roles;

    return $this;
  }

  /**
   * @see PasswordAuthenticatedUserInterface
   */
  public function getPassword(): string
  {
    return $this->password;
  }

  public function setPassword(string $password): self
  {
    $this->password = $password;

    return $this;
  }

  /**
   * @see UserInterface
   */
  public function eraseCredentials()
  {
    // If you store any temporary, sensitive data on the user, clear it here
    // $this->plainPassword = null;
  }

  public function getFirstname(): ?string
  {
    return $this->firstName;
  }

  public function setFirstname(string $firstName): self
  {
    $this->firstName = $firstName;

    return $this;
  }

  public function getLastname(): ?string
  {
    return $this->lastName;
  }

  public function setLastname(string $lastName): self
  {
    $this->lastName = $lastName;

    return $this;
  }

  public function getCredit(): ?int
  {
    return $this->credit;
  }

  public function setCredit(int $credit): self
  {
    $this->credit = $credit;
    return $this;
  }

  public function addCredit(int $credit): self
  {
    $this->credit += $credit;
    return $this;
  }

  /**
   * @return Collection<int, Order>
   */
  public function getOrders(): Collection
  {
    return $this->orders;
  }

  public function addOrder(Order $order): self
  {
    if (!$this->orders->contains($order)) {
      $this->orders[] = $order;
      $order->setCustomer($this);
    }

    return $this;
  }

  public function removeOrder(Order $order): self
  {
    if ($this->orders->removeElement($order)) {
      // set the owning side to null (unless already changed)
      if ($order->getCustomer() === $this) {
        $order->setCustomer(null);
      }
    }

    return $this;
  }

  /**
   * @return Collection<int, Transaction>
   */
  public function getTransactions(): Collection
  {
    return $this->transactions;
  }

  public function addTransaction(Transaction $transaction): self
  {
    if (!$this->transactions->contains($transaction)) {
      $this->transactions[] = $transaction;
      $transaction->setUser($this);
    }

    return $this;
  }

  public function removeTransaction(Transaction $transaction): self
  {
    if ($this->transactions->removeElement($transaction)) {
      // set the owning side to null (unless already changed)
      if ($transaction->getUser() === $this) {
        $transaction->setUser(null);
      }
    }

    return $this;
  }

  public function getLevel(): ?Level
  {
      return $this->level;
  }

  public function setLevel(?Level $level): self
  {
      $this->level = $level;

      return $this;
  }


  public function getPoints(): ?int
  {
      return $this->points;
  }

  public function setPoints(int $points): self
  {
      $this->points = $points;

      return $this;
  }

  /**
   * @return Collection<int, Token>
   */
  public function getTokens(): Collection
  {
    return $this->tokens;
  }

  public function addToken(Token $token): self
  {
    if (!$this->tokens->contains($token)) {
      $this->tokens[] = $token;
      $token->setCustomer($this);
    }

    return $this;
  }

  public function removeToken(Token $token): self
  {
    if ($this->tokens->removeElement($token)) {
      // set the owning side to null (unless already changed)
      if ($token->getCustomer() === $this) {
        $token->setCustomer(null);
      }
    }

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

  /**
   * @return Collection<int, TheaterGroup>
   */
  public function getTheaterGroups(): Collection
  {
      return $this->theaterGroups;
  }

  public function addTheaterGroup(TheaterGroup $theaterGroup): self
  {
    if (!$this->theaterGroups->contains($theaterGroup)) {
      $this->theaterGroups[] = $theaterGroup;
      $theaterGroup->setRepresentative($this);
    }

    return $this;
  }

  public function removeTheaterGroup(TheaterGroup $theaterGroup): self
  {
    if ($this->theaterGroups->removeElement($theaterGroup)) {
      // set the owning side to null (unless already changed)
      if ($theaterGroup->getRepresentative() === $this) {
        $theaterGroup->setRepresentative(null);
      }
    }

    return $this;
  }

  /**
   * @return Collection<int, MediaObject>
   */
  public function getMediaObjects(): Collection
  {
      return $this->mediaObjects;
  }

  public function addMediaObject(MediaObject $mediaObject): self
  {
      if (!$this->mediaObjects->contains($mediaObject)) {
          $this->mediaObjects[] = $mediaObject;
          $mediaObject->setOwner($this);
      }

      return $this;
  }

  public function removeMediaObject(MediaObject $mediaObject): self
  {
      if ($this->mediaObjects->removeElement($mediaObject)) {
          // set the owning side to null (unless already changed)
          if ($mediaObject->getOwner() === $this) {
              $mediaObject->setOwner(null);
          }
      }

      return $this;
  }
}
