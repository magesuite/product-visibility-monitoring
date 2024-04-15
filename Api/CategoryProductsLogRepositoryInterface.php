<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Api;

interface CategoryProductsLogRepositoryInterface
{
    /**
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(\MageSuite\ProductVisibilityMonitoring\Api\Data\CategoryProductsLogInterface $log): void;
}
