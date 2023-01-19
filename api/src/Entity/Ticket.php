<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TicketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
#[ApiResource]
#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'ticket', targetEntity: Event::class)]
    private Collection $event;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    private ?User $customer = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    private ?TheaterGroup $theater_group = null;


    public function __construct()
    {
        $this->event = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

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
     * @return Collection<int, Event>
     */
    public function getEvent(): Collection
    {
        return $this->event;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->event->contains($event)) {
            $this->event[] = $event;
            $event->setTicket($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->event->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getTicket() === $this) {
                $event->setTicket(null);
            }
        }

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

    public function getTheaterGroup(): ?TheaterGroup
    {
        return $this->theater_group;
    }

    public function setTheaterGroup(?TheaterGroup $theater_group): self
    {
        $this->theater_group = $theater_group;

        return $this;
    }

    
}
