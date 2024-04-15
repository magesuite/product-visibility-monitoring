<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Api;

interface MonitorInterface
{
    public function run(\MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest $monitorRequest): void;
}
