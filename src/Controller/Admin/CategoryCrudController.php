<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Catégorie')
            ->setEntityLabelInPlural('Catégories')
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des %entity_label_plural%')
            ->setPageTitle(Crud::PAGE_NEW, 'Créer une nouvelle %entity_label_singular%')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier la %entity_label_singular%')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Détails de la %entity_label_singular%');
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Nom')
            ->setFormTypeOptions([
                'attr' => ['placeholder' => 'Entrer le nom de la catégorie']
            ]);
        yield SlugField::new('slug')->setTargetFieldName('name');
        yield ColorField::new('color', 'Sélectionner une couleur');
    }

    public function configureQuery(AdminContext $context, QueryBuilder $queryBuilder): void
    {
        if ($context->getRequest()->query->get('categoryType') === 'recipe') {
            // Modify the query for recipe categories
            $queryBuilder
                ->andWhere('entity.categoryType = :recipeType')
                // Condition in SQL query to filter results
                ->setParameter('recipeType', 'recipe');
        } elseif ($context->getRequest()->query->get('categoryType') === 'article') {
            // Modify query for article categories
            $queryBuilder
                ->andWhere('entity.categoryType = :articleType')
                // Condition in SQL query to filter results
                ->setParameter('articleType', 'article');
        }
    }
}
