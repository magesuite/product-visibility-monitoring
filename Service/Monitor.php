<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Service;

class Monitor implements \MageSuite\ProductVisibilityMonitoring\Api\MonitorInterface
{
    protected \Psr\Log\LoggerInterface $logger;

    /** @var \MageSuite\ProductVisibilityMonitoring\Service\MonitorAction\ActionInterface[] */
    protected array $monitorActions;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        array $monitorActions
    ) {
        $this->monitorActions = $monitorActions;
        $this->logger = $logger;
    }

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
