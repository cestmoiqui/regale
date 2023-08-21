<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column]
    private ?int $commentableId = null;

    #[ORM\Column(length: 100)]
    private ?string $commentableType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

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

    public function getCommentableId(): ?int
    {
        return $this->commentableId;
    }

    public function setCommentableId(int $commentableId): static
    {
        $this->commentableId = $commentableId;

        return $this;
    }

    public function getCommentableType(): ?string
    {
        return $this->commentableType;
    }

    public function setCommentableType(string $commentableType): static
    {
        $this->commentableType = $commentableType;

        return $this;
    }
}
