<?php

namespace App\Entity;

use App\Repository\EventRepository;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use App\Controller\GetTheaterGroupEventsController;
use App\Controller\UpdateEventCoverController;

#[Vich\Uploadable]
#[ApiResource]
#[ORM\Entity(repositoryClass: EventRepository::class)]
#[Get(
normalizationContext: ['groups' => [Event::READ]],
)]
#[GetCollection(
normalizationContext: ['groups' => [Event::LIST]],
)]
#[GetCollection(
uriTemplate: '/theater_groups/{id}/events',
normalizationContext: ['groups' => [Event::LIST, Event::LIST_THEATER_GROUP]],
controller: GetTheaterGroupEventsController::class
)]
#[Post(
denormalizationContext: ['groups' => [Event::WRITE]],
securityPostDenormalize: "is_granted('event_create', object)",
inputFormats: ['multipart' => ['multipart/form-data']],
validationContext: ['groups' => ["Default", Event::WRITE]],
)]
#[Post(
uriTemplate: '/update_cover/{id}',
denormalizationContext: ['groups' => [Event::COVER]],
read: false,
inputFormats: ['multipart' => ['multipart/form-data']],
// validationContext: ['groups' => ["Default", Event::COVER]],
controller: UpdateEventCoverController::class
)]
#[Patch(
denormalizationContext: ['groups' => [Event::PATCH]],
securityPostDenormalize: 'is_granted("ROLE_ADMIN") or object.getTheaterGroup().getRepresentative() == user',
)]
#[Delete(
security: 'is_granted("ROLE_ADMIN") or object.getTheaterGroup().getRepresentative() == user',
)]
class Event
{
  const READ = 'event:read';
  const LIST = 'event:list';
  const LIST_THEATER_GROUP = 'event:list_theater_group';
  const WRITE = 'event:write';
  const PATCH = 'event:patch';
  const COVER = 'event:cover';

  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column()]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  #[Assert\NotBlank]
  #[Assert\Length(max: 255)]
  #[Groups([Event::READ, Event::WRITE, Event::PATCH, Event::LIST])]
  private ?string $name = null;

  #[ORM\Column(type: Types::DATETIME_MUTABLE)]
  #[Assert\NotBlank]
  #[Assert\Type(type: \DateTimeInterface::class)]
  #[Assert\GreaterThan('today UTC')]
  #[Assert\Range(
  min: '+1 day UTC',
  max: '+1 year UTC',
  notInRangeMessage: 'The date must be between {{ min }} and {{ max }}'
  )]
  #[Groups([Event::READ, Event::WRITE, Event::PATCH, Event::LIST])]
  private ?\DateTimeInterface $date = null;

  #[ORM\Column(length: 255)]
  #[Assert\NotBlank]
  #[Assert\Length(max: 255)]
  #[Groups([Event::READ, Event::WRITE, Event::PATCH])]
  private ?string $location = null;

  #[ORM\Column(type: Types::TEXT, nullable: true)]
  #[Assert\NotBlank]
  #[Assert\Length(max: 2000)]
  #[Groups([Event::READ, Event::WRITE, Event::PATCH, Event::LIST])]
  private ?string $description = null;

  #[Groups([Event::READ])]
  public ?string $contentUrl = null;

  #[Vich\UploadableField(mapping: "media_object", fileNameProperty: "coverPath")]
  #[Assert\NotBlank(message: 'Please, upload the cover as a JPEG or PNG file.', groups: [Event::WRITE])]
  #[Assert\File(
  maxSize: '5M',
  maxSizeMessage: 'The file is too large ({{ size }} {{ suffix }}). Allowed maximum size is {{ limit }} {{ suffix }}.',
  mimeTypes: ['image/jpeg', 'image/png'],
  mimeTypesMessage: 'The file is not a valid image ({{ type }}). Allowed mime types are {{ types }}.'
  )]
  #[Groups([Event::WRITE, Event::PATCH, Event::COVER])]
  public ?File $cover = null;

  #[ORM\Column(nullable: true)]
  public ?string $coverPath = null;

  #[ORM\Column(length: 255, nullable: true)]
  #[Assert\Regex(
  pattern: '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube(-nocookie)?\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/',
  message: 'The url is not a valid youtube url'
  )]
  #[Assert\Length(max: 255)]
  #[Groups([Event::READ, Event::WRITE, Event::PATCH])]
  private ?string $video = null;

  #[ORM\ManyToOne(inversedBy: 'events')]
  #[ORM\JoinColumn(nullable: false)]
  private ?TheaterGroup $theaterGroup = null;

  #[ORM\Column]
  #[Assert\NotBlank]
  #[Assert\Range(
  min: 1,
  max: 1000,
  notInRangeMessage: 'The capacity must be between {{ min }} and {{ max }}'
  )]
  #[Groups([Event::READ,Event::LIST, Event::WRITE, Event::PATCH])]
  private ?int $capacity = null;

  #[ORM\OneToMany(mappedBy: 'event', targetEntity: Ticket::class)]
  private Collection $tickets;

  #[ORM\Column(options: ['default' => false])]
  #[Groups([Event::READ, Event::PATCH, Event::LIST_THEATER_GROUP])]
  public ?bool $isPublished = false;


  #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['default' => 'CURRENT_TIMESTAMP'])]
  public ?\DateTimeInterface $updatedAt = null;

  #[ORM\Column]
  #[Groups([Event::WRITE, Event::READ, Event::PATCH, Event::LIST])]
  #[Assert\NotBlank]
  #[Assert\Range(
  min: 0,
  max: 2000,
  notInRangeMessage: "The price must be between 0€ and 200€" 
  )]
  private ?int $priceInCents = null;

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

  public function getVideo(): ?string
  {
    return $this->video;
  }

  public function setVideo(string $video): self
  {
    $this->video = $video;

    return $this;
  }

  public function getTheaterGroup(): ?TheaterGroup
  {
    return $this->theaterGroup;
  }

  public function setTheaterGroup(?TheaterGroup $theaterGroup): self
  {
    $this->theaterGroup = $theaterGroup;

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

  public function getIsPublished(): ?bool
  {
    return $this->isPublished;
  }

  public function setIsPublished(bool $isPublished): self
  {
    $this->isPublished = $isPublished;

    return $this;
  }

  public function getPriceInCents(): ?int
  {
      return $this->priceInCents;
  }

  public function setPriceInCents(int $priceInCents): self
  {
      $this->priceInCents = $priceInCents;

      return $this;
  }
}