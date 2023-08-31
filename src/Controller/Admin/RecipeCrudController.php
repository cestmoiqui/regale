<?php

namespace App\Controller\Admin;

use App\Entity\Recipe;
use App\Form\StepsType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RecipeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recipe::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Recette')
            ->setEntityLabelInPlural('Recettes')
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des %entity_label_plural%')
            ->setPageTitle(Crud::PAGE_NEW, 'Créer une nouvelle %entity_label_singular%')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier la %entity_label_singular%')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Détails de la %entity_label_singular%');
    }

    public function configureFields(string $pageName): iterable
    {



        yield TextField::new('title', 'Titre')
            ->setFormTypeOptions([
                'attr' => ['placeholder' => 'Entrer le titre de la recette']
            ]);

        yield SlugField::new('slug')
            ->setTargetFieldName('title');

        yield TextEditorField::new('content', 'Contenu')
            ->setFormTypeOptions([
                'attr' => ['placeholder' => 'Entrer le contenu de la recette']
            ]);

        yield TextField::new('featured_text', 'Texte mis en avant')
            ->setFormTypeOptions([
                'attr' => ['placeholder' => 'Entrer le texte à mettre en avant de la recette']
            ]);

        yield TimeField::new('cook_time', 'Temps de préparation')
            ->formatValue(function ($value) {
                if ($value instanceof \DateTimeInterface) {
                    return $value->format('i');
                }
                return $value;
            }); // This method takes a callback function as argument, which receives the field value as parameter.

        yield AssociationField::new('difficulty', 'Difficulté')
            ->setFormTypeOptions([
                'attr' => ['placeholder' => 'Sélectionner un niveau de difficulté']
            ]);

        yield IntegerField::new('yield_quantity', 'Portion')
            ->setFormTypeOptions([
                'attr' => [
                    'placeholder' => 'Entrer les portions de la recette',
                    'min' => 1, // prevent selection of negative values
                    'required' => true,
                ]
            ]);

        if (in_array($pageName, [Crud::PAGE_EDIT, Crud::PAGE_NEW])) {
            yield CollectionField::new('steps', 'Étape')
                ->setEntryType(StepsType::class)
                ->allowAdd()
                ->allowDelete();
        } // display this field only when the user modifies or creates a recipe

        yield AssociationField::new('recipeCategories', 'Catégorie')
            ->setFormTypeOptions([
                'multiple' => true,
                'attr' => ['placeholder' => 'Sélectionner une catégorie']
            ])
            ->setFormTypeOption('by_reference', false); // Ensures that changes to the collection of linked entities are correctly taken into account by Doctrine

        yield DateTimeField::new('created_at', 'Créé le')
            ->hideOnForm();

        yield DateTimeField::new('updated_at', 'Modifié le')
            ->hideOnForm();
    }
}
