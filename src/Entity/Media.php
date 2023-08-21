<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $altText = null;

    #[ORM\Column(length: 255)]
    private ?string $filename = null;

    #[ORM\Column(length: 100)]
    private ?string $type = null;

    #[ORM\Column]
    private ?int $mediaOwnerId = null;

    #[ORM\Column(length: 100)]
    private ?string $mediaOwnerType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAltText(): ?string
    {
        return $this->altText;
    }

    public function setAltText(?string $altText): static
    {
        $this->altText = $altText;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): static
    {
        $this->filename = $filename;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getMediaOwnerId(): ?int
    {
        return $this->mediaOwnerId;
    }

    public function setMediaOwnerId(int $mediaOwnerId): static
    {
        $this->mediaOwnerId = $mediaOwnerId;

        return $this;
    }

    public function getMediaOwnerType(): ?string
    {
        return $this->mediaOwnerType;
    }

    public function setMediaOwnerType(string $mediaOwnerType): static
    {
        $this->mediaOwnerType = $mediaOwnerType;

        return $this;
    }
}
