<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Repository\TransactionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ApiResource(operations: [
    new Get(),
    new Post(
        name: 'post_transaction', 
        controller: CreateBookPublication::class
    )
])]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column]
    #[NotBlank(message: 'Merci de renseigner un montant')]
    #[GreaterThan(value: 0, message: 'Le montant doit être supérieur à 0')]
    private ?float $amount = null;

    #[ORM\Column]
    private ?float $bonusAmount= null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

        public function setBonusAmount(float $bonusAmount): self
    {
        $this->bonusAmount = $bonusAmount;
        return $this;
    }

    public function getBonusAmount(): ?float
    {
        return $this->bonusAmount;
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


    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    // /**
    //  * @ORM\PrePersist
    //  * @Security("is_granted('ROLE_USER')")
    //  * 
    //  * This method updates the user's points, level, and credit all at once
    //  */
    // public function handleTransaction()
    // {
    //     // Retrieve the user's current level and points
    //     $user = $this->getUser();
    //     $level = $user->getLevel();
    //     $points = $user->getPoints();

    //     // Calculate the new points for the user
    //     $newPoints = $points + ($this->getAmount() * 1); // 1€ = 1 point

    //     // Update the user's points
    //     $user->setPoints($newPoints);

    //     //update credit
    //      $this->getUser()->addCredit($this->getAmount());

    //     // Retrieve the bonus percentage for the user's current level
    //     $bonusPercentage = $level->getBonusPercentage();

    //     // Calculate the bonus for the transaction
    //     $bonus = $this->getAmount() * ($bonusPercentage / 100);
    //     $this->setBonusAmount($bonus);

    //     // Add the bonus to the transaction amount
    //     $this->setAmount($this->getAmount() + $bonus);

    //     // Update the user's level if the user's points exceeds the required points for the next level
    //     $user->updateLevel();
    // }
}
