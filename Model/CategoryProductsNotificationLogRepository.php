<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Model;

class CategoryProductsNotificationLogRepository implements \MageSuite\ProductVisibilityMonitoring\Api\CategoryProductsNotificationLogRepositoryInterface
{
    public function __construct(
        protected \MageSuite\ProductVisibilityMonitoring\Model\ResourceModel\CategoryProductsNotificationLog $resource
    ) {}

    /**
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(\MageSuite\ProductVisibilityMonitoring\Api\Data\CategoryProductsNotificationLogInterface $categoryProductsLog): void
    {
        $this->resource->save($categoryProductsLog);
    }
}
