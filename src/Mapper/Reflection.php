<?php

namespace Bigcommerce\ORM\Mapper;

use Bigcommerce\ORM\AbstractEntity;
use Bigcommerce\ORM\Exceptions\MapperException;
use Doctrine\Common\Annotations\AnnotationRegistry;
use ReflectionClass;

class Reflection
{
    /**
     * @param \Bigcommerce\ORM\AbstractEntity|null $entity
     * @return \ReflectionClass
     * @throws \Bigcommerce\ORM\Exceptions\MapperException
     */
    public function reflect(AbstractEntity $entity = null)
    {
        try {
            $reflectionClass = new ReflectionClass(get_class($entity));
            $this->register();
        } catch (\Throwable $exception) {
            throw new MapperException(MapperException::ERROR_FAILED_TO_CREATE_REFLECT_CLASS . $exception->getMessage());
        }

        return $reflectionClass;
    }

    /**
     * Register annotation classes
     *
     * @return void
     */
    private function register()
    {
        if (class_exists(AnnotationRegistry::class)) {
            AnnotationRegistry::registerLoader('class_exists');
        }
    }
}
