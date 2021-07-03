<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Events;

use Bigcommerce\ORM\AbstractEntity;
use Symfony\Component\EventDispatcher\Event;

class EntityManagerEvent extends Event
{
    const ENTITY_CREATED = 'Entity.Created';
    const ENTITY_UPDATED = 'Entity.Updated';
    const ENTITY_DELETED = 'Entity.Deleted';

    /** @var string */
    protected $name;

    /** @var \Bigcommerce\ORM\AbstractEntity */
    protected $entity;

    /**
     * EntityManagerEvent constructor.
     * @param string|null $name
     * @param \Bigcommerce\ORM\AbstractEntity|null $entity
     */
    public function __construct(?string $name = null, ?AbstractEntity $entity = null)
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
     * @param string|null $name
     * @return \Bigcommerce\ORM\Events\EntityManagerEvent
     */
    public function setName($name): EntityManagerEvent
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return \Bigcommerce\ORM\AbstractEntity
     */
    public function getEntity(): \Bigcommerce\ORM\AbstractEntity
    {
        return $this->entity;
    }

    /**
     * @param \Bigcommerce\ORM\AbstractEntity|null $entity
     * @return \Bigcommerce\ORM\Events\EntityManagerEvent
     */
    public function setEntity(?AbstractEntity $entity): EntityManagerEvent
    {
        $this->entity = $entity;

        return $this;
    }
}
