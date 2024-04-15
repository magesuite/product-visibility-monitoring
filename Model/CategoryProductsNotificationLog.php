<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Model;

class CategoryProductsNotificationLog extends \Magento\Framework\Model\AbstractModel implements \MageSuite\ProductVisibilityMonitoring\Api\Data\CategoryProductsNotificationLogInterface
{
    public const NOTIFICATION_ID = 'notification_id';
    public const CATEGORY_ID = 'category_id';
    public const CREATED_AT = 'created_at';

    protected $_eventPrefix = 'category_products_notification_log_model'; // phpcs:ignore

    protected function _construct()
    {
        $this->_init(\MageSuite\ProductVisibilityMonitoring\Model\ResourceModel\CategoryProductsNotificationLog::class);
    }

    public function getNotificationId(): ?int
    {
        return $this->getData(self::NOTIFICATION_ID) === null ? null
            : (int)$this->getData(self::NOTIFICATION_ID);
    }

    public function setNotificationId(?int $notificationId): void
    {
        $this->setData(self::NOTIFICATION_ID, $notificationId);
    }

    public function getCategoryId(): ?int
    {
        return $this->getData(self::CATEGORY_ID) === null ? null
            : (int)$this->getData(self::CATEGORY_ID);
    }

    public function setCategoryId(?int $categoryId): void
    {
        $this->setData(self::CATEGORY_ID, $categoryId);
    }

    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    public function setCreatedAt(?string $createdAt): void
    {
        $this->setData(self::CREATED_AT, $createdAt);
    }
}
