<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Model;

class CategoryProductsNotificationLogRepository implements \MageSuite\ProductVisibilityMonitoring\Api\CategoryProductsNotificationLogRepositoryInterface
{
    protected \MageSuite\ProductVisibilityMonitoring\Model\ResourceModel\CategoryProductsNotificationLog $resource;

    public function __construct(
        \MageSuite\ProductVisibilityMonitoring\Model\ResourceModel\CategoryProductsNotificationLog $resource
    ) {
        $this->resource = $resource;
    }

    /**
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(\MageSuite\ProductVisibilityMonitoring\Api\Data\CategoryProductsNotificationLogInterface $categoryProductsLog): void
    {
        $this->resource->save($categoryProductsLog);
    }
}
