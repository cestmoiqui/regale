<?php

namespace App\Controller\Admin;

use App\Entity\MeasurementUnits;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MeasurementUnitsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MeasurementUnits::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
