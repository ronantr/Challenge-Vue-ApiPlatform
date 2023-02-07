<?php

namespace App\Entity;

use App\Repository\EventRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ApiResource(
    denormalizationContext: ['groups' => [Event::WRITE]],
    normalizationContext: ['groups' => [Event::READ]],

    operations: [
        
        // new Post(
        //     security: "is_granted('ROLE_USER')",
        // ),
        // new Put(
        //     security: "is_granted('edit', object)",
        // ),
        // new Delete(
        //     security: "is_granted('delete', object)",
        // ),
    ],
)]
#[GetCollection]
#[Get]
#[Post(security: "is_granted('ROLE_USER')")]
#[Put(security: "is_granted('edit', object)")]
#[Delete(security: "is_granted('delete', object)")]
#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    const READ = 'event:read';
    const WRITE = 'event:write';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups([Event::READ, Event::WRITE])]
    #[NotBlank(message: 'Merci de renseigner un nom')]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups([Event::READ, Event::WRITE])]
    #[NotBlank(message: 'Merci de renseigner une date')]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    #[Groups([Event::READ, Event::WRITE])]
    #[NotBlank(message: 'Merci de renseigner un lieu')]
    private ?string $location = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups([Event::READ, Event::WRITE])]
    #[NotBlank(message: 'Merci de renseigner une description')]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([Event::READ, Event::WRITE])]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([Event::READ, Event::WRITE])]
    private ?string $video = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[Groups([Event::READ])]
    private ?User $theater_group = null;

    #[ORM\Column]
    #[Groups([Event::READ, Event::WRITE])]
    #[NotBlank(message: 'Merci de renseigner une capacité')]
    private ?int $capacity = null;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: Ticket::class)]
    private Collection $tickets;


    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getTheaterGroup(): ?User
    {
        return $this->theater_group;
    }

    public function setTheaterGroup(?User $theater_group): self
    {
        $this->theater_group = $theater_group;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

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
            $ticket->setEvent($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getEvent() === $this) {
                $ticket->setEvent(null);
            }
        }
        return $this;
    }
}
