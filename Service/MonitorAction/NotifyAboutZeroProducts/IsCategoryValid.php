<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Service\MonitorAction\NotifyAboutZeroProducts;

class IsCategoryValid
{
    public function __construct(
        protected \MageSuite\ProductVisibilityMonitoring\Helper\Configuration\Notifications $config,
    ) {}

    /**
     * Verify if categories with expected non-zero number of products actually has any products.
     * Verify if categories with expected zero number of products actually has not any product.
     */
    public function execute(\MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest $monitorRequest): bool
    {
        $categoryId = $monitorRequest->getCategoryId();

        $storeId = $monitorRequest->getStoreId();
        $excludedCategories = $this->config->getExcludedCategories($storeId);

        if (in_array($categoryId, $excludedCategories)) {
            return true;
        }

        $storeId = $monitorRequest->getStoreId();
        $categoriesWithExpectedZeroProducts = $this->config->getCategoriesWithExpectedZeroProducts($storeId);

        $numberOfProducts = $monitorRequest->getNumberOfProducts();

        return !($numberOfProducts === 0 xor in_array($categoryId, $categoriesWithExpectedZeroProducts));
    }
}
