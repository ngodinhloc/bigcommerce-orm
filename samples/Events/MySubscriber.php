<?php
declare(strict_types=1);

namespace Samples\Events;

use Bigcommerce\ORM\Events\EntityManagerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class MySubscriber implements EventSubscriberInterface
{
    /**
     * @return array|string[]
     */
    public static function getSubscribedEvents()
    {
        return [
            EntityManagerEvent::ENTITY_UPDATED => 'entityUpdated',
            EntityManagerEvent::ENTITY_CREATED => 'entityCreated'
        ];
    }

    /**
     * @param \Bigcommerce\ORM\Events\EntityManagerEvent $event
     */
    public function entityUpdated(EntityManagerEvent $event)
    {
        $entity = $event->getEntity();
        $name = $event->getName();
        echo $name;
    }

    /**
     * @param \Bigcommerce\ORM\Events\EntityManagerEvent $event
     */
    public function entityCreated(EntityManagerEvent $event)
    {
        $entity = $event->getEntity();
        $name = $event->getName();
        echo $name;
    }

}