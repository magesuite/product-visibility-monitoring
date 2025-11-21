<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Helper\Configuration;

class Notifications
{
    use \MageSuite\ProductVisibilityMonitoring\Helper\Configuration\General {
        isEnabled as protected isGlobalEnabled;
    }

    public const XML_PATH_PRODUCT_VISIBILITY_MONITORING_NOTIFICATIONS_IS_ENABLED = 'product_visibility_monitoring/notifications/is_enabled';
    public const XML_PATH_PRODUCT_VISIBILITY_MONITORING_NOTIFICATIONS_MIN_INTERVAL = 'product_visibility_monitoring/notifications/min_interval_in_minutes';
    public const XML_PATH_PRODUCT_VISIBILITY_MONITORING_NOTIFICATIONS_EXCLUDED_CATEGORIES = 'product_visibility_monitoring/notifications/excluded_categories';
    public const XML_PATH_PRODUCT_VISIBILITY_MONITORING_GENERAL_CATEGORIES_WITH_EXPECTED_ZERO_PRODUCTS = 'product_visibility_monitoring/notifications/categories_with_expected_zero_products';

    public function isEnabled(): bool
    {
        return $this->isGlobalEnabled() && $this->scopeConfig->isSetFlag(self::XML_PATH_PRODUCT_VISIBILITY_MONITORING_NOTIFICATIONS_IS_ENABLED);
    }

    /**
     * @return int - minimal interval between the same alerts
     */
    public function getMinIntervalInMinutes(): int
    {
        return (int)$this->scopeConfig->getValue(self::XML_PATH_PRODUCT_VISIBILITY_MONITORING_NOTIFICATIONS_MIN_INTERVAL);
    }

    /**
     * @return int[] - ids of categories excluded from notifications
     */
    public function getExcludedCategories(?int $storeId = null): array
    {
        $categories = (string)$this->scopeConfig->getValue(
            self::XML_PATH_PRODUCT_VISIBILITY_MONITORING_NOTIFICATIONS_EXCLUDED_CATEGORIES,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );

        return explode(',', $categories);
    }

    /**
     * @return int[] - ids of categories which should have 0 products
     */
    public function getCategoriesWithExpectedZeroProducts(?int $storeId = null): array
    {
        $categories = (string)$this->scopeConfig->getValue(
            self::XML_PATH_PRODUCT_VISIBILITY_MONITORING_GENERAL_CATEGORIES_WITH_EXPECTED_ZERO_PRODUCTS,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );

        return explode(',', $categories);
    }
}
