<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Helper\Configuration;

class Queue
{
    use \MageSuite\ProductVisibilityMonitoring\Helper\Configuration\General {
        isEnabled as protected isGlobalEnabled;
    }

    public const XML_PATH_PRODUCT_VISIBILITY_MONITORING_QUEUE_IS_ENABLED = 'product_visibility_monitoring/queue/is_enabled';
    public const XML_PATH_PRODUCT_VISIBILITY_MONITORING_QUEUE_MIN_INTERVAL = 'product_visibility_monitoring/queue/min_interval_in_minutes';

    public function isEnabled(): bool
    {
        return $this->isGlobalEnabled() && $this->scopeConfig->isSetFlag(self::XML_PATH_PRODUCT_VISIBILITY_MONITORING_QUEUE_IS_ENABLED);
    }

    /**
     * @return int - minimal interval between the adding the same category to queue
     */
    public function getMinIntervalInMinutes(): int
    {
        return (int)$this->scopeConfig->getValue(self::XML_PATH_PRODUCT_VISIBILITY_MONITORING_QUEUE_MIN_INTERVAL);
    }
}
