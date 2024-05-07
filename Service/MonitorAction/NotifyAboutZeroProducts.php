<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Service\MonitorAction;

class NotifyAboutZeroProducts implements \MageSuite\ProductVisibilityMonitoring\Service\MonitorAction\ActionInterface
{
    protected \MageSuite\ProductVisibilityMonitoring\Api\NotificationInterface $notification;
    protected \MageSuite\ProductVisibilityMonitoring\Model\NotificationRequestFactory $notificationRequestFactory;
    protected \MageSuite\ProductVisibilityMonitoring\Service\MonitorAction\NotifyAboutZeroProducts\IsCategoryValid $isCategoryValid;
    protected bool $isEnabled;

    public function __construct(
        \MageSuite\ProductVisibilityMonitoring\Api\NotificationInterface $notification,
        \MageSuite\ProductVisibilityMonitoring\Model\NotificationRequestFactory $notificationRequestFactory,
        \MageSuite\ProductVisibilityMonitoring\Service\MonitorAction\NotifyAboutZeroProducts\IsCategoryValid $isCategoryValid,
        bool $isEnabled = true
    ) {
        $this->isCategoryValid = $isCategoryValid;
        $this->notification = $notification;
        $this->notificationRequestFactory = $notificationRequestFactory;
        $this->isEnabled = $isEnabled;
    }

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    public function execute(\MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest $monitorRequest): bool
    {
        if (!$this->isCategoryValid->execute($monitorRequest)) {
            return false;
        }

        $notificationRequest = $this->notificationRequestFactory->create();
        $notificationRequest->setMonitorRequest($monitorRequest);
        $notificationRequest->setCollectorName(\MageSuite\ProductVisibilityMonitoring\Setup\Patch\Data\AddCategoryZeroProductsCollector::COLLECTOR_NAME);

        $message = $this->prepareNotificationMessage($notificationRequest);
        $notificationRequest->setMessage($message);

        $this->notification->send($notificationRequest);

        return true;
    }

    public function prepareNotificationMessage(\MageSuite\ProductVisibilityMonitoring\Model\NotificationRequest $notificationRequest): string
    {
        $monitorRequest = $notificationRequest->getMonitorRequest();

        $categoryId = $monitorRequest->getCategoryId();
        $numberOfProducts = $monitorRequest->getNumberOfProducts();

        return sprintf('Category with ID %d has %d products.', $categoryId, $numberOfProducts);
    }
}
