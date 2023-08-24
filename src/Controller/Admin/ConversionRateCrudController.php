<?php

namespace App\Controller\Admin;

use App\Entity\ConversionRate;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ConversionRateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ConversionRate::class;
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
