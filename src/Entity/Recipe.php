<?php

namespace App\Entity;

use App\Entity\Tag;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Model\TimestampedInterface;
use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe implements TimestampedInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $featuredText = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $cookTime = null;

    #[ORM\Column]
    private ?int $yieldQuantity = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne]
    private ?Difficulties $difficulty = null;

    #[ORM\OneToMany(mappedBy: 'recipes', targetEntity: RecipeIngredient::class, orphanRemoval: true)]
    private Collection $recipeIngredients;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: Steps::class, orphanRemoval: true)]
    private Collection $steps;

    #[ORM\ManyToMany(targetEntity: RecipeCategory::class, mappedBy: 'recipes')]
    private Collection $recipeCategories;

    #[ORM\ManyToMany(targetEntity: Tag::class, mappedBy: 'recipes', cascade: ["persist"])]
    private Collection $tags;

    public function __construct()
    {
        $this->recipeIngredients = new ArrayCollection();
        $this->steps = new ArrayCollection();
        $this->recipeCategories = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getFeaturedText(): ?string
    {
        return $this->featuredText;
    }

    public function setFeaturedText(?string $featuredText): static
    {
        $this->featuredText = $featuredText;

        return $this;
    }

    public function getCookTime(): ?\DateTimeInterface
    {
        return $this->cookTime;
    }

    public function setCookTime(\DateTimeInterface $cookTime): static
    {
        $this->cookTime = $cookTime;

        return $this;
    }

    public function getYieldQuantity(): ?int
    {
        return $this->yieldQuantity;
    }

    public function setYieldQuantity(int $yieldQuantity): static
    {
        $this->yieldQuantity = $yieldQuantity;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDifficulty(): ?Difficulties
    {
        return $this->difficulty;
    }

    public function setDifficulty(?Difficulties $difficulty): static
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title; // Use the recipe's 'title' attribute as a textual representation
    }

    /**
     * @return Collection<int, RecipeIngredient>
     */
    public function getRecipeIngredients(): Collection
    {
        return $this->recipeIngredients;
    }

    public function addRecipeIngredient(RecipeIngredient $recipeIngredient): static
    {
        if (!$this->recipeIngredients->contains($recipeIngredient)) {
            $this->recipeIngredients->add($recipeIngredient);
            $recipeIngredient->setRecipes($this);
        }

        return $this;
    }

    public function removeRecipeIngredient(RecipeIngredient $recipeIngredient): static
    {
        if ($this->recipeIngredients->removeElement($recipeIngredient)) {
            // set the owning side to null (unless already changed)
            if ($recipeIngredient->getRecipes() === $this) {
                $recipeIngredient->setRecipes(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Steps>
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function addStep(Steps $step): static
    {
        if (!$this->steps->contains($step)) {
            $this->steps->add($step);
            $step->setRecipe($this);
        }

        return $this;
    }

    public function removeStep(Steps $step): static
    {
        if ($this->steps->removeElement($step)) {
            // set the owning side to null (unless already changed)
            if ($step->getRecipe() === $this) {
                $step->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RecipeCategory>
     */
    public function getRecipeCategories(): Collection
    {
        return $this->recipeCategories;
    }

    public function addRecipeCategory(RecipeCategory $recipeCategory): static
    {
        if (!$this->recipeCategories->contains($recipeCategory)) {
            $this->recipeCategories->add($recipeCategory);
            $recipeCategory->addRecipe($this);
        }

        return $this;
    }

    public function removeRecipeCategory(RecipeCategory $recipeCategory): static
    {
        if ($this->recipeCategories->removeElement($recipeCategory)) {
            $recipeCategory->removeRecipe($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
            $tag->addRecipe($this);
        }
        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }
        return $this;
    }

    private $tagsAsString;

    public function getTagsAsString(): ?string
    {
        return implode(', ', $this->tags->map(function ($tag) {
            return $tag->getName();
        })->toArray());
    }

    public function setTagsAsString(string $tagsAsString): self
    {
        $tagNames = array_map('trim', explode(',', $tagsAsString));

        $this->tags->clear(); // Remove previous tags
        foreach ($tagNames as $tagName) {
            $tag = new Tag(); // You may want to fetch existing tags from DB instead of always creating new ones
            $tag->setName($tagName);
            $this->addTag($tag);
        }

        return $this;
    }
}
