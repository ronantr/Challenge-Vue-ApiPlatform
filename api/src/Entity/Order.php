<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource]
#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{

  const READ = 'order:read';
  const WRITE = 'order:write';
  

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $customer = null;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: Ticket::class)]
    private Collection $tickets;

    #[Groups([Order::WRITE])]
    private ?string $token ="";

    #[Groups([Order::WRITE])]
    private ?array $items = [];


    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
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

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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
      $ticket->setOrder($this);
    }

    return $this;
  }

  public function removeTicket(Ticket $ticket): self
  {
    if ($this->tickets->removeElement($ticket)) {
      // set the owning side to null (unless already changed)
      if ($ticket->getOrder() === $this) {
        $ticket->setOrder(null);
      }
    }
}

public function getToken(): ?string
{
    return $this->token;
}

public function setToken(string $token): self
{
    $this->token = $token;

    return $this;
}

public function getItems(): ?array
{
    return $this->items;

}

}
  
