<?php

namespace Bigcommerce\ORM\Mapper;

use Bigcommerce\ORM\EntityManager;

class Converter
{
    /** @var \Bigcommerce\ORM\EntityManager */
    protected $entityManager;

    /**
     * Converter constructor.
     * @param \Bigcommerce\ORM\EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param array|null $array
     * @param string|null $className
     * @param array|null $pathParams
     * @param bool $auto
     * @return \Bigcommerce\ORM\AbstractEntity[]
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function arrayToCollection(
        ?array $array = null,
        ?string $className = null,
        ?array $pathParams = null,
        bool $auto = false
    ) {
        $collections = [];
        if (!empty($array)) {
            $autoloader = new Autoloader($this->entityManager);
            foreach ($array as $item) {
                $object = $this->entityManager->getMapper()->getEntityPatcher()->object($className);
                $relationEntity = $this->entityManager->getMapper()->getEntityPatcher()->patch(
                    $object,
                    $item,
                    $pathParams,
                    false
                );

                if ($auto == false) {
                    $collections[] = $relationEntity;
                } else {
                    if (empty($relationEntity->getMetadata()->getAutoLoadFields())) {
                        $collections[] = $relationEntity;
                    } else {
                        $collections[] = $autoloader->autoLoad($relationEntity, $item, $pathParams);
                    }
                }
            }
        }

        return $collections;
    }
}
