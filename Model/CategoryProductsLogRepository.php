<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Model;

class CategoryProductsLogRepository implements \MageSuite\ProductVisibilityMonitoring\Api\CategoryProductsLogRepositoryInterface
{
    public function __construct(
        protected \MageSuite\ProductVisibilityMonitoring\Model\ResourceModel\CategoryProductsLog $resource,
    ) {}

    /**
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(\MageSuite\ProductVisibilityMonitoring\Api\Data\CategoryProductsLogInterface $log): void
    {
        $this->resource->save($log);
    }

    public function delete(\MageSuite\ProductVisibilityMonitoring\Api\Data\CategoryProductsLogInterface $log): void
    {
        $this->resource->delete($log);
    }
}
