<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\RateRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    denormalizationContext: ['groups' => ['rate_write']],
    normalizationContext: ['groups' => ['rate_read']]
)]
#[Get(
    normalizationContext: ['groups' => ['rate_get']]
)]
#[GetCollection(
    normalizationContext: ['groups' => ['rate_cget']]
)]
#[Post]
#[Patch]
#[Delete]
#[ORM\Entity(repositoryClass: RateRepository::class)]
class Rate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[Groups(['joke_get', 'rate_get', 'rate_write', 'rate_cget'])]
    #[ORM\Column]
    private ?int $star = null;

    #[Groups(['rate_get'])]
    #[ORM\ManyToOne(inversedBy: 'rates')]
    private ?Joke $joke = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStar(): ?int
    {
        return $this->star;
    }

    public function setStar(int $star): self
    {
        $this->star = $star;

        return $this;
    }

    public function getJoke(): ?Joke
    {
        return $this->joke;
    }

    public function setJoke(?Joke $joke): self
    {
        $this->joke = $joke;

        return $this;
    }
}
