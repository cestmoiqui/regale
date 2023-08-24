<?php

namespace App\Entity;

use App\Repository\RecipeIngredientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeIngredientRepository::class)]
class RecipeIngredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'recipeIngredients')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recipe $recipes = null;

    #[ORM\ManyToOne(inversedBy: 'recipeIngredients')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ingredients $ingredients = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getRecipes(): ?Recipe
    {
        return $this->recipes;
    }

    public function setRecipes(?Recipe $recipes): static
    {
        $this->recipes = $recipes;

        return $this;
    }

    public function getIngredients(): ?Ingredients
    {
        return $this->ingredients;
    }

    public function setIngredients(?Ingredients $ingredients): static
    {
        $this->ingredients = $ingredients;

        return $this;
    }
}
