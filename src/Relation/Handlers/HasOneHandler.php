<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Relation\Handlers;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Relation\AbstractHandler;
use Bigcommerce\ORM\Relation\RelationHandlerInterface;
use Bigcommerce\ORM\Relation\RelationInterface;

/**
 * Class HasOneHandler
 * @package Bigcommerce\ORM\Relation\Handlers
 */
class HasOneHandler extends AbstractHandler implements RelationHandlerInterface
{
    /**
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @param \ReflectionProperty $property
     * @param \Bigcommerce\ORM\Relation\RelationInterface $annotation
     * @param array $data
     * @param array|null $pathParams
     * @return void
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     * @throws \Bigcommerce\ORM\Exceptions\ResultException
     * @throws \Exception
     */
    public function handle(AbstractEntity $entity, \ReflectionProperty $property, RelationInterface $annotation, array $data, array $pathParams = null)
    {
        /* @var \Bigcommerce\ORM\Annotations\HasOne $annotation */
        if (!isset($annotation->field) || !isset($data[$annotation->field]) || empty($data[$annotation->field])) {
            return;
        }

        $value = $this->getOneRelationValue($data[$annotation->field]);

        if (!is_array($pathParams)) {
            $pathParams = [$annotation->targetField => $entity->getId()];
        } else {
            $pathParams = array_merge($pathParams, [$annotation->targetField => $entity->getId()]);
        }

        $find = $this->entityManager->find($annotation->targetClass, $value, $pathParams, $annotation->auto);
        $mapper = $this->entityManager->getMapper();
        $mapper->setPropertyValue($entity, $property, $find);
    }
}
