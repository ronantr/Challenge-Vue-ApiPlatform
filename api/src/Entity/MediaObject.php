<?php
// api/src/Entity/MediaObject.php
namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\CreateMediaObjectController;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Entity]
#[ApiResource(
normalizationContext: ['groups' => ['media_object:read']],
types: ['https://schema.org/MediaObject'],
operations: [
new Get(),
new GetCollection(),
new Post(
controller: CreateMediaObjectController::class,
deserialize: false,
validationContext: ['groups' => ['Default', 'media_object_create']],
openapiContext: [
'requestBody' => [
'content' => [
'multipart/form-data' => [
'schema' => [
'type' => 'object',
'properties' => [
'file' => [
'type' => 'string',
'format' => 'binary'
]
]
]
]
]
]
]
)
]
)]
class MediaObject
{
  #[ORM\Id, ORM\Column, ORM\GeneratedValue]
  private ?int $id = null;

  #[ApiProperty(types: ['https://schema.org/contentUrl'])]
  #[Groups(['media_object:read'])]
  public ?string $contentUrl = null;

  #[Vich\UploadableField(mapping: "media_object", fileNameProperty: "filePath")]
  #[Assert\NotNull(groups: ['media_object_create'])]
  #[Assert\File(
        maxSize: '1024k',
        maxSizeMessage: 'The file is too large ({{ size }} {{ suffix }}). Allowed maximum size is {{ limit }} {{ suffix }}.',
        mimeTypes: ['application/pdf', 'application/x-pdf'],
        mimeTypesMessage: 'Please upload a valid PDF',
    )]
  public ?File $file = null;

  #[ORM\Column(nullable: true)]
  public ?string $filePath = null;

  #[ORM\ManyToOne(inversedBy: 'mediaObjects')]
  #[ORM\JoinColumn(nullable: false)]
  private ?User $owner = null;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getOwner(): ?User
  {
      return $this->owner;
  }

  public function setOwner(?User $owner): self
  {
      $this->owner = $owner;

      return $this;
  }
}