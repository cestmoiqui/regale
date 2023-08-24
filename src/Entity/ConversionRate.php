<?php

namespace App\Entity;

use App\Repository\ConversionRateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConversionRateRepository::class)]
class ConversionRate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?MeasurementUnits $fromUnit = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?MeasurementUnits $toUnit = null;

    #[ORM\Column]
    private ?int $conversionFactor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromUnit(): ?MeasurementUnits
    {
        return $this->fromUnit;
    }

    public function setFromUnit(?MeasurementUnits $from_unit): static
    {
        $this->fromUnit = $from_unit;

        return $this;
    }

    public function getToUnit(): ?MeasurementUnits
    {
        return $this->toUnit;
    }

    public function setToUnit(?MeasurementUnits $to_unit): static
    {
        $this->toUnit = $to_unit;

        return $this;
    }

    public function getConversionFactor(): ?int
    {
        return $this->conversionFactor;
    }

    public function setConversionFactor(int $conversion_factor): static
    {
        $this->conversionFactor = $conversion_factor;

        return $this;
    }
}
