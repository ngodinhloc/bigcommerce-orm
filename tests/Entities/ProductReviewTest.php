<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\ProductReview;
use Tests\BaseTestCase;

class ProductReviewTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\ProductReview */
    protected $review;

    public function testSettersAndGetters()
    {
        $this->review = new ProductReview();
        $this->review
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

        $this->assertEquals(111, $this->review->getProductId());
        $this->assertEquals(1, $this->review->getId());
        $this->assertEquals('Ken', $this->review->getName());
        $this->assertEquals('2020-09-16', $this->review->getDateModified());
        $this->assertEquals('2020-09-15', $this->review->getDateCreated());
        $this->assertEquals('ken.ngo@bigcommerce.com', $this->review->getEmail());
        $this->assertEquals('I love this product', $this->review->getText());
        $this->assertEquals('2020-09-15', $this->review->getDateReviewed());
        $this->assertEquals('approved', $this->review->getStatus());
        $this->assertEquals('Good product', $this->review->getTitle());
        $this->assertEquals(5, $this->review->getRating());
    }
}