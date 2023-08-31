<?php

namespace App\Controller\Admin;

use App\Entity\ArticleCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticleCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ArticleCategory::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Catégorie')
            ->setEntityLabelInPlural('Catégories')
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des %entity_label_plural d\'Article%')
            ->setPageTitle(Crud::PAGE_NEW, 'Créer une nouvelle %entity_label_singular% d\'Article')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier la %entity_label_singular% d\'Article')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Détails de la %entity_label_singular d\'Article%');
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Nom de la catégorie');
        yield SlugField::new('slug')->setTargetFieldName('name');
        yield ColorField::new('color', 'Sélectionner une couleur');
    }
}
