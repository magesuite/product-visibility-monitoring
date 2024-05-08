<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Helper\Configuration;

trait General
{
    protected \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag('product_visibility_monitoring/general/is_enabled');
    }
}
