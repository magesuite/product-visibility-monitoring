<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Service;

class Notification implements \MageSuite\ProductVisibilityMonitoring\Api\NotificationInterface
{
    protected \MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository;
    protected \MageSuite\NotificationDashboard\Model\Command\Notification\AddNotification $addNotification;
    protected \MageSuite\ProductVisibilityMonitoring\Model\ResourceModel\CategoryProductsNotificationLog\CollectionFactory $collectionFactory;
    protected \MageSuite\ProductVisibilityMonitoring\Helper\Configuration\Notifications $notificationsConfig;
    protected \MageSuite\ProductVisibilityMonitoring\Model\AddNotificationsLog $addNotificationsLog;
    protected \MageSuite\ProductVisibilityMonitoring\Model\ThresholdDatetime $thresholdDatetime;

    public function __construct(
        \MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository,
        \MageSuite\NotificationDashboard\Model\Command\Notification\AddNotification $addNotification,
        \MageSuite\ProductVisibilityMonitoring\Helper\Configuration\Notifications $notificationsConfig,
        \MageSuite\ProductVisibilityMonitoring\Model\AddNotificationsLog $addNotificationsLog,
        \MageSuite\ProductVisibilityMonitoring\Model\ResourceModel\CategoryProductsNotificationLog\CollectionFactory $collectionFactory,
        \MageSuite\ProductVisibilityMonitoring\Model\ThresholdDatetime $thresholdDatetime,
    ) {
        $this->collectorRepository = $collectorRepository;
        $this->addNotification = $addNotification;
        $this->collectionFactory = $collectionFactory;
        $this->notificationsConfig = $notificationsConfig;
        $this->addNotificationsLog = $addNotificationsLog;
        $this->thresholdDatetime = $thresholdDatetime;
    }

    public function send(\MageSuite\ProductVisibilityMonitoring\Model\NotificationRequest $notificationRequest): bool
    {
        if (!$this->canSendNotification($notificationRequest)) {
            return false;
        }

        $collectorName = $notificationRequest->getCollectorName();
        $collector = $this->collectorRepository->get($collectorName);

        $this->addNotification->execute(
            $notificationRequest->getMessage(),
            $collector->getId(),
            $collector->getSeverity()
        );

        $this->addNotificationsLog->execute($notificationRequest);

        return true;
    }

    public function canSendNotification(\MageSuite\ProductVisibilityMonitoring\Model\NotificationRequest $notificationRequest): bool
    {
        if (!$this->notificationsConfig->isEnabled()) {
            return false;
        }

        $monitorRequest = $notificationRequest->getMonitorRequest();

        if ($this->isNotificationAlreadySent($monitorRequest)) {
            return false;
        }

        return true;
    }

    public function isNotificationAlreadySent(\MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest $monitorRequest): bool
    {
        $interval = $this->notificationsConfig->getMinIntervalInMinutes();
        $thresholdDatetime = $this->thresholdDatetime->get($interval);
        $categoryId = $monitorRequest->getCategoryId();

        $collection = $this->collectionFactory->create();
        $collection->addCategoryFilter($categoryId);
        $collection->addFieldToFilter(\MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsNotificationLog::CREATED_AT, ['gt' => $thresholdDatetime]);

        return $collection->getSize() > 0;
    }
}
