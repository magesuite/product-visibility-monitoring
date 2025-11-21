<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Service;

class Monitor implements \MageSuite\ProductVisibilityMonitoring\Api\MonitorInterface
{
    public function __construct(
        protected \Psr\Log\LoggerInterface $logger,
        protected array $monitorActions,
    ) {}

    public function run(\MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest $monitorRequest): void
    {
        foreach ($this->monitorActions as $action) {
            if (!$action->isEnabled()) {
                continue;
            }

            try {
                $action->execute($monitorRequest);
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage(), $e->getTrace());
            }
        }
    }
}
