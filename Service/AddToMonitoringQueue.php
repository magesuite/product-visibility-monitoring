<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Service;

class AddToMonitoringQueue implements \MageSuite\ProductVisibilityMonitoring\Api\AddToMonitoringQueueInterface
{
    public const QUEUE_PAYLOAD_KEY_CATEGORY_ID = 'category_id';
    public const QUEUE_PAYLOAD_KEY_NUMBER_OF_PRODUCTS = 'number_of_products';
    public const QUEUE_PAYLOAD_KEY_STORE_ID = 'store_id';

    public function __construct(
        protected \MageSuite\ProductVisibilityMonitoring\Model\AddQueueLog $addQueueLog,
        protected \MageSuite\ProductVisibilityMonitoring\Model\CanAddToQueue $canAddToQueue,
        protected \MageSuite\Queue\Service\Publisher $publisher,
        protected \Psr\Log\LoggerInterface $logger,
        protected string $handler,
    ) {}

    public function execute(\MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest $monitorRequest): bool
    {
        if (!$this->canAddToQueue->execute($monitorRequest)) {
            return false;
        }

        $payload = $this->preparePayload($monitorRequest);

        try {
            $this->publisher->publish($this->handler, $payload);
            $this->addQueueLog->execute($monitorRequest);

            return true;
        } catch (\Throwable $t) {
            $this->logger->error($t->getMessage(), $t->getTrace());

            return false;
        }
    }

    public function preparePayload(\MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest $monitorRequest): array
    {
        return [
            self::QUEUE_PAYLOAD_KEY_CATEGORY_ID => $monitorRequest->getCategoryId(),
            self::QUEUE_PAYLOAD_KEY_NUMBER_OF_PRODUCTS => $monitorRequest->getNumberOfProducts(),
            self::QUEUE_PAYLOAD_KEY_STORE_ID => $monitorRequest->getStoreId(),
        ];
    }
}
