<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Model\ResourceModel\CategoryProductsQueueLog;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_eventPrefix = 'category_products_queue_log_collection'; // phpcs:ignore

    protected function _construct()
    {
        $this->_init(
            \MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsQueueLog::class,
            \MageSuite\ProductVisibilityMonitoring\Model\ResourceModel\CategoryProductsQueueLog::class
        );
    }

    public function addCategoryFilter(int $categoryId): self
    {
        return $this->addFieldToFilter(\MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsQueueLog::CATEGORY_ID, $categoryId);
    }

    public function addStoreFilter(int $storeId): self
    {
        return $this->addFieldToFilter(\MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsQueueLog::STORE_ID, $storeId);
    }

    public function addCreatedAtThreshold(string $thresholdDatetime): self
    {
        return $this->addFieldToFilter(\MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsQueueLog::CREATED_AT, ['gt' => $thresholdDatetime]);
    }
}
