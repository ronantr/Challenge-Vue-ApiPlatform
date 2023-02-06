<?php

namespace App\Entity;

use App\Repository\TheaterGroupRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TheaterGroupRepository::class)]
class TheaterGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'theaterGroup', cascade: ['persist', 'remove'])]
    private ?User $representative = null;

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
}
