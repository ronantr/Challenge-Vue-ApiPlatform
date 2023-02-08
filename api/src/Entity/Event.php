<?php

namespace App\Entity;

use App\Repository\EventRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
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
    use TimestampableTrait;

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
    private ?string $imageName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([Event::READ, Event::WRITE])]
    private ?string $videoName = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[Groups([Event::READ])]
    private ?User $theater_group = null;

    #[ORM\Column]
    #[Groups([Event::READ, Event::WRITE])]
    #[NotBlank(message: 'Merci de renseigner une capacité')]
    private ?int $capacity = null;

    /**
     * @Vich\UploadableField(mapping="event_image", fileNameProperty="imageName")
     *
     * @var File|null
     */
    private $imageFile;

    /**
     * @Vich\UploadableField(mapping="event_video", fileNameProperty="videoName")
     *
     * @var File|null
     */
    private $videoFile;

    

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: Ticket::class)]
    private Collection $tickets;


    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    
    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
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

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getVideoName(): ?string
    {
        return $this->videoName;
    }

    public function setVideoName(string $videoName): self
    {
        $this->videoName = $videoName;

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
