<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Model\ResourceModel\CategoryProductsNotificationLog;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_eventPrefix = 'category_products_notification_log_collection'; // phpcs:ignore

    protected function _construct()
    {
        $this->_init(
            \MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsNotificationLog::class,
            \MageSuite\ProductVisibilityMonitoring\Model\ResourceModel\CategoryProductsNotificationLog::class
        );
    }

    public function addCategoryFilter(int $categoryId): self
    {
        return $this->addFieldToFilter(\MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsNotificationLog::CATEGORY_ID, $categoryId);
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
