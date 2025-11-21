<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Model;

class NotificationRequest extends \Magento\Framework\DataObject
{
    public const KEY_MONITOR_REQUEST = 'monitor_request';
    public const KEY_COLLECTOR_NAME = 'collector_name';
    public const KEY_MESSAGE = 'message';

    public function setMonitorRequest(\MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest $monitorRequest): self
    {
        return $this->setData(self::KEY_MONITOR_REQUEST, $monitorRequest);
    }

    public function getMonitorRequest(): ?\MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest
    {
        return $this->_getData(self::KEY_MONITOR_REQUEST);
    }

    public function setCollectorName(string $collectorName): self
    {
        return $this->setData(self::KEY_COLLECTOR_NAME, $collectorName);
    }

    public function getCollectorName(): string
    {
        $collectorName = $this->_getData(self::KEY_COLLECTOR_NAME);
        return $collectorName ?? \MageSuite\ProductVisibilityMonitoring\Setup\Patch\Data\AddCategoryZeroProductsCollector::COLLECTOR_NAME;
    }

    public function setMessage(string $message): self
    {
        return $this->setData(self::KEY_MESSAGE, $message);
    }

    public function getMessage(): ?string
    {
        return $this->_getData(self::KEY_MESSAGE);
    }
}
