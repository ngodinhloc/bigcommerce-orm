<?php

namespace Bigcommerce\ORM\Mapper;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Exceptions\EntityException;

class EntityValidator
{
    /**
     * @param int|string|null $id
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function checkId($id = null)
    {
        if (empty($id)) {
            throw new EntityException(EntityException::ERROR_ID_IS_NOT_PROVIDED);
        }
    }

    /**
     * @param string|null $className
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function checkClass(?string $className)
    {
        if (empty($className)) {
            throw new EntityException(EntityException::ERROR_EMPTY_CLASS_NAME);
        }
    }

    /**
     * @param \Bigcommerce\ORM\AbstractEntity $entity
     * @throws \Bigcommerce\ORM\Exceptions\EntityException
     */
    public function checkEntity(AbstractEntity $entity)
    {
        if (!$entity instanceof AbstractEntity) {
            throw new EntityException(EntityException::ERROR_NOT_ENTITY_INSTANCE);
        }
    }

    /**
     * @param array|null $data
     * @return bool
     */
    public function checkFieldValues(?array $data = null)
    {
        if (empty($data)) {
            return false;
        }

        foreach ($data as $field => $value) {
            if ($value !== null) {
                return true;
            }
        }

        return false;
    }
}
