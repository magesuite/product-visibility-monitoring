<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Model;

class CategoryProductsLog extends \Magento\Framework\Model\AbstractModel implements \MageSuite\ProductVisibilityMonitoring\Api\Data\CategoryProductsLogInterface
{
    public const LOG_ID = 'log_id';
    public const CATEGORY_ID = 'category_id';
    public const NUMBER_OF_PRODUCTS = 'number_of_products';
    public const STORE_ID = 'store_id';
    public const CREATED_AT = 'created_at';

    protected $_eventPrefix = 'category_products_log_model';  // phpcs:ignore

    protected function _construct()
    {
        $this->_init(\MageSuite\ProductVisibilityMonitoring\Model\ResourceModel\CategoryProductsLog::class);
    }

    public function getLogId(): ?int
    {
        return $this->_getData(self::LOG_ID) === null ? null
            : (int)$this->_getData(self::LOG_ID);
    }

    public function setLogId(?int $categoryProductsLogId): void
    {
        $this->setData(self::LOG_ID, $categoryProductsLogId);
    }

    public function getCategoryId(): ?int
    {
        return $this->_getData(self::CATEGORY_ID) === null ? null
            : (int)$this->_getData(self::CATEGORY_ID);
    }

    public function setCategoryId(?int $categoryId): void
    {
        $this->setData(self::CATEGORY_ID, $categoryId);
    }

    public function getNumberOfProducts(): ?int
    {
        return $this->_getData(self::NUMBER_OF_PRODUCTS) === null ? null
            : (int)$this->_getData(self::NUMBER_OF_PRODUCTS);
    }

    public function setNumberOfProducts(?int $numberOfProducts): void
    {
        $this->setData(self::NUMBER_OF_PRODUCTS, $numberOfProducts);
    }

    public function setStoreId(?int $storeId): void
    {
        $this->setData(self::STORE_ID, $storeId);
    }

    public function getStoreId(): ?int
    {
        return $this->_getData(self::STORE_ID) === null ? null
            : (int)$this->_getData(self::STORE_ID);
    }

    public function getCreatedAt(): ?string
    {
        return $this->_getData(self::CREATED_AT);
    }

    public function setCreatedAt(?string $createdAt): void
    {
        $this->setData(self::CREATED_AT, $createdAt);
    }
}
