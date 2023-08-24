<?php

namespace App\Controller\Admin;

use App\Entity\RecipeIngredient;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RecipeIngredientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RecipeIngredient::class;
    }


    public function configureFields(string $pageName): iterable
    {

        yield IntegerField::new('quantity', 'Quantité');
    }
}
