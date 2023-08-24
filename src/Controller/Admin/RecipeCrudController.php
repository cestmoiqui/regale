<?php

namespace App\Controller\Admin;

use App\Entity\Recipe;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RecipeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recipe::class;
    }

    public function configureFields(string $pageName): iterable
    {


        yield TextField::new('title', 'Titre');

        yield SlugField::new('slug')
            ->setTargetFieldName('title');

        yield TextEditorField::new('content', 'Contenu');

        yield TextField::new('featured_text', 'Texte mis en avant');

        yield TimeField::new('cook_time', 'Temps de préparation')->setFormat('H:i:s');

        yield AssociationField::new('difficulty', 'Difficulté');

        yield IntegerField::new('yield_quantity', 'Portions');

        yield AssociationField::new('categories', 'Catégorie');

        yield DateTimeField::new('created_at', 'Créé le')
            ->hideOnForm();

        yield DateTimeField::new('updated_at', 'Modifié le')
            ->hideOnForm();
    }
}
