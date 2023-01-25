<?php

namespace App\Entity;

use App\Repository\LevelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LevelRepository::class)]
class Level
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $levelNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $bonusPercentage = null;

    #[ORM\Column]
    private ?int $pointsRequired = null;

    #[ORM\OneToMany(mappedBy: 'level', targetEntity: User::class)]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLevelNumber(): ?int
    {
        return $this->levelNumber;
    }

    public function setLevelNumber(int $levelNumber): self
    {
        $this->levelNumber = $levelNumber;

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

    public function getBonusPercentage(): ?float
    {
        return $this->bonusPercentage;
    }

    public function setBonusPercentage(float $bonusPercentage): self
    {
        $this->bonusPercentage = $bonusPercentage;

        return $this;
    }

    public function getPointsRequired(): ?int
    {
        return $this->pointsRequired;
    }

    public function setPointsRequired(int $pointsRequired): self
    {
        $this->pointsRequired = $pointsRequired;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setLevel($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getLevel() === $this) {
                $user->setLevel(null);
            }
        }

        return $this;
    }

    public function isMaxLevel(int $maxLevelNumber): bool
    {
        return $this->getLevelNumber() === $maxLevelNumber;
    }
}
