<?php

namespace App\Service;

use App\Entity\Tag;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class ArticleTagUpdater extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function updateTags(Article $article): void
    {
        // Convertir la chaîne des tags en un tableau
        $tagNames = array_map('trim', explode(',', $article->getTagsAsString()));

        // Maintenant, pour chaque tag de ce tableau :
        foreach ($tagNames as $tagName) {

            // Cherchez le tag par son nom
            $tag = $this->entityManager->getRepository(Tag::class)->findOneByName($tagName);

            // Si le tag n'existe pas, créez-en un nouveau
            if (!$tag) {
                $tag = new Tag();
                $tag->setName($tagName);
                $this->entityManager->persist($tag);
                $this->entityManager->flush(); // Note: vous pouvez opter pour faire un seul flush() après la boucle pour optimiser les performances
            }

            // Ajoutez le tag à l'article si ce n'est pas déjà le cas
            if (!$article->getTags()->contains($tag)) {
                $article->addTag($tag);
            }
        }

        // Maintenant, vérifiez les tags qui pourraient avoir été supprimés
        foreach ($article->getTags() as $existingTag) {
            if (!in_array($existingTag->getName(), $tagNames)) {
                $article->removeTag($existingTag);
            }
        }

        // Persistez les modifications
        $this->entityManager->flush();
    }
}
