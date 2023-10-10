<?php

namespace App\Service;

use App\Entity\ConversionRate;
use App\Entity\MeasurementUnits;
use App\Exception\ConversionException;
use Doctrine\ORM\EntityManagerInterface;

class ConversionService
{
    private $entityManager; // Suppose que vous injectez l'EntityManager de Doctrine

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function convert(float $value, MeasurementUnits $from, MeasurementUnits $to)
    {
    }
}
