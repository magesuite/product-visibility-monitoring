<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Helper\Configuration;

trait General
{
    public function __construct(
        protected \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {}

    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag('product_visibility_monitoring/general/is_enabled');
    }
}
