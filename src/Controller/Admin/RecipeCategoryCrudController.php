<?php

namespace App\Controller\Admin;

use App\Entity\RecipeCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Validator\Constraints as Assert;

class RecipeCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RecipeCategory::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Catégorie')
            ->setEntityLabelInPlural('Catégories')
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des %entity_label_plural% de Recette')
            ->setPageTitle(Crud::PAGE_NEW, 'Créer une nouvelle %entity_label_singular% de Recette')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier la %entity_label_singular% de Recette')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Détails de la %entity_label_singular% de Recette');
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Nom de la catégorie');
        yield SlugField::new('slug')
            ->setTargetFieldName('name')
            ->setFormTypeOption('constraints', [
                new Assert\Regex([
                    'pattern' => '/^[a-zA-Z0-9\-_]+$/',
                    'message' => 'Seuls les caractères alphanumériques, tirets et underscores sont autorisés dans ce champ.'
                ])
            ]);
        yield ColorField::new('color', 'Sélectionner une couleur');
    }
}
