<?php
declare(strict_types=1);

namespace Bigcommerce\ORM;

/**
 * Class QueryBuilder
 * @package Bigcommerce\ORM
 */
class QueryBuilder
{
    protected $query = [];
    protected $fields = [];
    protected $includes = [];

    /**
     * @param string|array $fields
     * @return $this
     */
    public function select($fields)
    {
        if (is_string($fields) && !in_array($fields, $this->fields)) {
            array_push($this->fields, $fields);
            return $this;
        }

        if (is_array($fields)) {
            foreach ($fields as $field) {
                if (!in_array($field, $this->fields)) {
                    array_push($this->fields, $field);
                }
            }
            return $this;
        }

        return $this;
    }

    /**
     * @param string $field
     * @param mixed $value
     * @return \Bigcommerce\ORM\QueryBuilder
     */
    public function whereEqual(string $field, $value)
    {
        $this->query[$field] = $value;

        return $this;
    }

    /**
     * @param string $field
     * @param array $values
     * @return \Bigcommerce\ORM\QueryBuilder
     */
    public function whereIn(string $field, array $values)
    {
        $this->query["$field:in"] = implode(",", $values);

        return $this;
    }

    /**
     * @param string $field
     * @param string $values
     * @return \Bigcommerce\ORM\QueryBuilder
     */
    public function whereLike(string $field, string $values)
    {
        $this->query["$field:like"] = $values;

        return $this;
    }

    /**
     * @param string $field
     * @param mixed $value
     * @return \Bigcommerce\ORM\QueryBuilder
     */
    public function whereMin(string $field, $value)
    {
        $this->query["$field:min"] = $value;

        return $this;
    }

    /**
     * @param string $field
     * @param mixed $value
     * @return \Bigcommerce\ORM\QueryBuilder
     */
    public function whereMax(string $field, $value)
    {
        $this->query["$field:max"] = $value;

        return $this;
    }

    /**
     * @param string|array $resources
     * @return \Bigcommerce\ORM\QueryBuilder
     */
    public function include($resources)
    {
        if (is_string($resources) && !in_array($resources, $this->includes)) {
            array_push($this->includes, $resources);
            return $this;
        }

        if (is_array($resources)) {
            foreach ($resources as $resource) {
                if (!in_array($resource, $this->includes)) {
                    array_push($this->includes, $resource);
                }
            }
            return $this;
        }

        return $this;
    }

    /**
     * @param int $page
     * @return \Bigcommerce\ORM\QueryBuilder
     */
    public function page(int $page)
    {
        $this->query['page'] = $page;

        return $this;
    }

    /**
     * @param int $limit limit
     * @return \Bigcommerce\ORM\QueryBuilder
     */
    public function limit(int $limit)
    {
        $this->query['limit'] = $limit;

        return $this;
    }

    /**
     * @param array $order
     * @return \Bigcommerce\ORM\QueryBuilder
     */
    public function order(array $order)
    {
        if (is_array($order)) {
            foreach ($order as $field => $value) {
                if (in_array($value, ['asc', 'desc'])) {
                    $this->query['sort'] = "$field:$value";
                }
            }
        }

        return $this;
    }

    /**
     * @param string $field
     * @param string $value
     * @return \Bigcommerce\ORM\QueryBuilder
     */
    public function orderBy(string $field, string $value)
    {
        if (in_array($value, ['asc', 'desc'])) {
            $this->query['sort'] = "$field:$value";
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getQueryString()
    {
        if (!empty($this->includes)) {
            $this->query['include'] = implode(",", $this->includes);
        }
        if (!empty($this->fields)) {
            $this->query['include_fields'] = implode(",", $this->fields);
        }

        return urldecode(http_build_query($this->query));
    }
}
