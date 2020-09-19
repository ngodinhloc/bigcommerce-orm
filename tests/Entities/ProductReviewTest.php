<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\ProductReview;
use Tests\BaseTestCase;

class ProductReviewTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\ProductReview */
    protected $entity;

    public function testSettersAndGetters()
    {
        $this->entity = new ProductReview();
        $this->entity
            ->setProductId(111)
            ->setId(1)
            ->setName('Ken')
            ->setTitle('Good product')
            ->setDateModified('2020-09-16')
            ->setDateCreated('2020-09-15')
            ->setEmail('ken.ngo@bigcommerce.com')
            ->setText('I love this product')
            ->setDateReviewed('2020-09-15')
            ->setRating(5)
            ->setStatus('approved');

        $this->assertEquals(111, $this->entity->getProductId());
        $this->assertEquals(1, $this->entity->getId());
        $this->assertEquals('Ken', $this->entity->getName());
        $this->assertEquals('2020-09-16', $this->entity->getDateModified());
        $this->assertEquals('2020-09-15', $this->entity->getDateCreated());
        $this->assertEquals('ken.ngo@bigcommerce.com', $this->entity->getEmail());
        $this->assertEquals('I love this product', $this->entity->getText());
        $this->assertEquals('2020-09-15', $this->entity->getDateReviewed());
        $this->assertEquals('approved', $this->entity->getStatus());
        $this->assertEquals('Good product', $this->entity->getTitle());
        $this->assertEquals(5, $this->entity->getRating());
    }
}