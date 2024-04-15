<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Model;

class ThresholdDatetime
{
    public function get(int $intervalInMinutes): string
    {
        $threshold = new \DateTime(sprintf('now -%s minutes', $intervalInMinutes));

        return $threshold->format(\Magento\Framework\DB\Adapter\Pdo\Mysql::TIMESTAMP_FORMAT);
    }
}
