<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Model;

class MonitorRequest extends \Magento\Framework\DataObject
{
    public const KEY_CATEGORY = 'category';
    public const KEY_NUMBER_OF_PRODUCTS = 'number_of_products';
    public const KEY_AVERAGE_NUMBER_OF_PRODUCTS = 'average_number_of_products';
    public const KEY_DROP_PERCENTAGE = 'drop_percentage';
    public const KEY_STORE_ID = 'store_id';
    public const KEY_COLLECTION = 'collection';

    public function setCategory(\Magento\Catalog\Api\Data\CategoryInterface $category): self
    {
        return $this->setData(self::KEY_CATEGORY, $category);
    }

    public function getCategory(): ?\Magento\Catalog\Api\Data\CategoryInterface
    {
        return $this->_getData(self::KEY_CATEGORY);
    }

    public function getCategoryId(): ?int
    {
        $category = $this->getCategory();

        return $category ? (int)$category->getId() : null;
    }

    public function setNumberOfProducts(int $numberOfProducts): self
    {
        return $this->setData(self::KEY_NUMBER_OF_PRODUCTS, $numberOfProducts);
    }

    public function getNumberOfProducts(): ?int
    {
        return $this->_getData(self::KEY_NUMBER_OF_PRODUCTS);
    }

    public function setStoreId(int $storeId): self
    {
        return $this->setData(self::KEY_STORE_ID, $storeId);
    }

    public function getStoreId(): ?int
    {
        return $this->_getData(self::KEY_STORE_ID);
    }

    public function setCollection(\Magento\Eav\Model\Entity\Collection\AbstractCollection $collection): self
    {
        return $this->setData(self::KEY_COLLECTION, $collection);
    }

    public function getCollection(): ?\Magento\Eav\Model\Entity\Collection\AbstractCollection
    {
        return $this->_getData(self::KEY_COLLECTION);
    }
}
