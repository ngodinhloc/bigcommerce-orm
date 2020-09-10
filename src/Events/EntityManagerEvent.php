<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Events;

use Bigcommerce\ORM\Entity;
use Symfony\Contracts\EventDispatcher\Event;

class EntityManagerEvent extends Event
{
    const ENTITY_CREATED = 'Entity.Created';
    const ENTITY_UPDATED = 'Entity.Updated';

    /** @var string */
    protected $name;

    /** @var \Bigcommerce\ORM\Entity */
    protected $entity;

    /**
     * EntityManagerEvent constructor.
     * @param string|null $name
     * @param \Bigcommerce\ORM\Entity|null $entity
     */
    public function __construct(string $name = null, Entity $entity = null)
    {
        $this->name = $name;
        $this->entity = $entity;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return \Bigcommerce\ORM\Events\EntityManagerEvent
     */
    public function setName(string $name): EntityManagerEvent
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\Entity
     */
    public function getEntity(): \Bigcommerce\ORM\Entity
    {
        return $this->entity;
    }

    /**
     * @param \Bigcommerce\ORM\Entity $entity
     * @return \Bigcommerce\ORM\Events\EntityManagerEvent
     */
    public function setEntity(\Bigcommerce\ORM\Entity $entity): EntityManagerEvent
    {
        $this->entity = $entity;
        return $this;
    }
}