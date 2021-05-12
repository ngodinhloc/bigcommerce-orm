<?php
declare(strict_types=1);

namespace Tests;

use Bigcommerce\ORM\QueryBuilder;

class QueryBuilderTest extends BaseTestCase
{
    /** @coversDefaultClass \Bigcommerce\ORM\QueryBuilder */
    protected $queryBuilder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->queryBuilder = new QueryBuilder();
    }

    /**
     * @covers \Bigcommerce\ORM\QueryBuilder::select
     * @covers \Bigcommerce\ORM\QueryBuilder::getQueryString
     */
    public function testSelect()
    {
        $this->queryBuilder->select(null);
        $query = $this->queryBuilder->getQueryString();
        $this->assertEquals('', $query);

        $this->queryBuilder->select('id');
        $query = $this->queryBuilder->getQueryString();
        $this->assertEquals('include_fields=id', $query);

        $this->queryBuilder->select(['company', 'name']);
        $query = $this->queryBuilder->getQueryString();
        $this->assertEquals('include_fields=id,company,name', $query);
    }

    /**
     * @covers \Bigcommerce\ORM\QueryBuilder::whereEqual
     * @covers \Bigcommerce\ORM\QueryBuilder::getQueryString
     */
    public function testWhereEqual()
    {
        $this->queryBuilder->whereEqual('id', 1);
        $query = $this->queryBuilder->getQueryString();
        $this->assertEquals('id=1', $query);
    }

    /**
     * @covers \Bigcommerce\ORM\QueryBuilder::whereIn
     * @covers \Bigcommerce\ORM\QueryBuilder::getQueryString
     */
    public function testWhereIn()
    {
        $this->queryBuilder->whereIn('id', [1, 2]);
        $query = $this->queryBuilder->getQueryString();
        $this->assertEquals('id:in=1,2', $query);
    }

    /**
     * @covers \Bigcommerce\ORM\QueryBuilder::whereLike
     * @covers \Bigcommerce\ORM\QueryBuilder::getQueryString
     */
    public function testWhereLike()
    {
        $this->queryBuilder->whereLike('name', 'Ken');
        $query = $this->queryBuilder->getQueryString();
        $this->assertEquals('name:like=Ken', $query);
    }

    /**
     * @covers \Bigcommerce\ORM\QueryBuilder::whereMin
     * @covers \Bigcommerce\ORM\QueryBuilder::getQueryString
     */
    public function testWhereMin()
    {
        $this->queryBuilder->whereMin('id', 1);
        $query = $this->queryBuilder->getQueryString();
        $this->assertEquals('id:min=1', $query);
    }

    /**
     * @covers \Bigcommerce\ORM\QueryBuilder::whereMax
     * @covers \Bigcommerce\ORM\QueryBuilder::getQueryString
     */
    public function testWhereMax()
    {
        $this->queryBuilder->whereMax('id', 1);
        $query = $this->queryBuilder->getQueryString();
        $this->assertEquals('id:max=1', $query);
    }

    /**
     * @covers \Bigcommerce\ORM\QueryBuilder::include
     * @covers \Bigcommerce\ORM\QueryBuilder::getQueryString
     */
    public function testInclude()
    {
        $this->queryBuilder->include('addresses');
        $query = $this->queryBuilder->getQueryString();
        $this->assertEquals('include=addresses', $query);

        $this->queryBuilder->include(['primary_address', 'variants']);
        $query = $this->queryBuilder->getQueryString();
        $this->assertEquals('include=addresses,primary_address,variants', $query);

        $this->queryBuilder->include(null);
        $query = $this->queryBuilder->getQueryString();
        $this->assertEquals('include=addresses,primary_address,variants', $query);
    }

    /**
     * @covers \Bigcommerce\ORM\QueryBuilder::page
     * @covers \Bigcommerce\ORM\QueryBuilder::getQueryString
     */
    public function testPage()
    {
        $this->queryBuilder->page(1);
        $query = $this->queryBuilder->getQueryString();
        $this->assertEquals('page=1', $query);
    }

    /**
     * @covers \Bigcommerce\ORM\QueryBuilder::limit
     * @covers \Bigcommerce\ORM\QueryBuilder::getQueryString
     */
    public function testLimit()
    {
        $this->queryBuilder->limit(1);
        $query = $this->queryBuilder->getQueryString();
        $this->assertEquals('limit=1', $query);
    }

    /**
     * @covers \Bigcommerce\ORM\QueryBuilder::order
     * @covers \Bigcommerce\ORM\QueryBuilder::getQueryString
     */
    public function testOrder()
    {
        $this->queryBuilder->order(['name' => 'asc']);
        $query = $this->queryBuilder->getQueryString();
        $this->assertEquals('sort=name:asc', $query);
    }

    /**
     * @covers \Bigcommerce\ORM\QueryBuilder::orderBy
     * @covers \Bigcommerce\ORM\QueryBuilder::getQueryString
     */
    public function testOrderBy()
    {
        $this->queryBuilder->orderBy('name', 'asc');
        $query = $this->queryBuilder->getQueryString();
        $this->assertEquals('sort=name:asc', $query);
    }
}
