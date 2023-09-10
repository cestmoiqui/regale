<?php

namespace App\EventSubscriber;

use App\Entity\Tag;
use App\Entity\Recipe;
use Psr\Log\LoggerInterface;
use App\Service\RecipeTagUpdater;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;

class RecipeSubscriber implements EventSubscriberInterface
{
    private $entityManager;
    private $tagUpdater;

    public function __construct(EntityManagerInterface $entityManager, RecipeTagUpdater $tagUpdater)
    {
        $this->entityManager = $entityManager;
        $this->tagUpdater = $tagUpdater;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AfterEntityPersistedEvent::class => ['handleAfterEntityPersisted'],
            AfterEntityUpdatedEvent::class => ['handleAfterEntityUpdated'],
        ];
    }

    public function handleAfterEntityPersisted(AfterEntityPersistedEvent $event)
    {
        $this->handleTagUpdates($event);
    }

    public function handleAfterEntityUpdated(AfterEntityUpdatedEvent $event)
    {
        $this->handleTagUpdates($event);
    }

    private function handleTagUpdates($event)
    {
        $instance = $event->getEntityInstance();
        if ($instance instanceof Recipe) {
            $this->tagUpdater->updateTags($instance); // Utilisez le service ici
            $this->entityManager->flush();
        }
    }
}
