<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Service\ArticleTagUpdater;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints as Assert;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticleCrudController extends AbstractCrudController
{
    private $tagUpdater;

    public function __construct(ArticleTagUpdater $tagUpdater)
    {
        $this->tagUpdater = $tagUpdater;
    }

    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entity): void
    {
        parent::updateEntity($entityManager, $entity);
        if ($entity instanceof Article) {
            $this->tagUpdater->updateTags($entity);
            dump($entity);
        }
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Article')
            ->setEntityLabelInPlural('Articles')
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des %entity_label_plural%')
            ->setPageTitle(Crud::PAGE_NEW, 'Créer un nouvel %entity_label_singular%')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier l\'%entity_label_singular%')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Détails de l\'%entity_label_singular%');
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title', 'Titre')
            ->setFormTypeOptions([
                'attr' => ['placeholder' => 'Entrer le titre de l\'article']
            ]);

        yield SlugField::new('slug')
            ->setTargetFieldName('title')
            ->setFormTypeOption('constraints', [
                new Assert\Regex([
                    'pattern' => '/^[a-zA-Z0-9\-_]+$/',
                    'message' => 'Seuls les caractères alphanumériques, tirets et underscores sont autorisés dans ce champ.'
                ])
            ]);

        yield TextEditorField::new('content', 'Contenu')
            ->setFormTypeOptions([
                'attr' => ['placeholder' => 'Entrer le contenu de l\'article']
            ]);

        yield TextField::new('featured_text', 'Texte mis en avant')
            ->setFormTypeOptions([
                'attr' => ['placeholder' => 'Entrer le texte à mettre en avant de l\'article']
            ]);

        yield AssociationField::new('articleCategories', 'Catégorie')
            ->setFormTypeOptions([
                'multiple' => true,
                'attr' => ['placeholder' => 'Sélectionner une catégorie']
            ])
            ->setFormTypeOption('by_reference', false); // Ensures that changes to the collection of linked entities are correctly taken into account by Doctrine

        yield TextField::new('tagsAsString', 'Tag', TextType::class, [
            'mapped' => false,
        ])
            ->setFormTypeOptions([
                'attr' => ['placeholder' => 'Entrer les tags de l\'article (ex: tag1, tag2, tag3)']
            ]);

        yield DateTimeField::new('created_at', 'Créé le')
            ->hideOnForm();

        yield DateTimeField::new('updated_at', 'Modifié le')
            ->hideOnForm();
    }
}
