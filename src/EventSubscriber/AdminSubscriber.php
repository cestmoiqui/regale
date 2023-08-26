<?php

namespace App\EventSubscriber;

use App\Model\TimestampedInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;

class AdminSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setEntityCreatedAt'],
            BeforeEntityUpdatedEvent::class => ['setEntityUpdateddAt']
        ];
    } // This subscriber listens to two types of events: BeforeEntityPersistedEvent and BeforeEntityUpdatedEvent


    public function setEntityCreatedAt(BeforeEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if (!$entity instanceof TimestampedInterface) {
            return;
        }

        $entity->setCreatedAt(new \DateTime());
    }

    public function setEntityUpdateddAt(BeforeEntityUpdatedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if (!$entity instanceof TimestampedInterface) {
            return;
        }

        $entity->setUpdatedAt(new \DateTime());
    }
} // The BeforeEntityPersistedEvent is triggered just before the entity is actually persisted using Doctrine. If the entity implements the TimestampedInterface interface, the EventSubscriber retrieves this instance of the entity and automatically initializes the createdAt and/or updatedAt fields with the current date and time.
