<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Helper\Configuration;

trait General
{
    public const XML_PATH_PRODUCT_VISIBILITY_MONITORING_GENERAL_IS_ENABLED = 'product_visibility_monitoring/general/is_enabled';

    protected \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_PRODUCT_VISIBILITY_MONITORING_GENERAL_IS_ENABLED);
    }
}
