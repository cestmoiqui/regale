<?php

namespace App\Controller\Admin;

use App\Entity\RecipeIngredient;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RecipeIngredientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RecipeIngredient::class;
    }


    // public function configureFields(string $pageName): iterable
    // {

    //     yield AssociationField::new('recipes', 'Recette');
    //     yield NumberField::new('quantity', 'Quantité');
    //     yield AssociationField::new('unit', 'Unité de mesure')->setRequired(false);
    //     yield AssociationField::new('ingredients', 'Ingrédient');
    // }
}
