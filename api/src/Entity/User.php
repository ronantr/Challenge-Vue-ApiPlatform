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
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\Type;

#[ApiResource(
normalizationContext: ['groups' => [User::READ]],
denormalizationContext: ['groups' => [User::WRITE]],
)]
#[Get]
#[GetCollection]
#[Post]
#[Patch(
denormalizationContext: ['groups' => [User::PATCH]],
)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
  const READ = 'user:read';
  const WRITE = 'user:write';
  const PATCH = 'user:patch';


  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column()]
  private ?int $id = null;

  #[ORM\Column(length: 180, unique: true, nullable: false)]
  #[Groups([User::READ, User::WRITE])]
  #[Email]
  #[NotBlank]
  #[Type('string')]
  private ?string $email = null;

  #[ORM\Column]
  private array $roles = [];

  /**
   * @var string The hashed password
   */
  #[ORM\Column(nullable: false)]
  #[Groups([User::WRITE, User::PATCH])]
  #[NotBlank]
  #[NotCompromisedPassword]
  #[Type('string')]
  #[Regex(
  pattern: '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$/',
  message: 'Password must contain at least 8 characters, 1 uppercase letter, 1 lowercase letter, 1 number and 1 special character'
  )]
  private ?string $password = null;

  #[ORM\Column(length: 255)]
  #[Groups([User::READ, User::WRITE, User::PATCH])]
  #[NotBlank]
  #[Type('string')]
  private ?string $firstname = null;

  #[ORM\Column(length: 255)]
  #[Groups([User::READ, User::WRITE, User::PATCH])]
  #[NotBlank]
  #[Type('string')]
  private ?string $lastname = null;

  #[ORM\Column(options: ['default' => 0])]
  #[Groups([User::READ])]
  private int $credit = 0;

  #[ORM\OneToMany(mappedBy: 'customer', targetEntity: Order::class)]
  private Collection $orders;

  #[ORM\OneToMany(mappedBy: 'customer', targetEntity: Ticket::class)]
  private Collection $tickets;

  public function __construct()
  {
    $this->orders = new ArrayCollection();
    $this->tickets = new ArrayCollection();
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
    // guarantee every user at least has ROLE_USER
    $roles[] = 'ROLE_USER';

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
    return $this->firstname;
  }

  public function setFirstname(string $firstname): self
  {
    $this->firstname = $firstname;

    return $this;
  }

  public function getLastname(): ?string
  {
    return $this->lastname;
  }

  public function setLastname(string $lastname): self
  {
    $this->lastname = $lastname;

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
   * @return Collection<int, Ticket>
   */
  public function getTickets(): Collection
  {
    return $this->tickets;
  }

  public function addTicket(Ticket $ticket): self
  {
    if (!$this->tickets->contains($ticket)) {
      $this->tickets[] = $ticket;
      $ticket->setCustomer($this);
    }

    return $this;
  }

  public function removeTicket(Ticket $ticket): self
  {
    if ($this->tickets->removeElement($ticket)) {
      // set the owning side to null (unless already changed)
      if ($ticket->getCustomer() === $this) {
        $ticket->setCustomer(null);
      }
    }

    return $this;
  }
}