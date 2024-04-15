<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Api;

interface AddToMonitoringQueueInterface
{
    public function execute(\MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest $monitorRequest): bool;
}
