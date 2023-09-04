<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints as Assert;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticleCrudController extends AbstractCrudController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return Article::class;
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

        yield TextField::new('tagsAsString', 'Tag')
            ->setFormTypeOptions([
                'attr' => ['placeholder' => 'Entrer les tags de l\'article (ex: tag1, tag2, tag3)']
            ]);

        yield DateTimeField::new('created_at', 'Créé le')
            ->hideOnForm();

        yield DateTimeField::new('updated_at', 'Modifié le')
            ->hideOnForm();
    }

    private function updateTags(Article $article)
    {
        $tagNames = explode(',', $article->getTagsAsString());

        foreach ($tagNames as $tagName) {
            $trimmedTagName = trim($tagName);

            // Recherchez le tag existant ou créez-en un nouveau
            $tag = $this->entityManager->getRepository(Tag::class)
                ->findOneByName($trimmedTagName) ?? new Tag();

            $tag->setName($trimmedTagName);

            // Si le tag est nouveau, persistez-le
            if (null === $tag->getId()) {
                $this->entityManager->persist($tag);
            }

            if (!$article->getTags()->contains($tag)) {
                $article->addTag($tag);
            }
        }
        // Important : n'oubliez pas de flush si vous voulez enregistrer immédiatement les modifications.
        // $this->entityManager->flush();
    }

    public static function getSubscribedEvents()
    {
        return [
            AfterEntityPersistedEvent::class => ['handleAfterEntityPersisted'],
            AfterEntityUpdatedEvent::class => ['handleAfterEntityUpdated'],
        ];
    }

    public function handleAfterEntityPersisted(AfterEntityPersistedEvent $event)
    {
        $instance = $event->getEntityInstance();
        if ($instance instanceof Article) {
            $this->updateTags($instance);
            $this->entityManager->flush();
        }
    }

    public function handleAfterEntityUpdated(AfterEntityUpdatedEvent $event)
    {
        $instance = $event->getEntityInstance();
        if ($instance instanceof Article) {
            $this->updateTags($instance);
            $this->entityManager->flush();
        }
    }
}
