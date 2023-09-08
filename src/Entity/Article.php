<?php

namespace App\Entity;

use App\Entity\Tag;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Model\TimestampedInterface;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article implements TimestampedInterface
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

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToMany(targetEntity: ArticleCategory::class, mappedBy: 'articles')]
    private Collection $articleCategories;

    #[ORM\ManyToMany(targetEntity: Tag::class, mappedBy: 'articles', cascade: ["persist"])]
    private Collection $tags;


    public function __construct()
    {
        $this->articleCategories = new ArrayCollection();
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

    public function __toString(): string
    {
        return $this->title; // Use the article's 'title' attribute as a textual representation
    }

    /**
     * @return Collection<int, ArticleCategory>
     */
    public function getArticleCategories(): Collection
    {
        return $this->articleCategories;
    }

    public function addArticleCategory(ArticleCategory $articleCategory): static
    {
        if (!$this->articleCategories->contains($articleCategory)) {
            $this->articleCategories->add($articleCategory);
            $articleCategory->addArticle($this);
        }

        return $this;
    }

    public function removeArticleCategory(ArticleCategory $articleCategory): static
    {
        if ($this->articleCategories->removeElement($articleCategory)) {
            $articleCategory->removeArticle($this);
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
            $this->tags[] = $tag;
            $tag->addArticle($this);
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
