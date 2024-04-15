<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Service\MonitorAction;

interface ActionInterface
{
    public function isEnabled(): bool;

    /**
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function execute(\MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest $monitorRequest): bool;
}
