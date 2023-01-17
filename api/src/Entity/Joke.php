<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\JokeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    denormalizationContext: ['groups' => ['joke_write']],
    normalizationContext: ['groups' => ['joke_read']]
)]
#[Get(
    normalizationContext: ['groups' => ['joke_get']]
)]
#[GetCollection(
    normalizationContext: ['groups' => ['joke_cget']]
)]
#[Post]
#[Patch]
#[Delete]
#[ORM\Entity(repositoryClass: JokeRepository::class)]
class Joke
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[Groups(['joke_get', 'category_get', 'joke_write', 'category_get'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[Groups(['joke_get', 'joke_write', 'category_get'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $answer = null;

    #[Groups(['joke_get'])]
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'jokes')]
    private Collection $categories;

    #[Groups(['joke_get'])]
    #[ORM\OneToMany(mappedBy: 'joke', targetEntity: Comment::class)]
    private Collection $comments;

    #[Groups(['joke_get'])]
    #[ORM\OneToMany(mappedBy: 'joke', targetEntity: Rate::class)]
    private Collection $rates;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->rates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(?string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setJoke($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getJoke() === $this) {
                $comment->setJoke(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rate>
     */
    public function getRates(): Collection
    {
        return $this->rates;
    }

    public function addRate(Rate $rate): self
    {
        if (!$this->rates->contains($rate)) {
            $this->rates[] = $rate;
            $rate->setJoke($this);
        }

        return $this;
    }

    public function removeRate(Rate $rate): self
    {
        if ($this->rates->removeElement($rate)) {
            // set the owning side to null (unless already changed)
            if ($rate->getJoke() === $this) {
                $rate->setJoke(null);
            }
        }

        return $this;
    }
}
