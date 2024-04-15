<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Helper\Configuration;

class Logs
{
    use \MageSuite\ProductVisibilityMonitoring\Helper\Configuration\General {
        isEnabled as protected isGlobalEnabled;
    }

    public const XML_PATH_PRODUCT_VISIBILITY_MONITORING_LOGS_IS_ENABLED = 'product_visibility_monitoring/logs/is_enabled';
    public const XML_PATH_PRODUCT_VISIBILITY_MONITORING_LOGS_MIN_INTERVAL = 'product_visibility_monitoring/logs/min_interval_in_minutes';
    public const XML_PATH_PRODUCT_VISIBILITY_MONITORING_LOGS_EXCLUDED_CATEGORIES = 'product_visibility_monitoring/logs/excluded_categories';

    public function isEnabled(): bool
    {
        return $this->isGlobalEnabled() && $this->scopeConfig->isSetFlag(self::XML_PATH_PRODUCT_VISIBILITY_MONITORING_LOGS_IS_ENABLED);
    }

    /**
     * @return int - minimal interval between the same log entries
     */
    public function getMinIntervalInMinutes(): int
    {
        return (int)$this->scopeConfig->getValue(self::XML_PATH_PRODUCT_VISIBILITY_MONITORING_LOGS_MIN_INTERVAL);
    }

    /**
     * @return int[] - ids of categories excluded from logging
     */
    public function getExcludedCategories(?int $storeId = null): array
    {
        $categories = (string)$this->scopeConfig->getValue(
            self::XML_PATH_PRODUCT_VISIBILITY_MONITORING_LOGS_EXCLUDED_CATEGORIES,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );

        return explode(',', $categories);
    }
}
