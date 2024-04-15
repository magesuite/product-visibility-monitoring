<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Api;

interface CategoryProductsNotificationLogRepositoryInterface
{
    /**
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(\MageSuite\ProductVisibilityMonitoring\Api\Data\CategoryProductsNotificationLogInterface $categoryProductsLog): void;
}
