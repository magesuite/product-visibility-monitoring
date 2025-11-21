<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Model;

class CategoryProductsQueueLogRepository implements \MageSuite\ProductVisibilityMonitoring\Api\CategoryProductsQueueLogRepositoryInterface
{
    public function __construct(
        protected \MageSuite\ProductVisibilityMonitoring\Model\ResourceModel\CategoryProductsQueueLog $resource,
    ) {}

    /**
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(\MageSuite\ProductVisibilityMonitoring\Api\Data\CategoryProductsQueueLogInterface $log): void
    {
        $this->resource->save($log);
    }
}
