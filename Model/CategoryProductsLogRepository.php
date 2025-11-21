<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Model;

class CategoryProductsLogRepository implements \MageSuite\ProductVisibilityMonitoring\Api\CategoryProductsLogRepositoryInterface
{
    protected \MageSuite\ProductVisibilityMonitoring\Model\ResourceModel\CategoryProductsLog $resource;

    public function __construct(
        \MageSuite\ProductVisibilityMonitoring\Model\ResourceModel\CategoryProductsLog $resource,
    ) {
        $this->resource = $resource;
    }

    /**
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(\MageSuite\ProductVisibilityMonitoring\Api\Data\CategoryProductsLogInterface $log): void
    {
        $this->resource->save($log);
    }
}
