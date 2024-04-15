<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Api;

interface CountProductsInCategoryInterface
{
    public function execute(\Magento\Catalog\Api\Data\CategoryInterface $category): int;
}
