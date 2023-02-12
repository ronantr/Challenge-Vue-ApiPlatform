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
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;

#[Vich\Uploadable]
#[ApiResource(
normalizationContext: ['groups' => [TheaterGroup::READ]],
denormalizationContext: ['groups' => [TheaterGroup::WRITE]],
)]
#[ApiFilter(
OrderFilter::class,
properties: ["status" => "DESC", "name" => "ASC", "phoneNumber" => "ASC",],
)]
#[Get(security: 'is_granted("ROLE_ADMIN") or object.getRepresentative() == user')]
#[GetCollection(
security: 'is_granted("ROLE_ADMIN")')
]
#[Post(
uriTemplate: '/join',
denormalizationContext: ['groups' => [TheaterGroup::WRITE]],
securityPostDenormalize: 'is_granted("theater_group_create", object)',
securityPostDenormalizeMessage: 'You already have a theater group submission that is not closed.',
inputFormats: ['multipart' => ['multipart/form-data']],
validationContext: ['groups' => ["Default", TheaterGroup::WRITE]],
)]
#[Patch(
denormalizationContext: ['groups' => [TheaterGroup::PATCH]],
)]
#[ORM\Entity(repositoryClass: TheaterGroupRepository::class)]
#[UniqueEntity(fields: ['name'], message: 'This name is already used.', repositoryMethod: 'findNotClosedTheaterGroupsByName')]
#[UniqueEntity(fields: ['phoneNumber'], message: 'This phone number is already used.', repositoryMethod: 'findNotClosedTheaterGroupsByPhoneNumber')]
class TheaterGroup
{
  const READ = 'theaterGroup:read';
  const WRITE = 'theaterGroup:write';
  const PATCH = 'theaterGroup:patch';

  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column()]
  private ?int $id = null;

  #[ORM\ManyToOne(inversedBy: 'theaterGroups')]
  #[ORM\JoinColumn(nullable: false)]
  #[Groups([TheaterGroup::READ, TheaterGroup::WRITE])]
  private ?User $representative = null;

  #[ORM\Column(length: 255, options: ['default' => 'pending'])]
  #[Groups([TheaterGroup::READ, TheaterGroup::PATCH, User::READ])]
  #[Assert\Choice(['pending', 'verified', 'closed'], message: 'Please choose a valid status, pending, verified or closed')]
  #[Assert\NotBlank(message: 'Please choose a status')]
  #[ApiProperty(security: "is_granted('ROLE_ADMIN') or is_granted('theater_group_view_status', object)")]
  private ?string $status = "pending";

  #[ORM\Column(length: 255)]
  #[Groups([TheaterGroup::READ, TheaterGroup::WRITE, TheaterGroup::PATCH, User::READ])]
  #[Assert\NotBlank(message: 'Please enter a name')]
  #[Assert\Length(min: 3, max: 255)]
  private ?string $name = null;

  #[ORM\Column(length: 255)]
  #[Groups([TheaterGroup::READ, TheaterGroup::WRITE, TheaterGroup::PATCH])]
  #[Assert\NotBlank(message: 'Please enter a phone number')]
  #[Assert\Regex(pattern: '/^\+((?:9[679]|8[035789]|6[789]|5[90]|42|3[578]|2[1-689])|9[0-58]|8[1246]|6[0-6]|5[1-8]|4[013-9]|3[0-469]|2[70]|7|1)(?:\W*\d){0,13}\d$/', message: 'Invalid phone number')]
  private ?string $phoneNumber = null;

  #[ApiProperty(security: "is_granted('ROLE_ADMIN') or object.getRepresentative() == user")]
  #[Groups([TheaterGroup::READ])]
  public ?string $contentUrl = null;

  #[Vich\UploadableField(mapping: "media_object", fileNameProperty: "receiptPath")]
  #[Assert\NotBlank(message: 'Please upload a receipt', groups: [TheaterGroup::WRITE])]
  #[Assert\File(
    maxSize: "1024k",
    maxSizeMessage: "The file is too large ({{ size }}). Allowed maximum size is {{ limit }}",
    mimeTypes: ["application/pdf", "application/x-pdf"],
    mimeTypesMessage: "Please upload a valid PDF",
  )]
  #[Groups([TheaterGroup::WRITE, TheaterGroup::PATCH])]
  public ?File $receipt = null;

  #[ORM\Column(nullable: true)]
  public ?string $receiptPath = null;

  #[ORM\OneToMany(mappedBy: 'theaterGroup', targetEntity: Event::class)]
  private Collection $events;

  public function __construct()
  {
    $this->events = new ArrayCollection();
  }

  /**
   * @return Collection<int, Event>
   */
  public function getEvents(): Collection
  {
    return $this->events;
  }

  public function addEvent(Event $event): self
  {
    if (!$this->events->contains($event)) {
      $this->events[] = $event;
      $event->setTheaterGroup($this);
    }

    return $this;
  }

  public function removeEvent(Event $event): self
  {
    if ($this->events->removeElement($event)) {
      // set the owning side to null (unless already changed)
      if ($event->getTheaterGroup() === $this) {
        $event->setTheaterGroup(null);
      }
    }
    return $this;
  }


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

  public function getStatus(): ?string
  {
    return $this->status;
  }

  public function setStatus(string $status): self
  {
    $this->status = $status;

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