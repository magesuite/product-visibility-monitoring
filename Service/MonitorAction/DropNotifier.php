<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Service\MonitorAction;

class DropNotifier implements ActionInterface
{
    public function __construct(
        protected \MageSuite\ProductVisibilityMonitoring\Api\NotificationInterface $notification,
        protected \MageSuite\ProductVisibilityMonitoring\Model\NotificationRequestFactory $notificationRequestFactory,
        protected \MageSuite\ProductVisibilityMonitoring\Service\MonitorAction\NotifyAboutProductNumberAnomaly\DropDetector $dropDetector,
        protected bool $isEnabled = true
    ) {}

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    public function execute(\MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest $monitorRequest): bool
    {
        if (!$this->dropDetector->isDropDetected($monitorRequest)) {
            return false;
        }

        $notificationRequest = $this->notificationRequestFactory->create();
        $notificationRequest->setMonitorRequest($monitorRequest);
        $message = $this->prepareNotificationMessage($notificationRequest);
        $notificationRequest->setMessage($message);
        $this->notification->send($notificationRequest);
        return true;
    }

    public function prepareNotificationMessage(\MageSuite\ProductVisibilityMonitoring\Model\NotificationRequest $notificationRequest): string
    {
        $monitorRequest = $notificationRequest->getMonitorRequest();
        $categoryId = $monitorRequest->getCategoryId();
        $currentNumberOfProducts = $monitorRequest->getNumberOfProducts();

        return sprintf(
            'Category with ID %d has experienced a significant drop in product visibility. Current number of products: %d.',
            $categoryId,
            $currentNumberOfProducts
        );
    }
}
