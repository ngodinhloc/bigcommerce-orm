<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;
use Bigcommerce\ORM\Entity;

/**
 * Class Brand
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="Brand", path="/catalog/brands", type="api")
 */
class Brand extends Entity
{
    /**
     * @var string|null
     * @BC\Field(name="name")
     */
    protected $name;

    /**
     * @var string|null
     * @BC\Field(name="page_title")
     */
    protected $pageTitle;

    /**
     * @var array|null
     * @BC\Field(name="meta_keywords")
     */
    protected $metaKeywords;

    /**
     * @var string|null
     * @BC\Field(name="meta_description")
     */
    protected $metaDescription;

    /**
     * @var string|null
     * @BC\Field(name="image_url")
     */
    protected $imageUrl;

    /**
     * @var string|null
     * @BC\Field(name="search_keywords")
     */
    protected $searchKeywords;

    /**
     * @var array|null
     * @BC\Field(name="custom_url")
     */
    protected $customUrl;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return \Bigcommerce\ORM\Entities\Brand
     */
    public function setName(?string $name): Brand
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPageTitle(): ?string
    {
        return $this->pageTitle;
    }

    /**
     * @param string|null $pageTitle
     * @return \Bigcommerce\ORM\Entities\Brand
     */
    public function setPageTitle(?string $pageTitle): Brand
    {
        $this->pageTitle = $pageTitle;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getMetaKeywords(): ?array
    {
        return $this->metaKeywords;
    }

    /**
     * @param array|null $metaKeywords
     * @return \Bigcommerce\ORM\Entities\Brand
     */
    public function setMetaKeywords(?array $metaKeywords): Brand
    {
        $this->metaKeywords = $metaKeywords;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    /**
     * @param string|null $metaDescription
     * @return \Bigcommerce\ORM\Entities\Brand
     */
    public function setMetaDescription(?string $metaDescription): Brand
    {
        $this->metaDescription = $metaDescription;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    /**
     * @param string|null $imageUrl
     * @return \Bigcommerce\ORM\Entities\Brand
     */
    public function setImageUrl(?string $imageUrl): Brand
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSearchKeywords(): ?string
    {
        return $this->searchKeywords;
    }

    /**
     * @param string|null $searchKeywords
     * @return \Bigcommerce\ORM\Entities\Brand
     */
    public function setSearchKeywords(?string $searchKeywords): Brand
    {
        $this->searchKeywords = $searchKeywords;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getCustomUrl(): ?array
    {
        return $this->customUrl;
    }

    /**
     * @param array|null $customUrl
     * @return \Bigcommerce\ORM\Entities\Brand
     */
    public function setCustomUrl(?array $customUrl): Brand
    {
        $this->customUrl = $customUrl;
        return $this;
    }
}