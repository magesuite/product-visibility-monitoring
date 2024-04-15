<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Model;

class AddNotificationsLog
{
    protected \MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository;
    protected \MageSuite\ProductVisibilityMonitoring\Api\CategoryProductsNotificationLogRepositoryInterface $notificationLogRepository;
    protected \MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsNotificationLogFactory $modelFactory;

    public function __construct(
        \MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository,
        \MageSuite\ProductVisibilityMonitoring\Api\CategoryProductsNotificationLogRepositoryInterface $notificationLogRepository,
        \MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsNotificationLogFactory $modelFactory,
    ) {
        $this->collectorRepository = $collectorRepository;
        $this->notificationLogRepository = $notificationLogRepository;
        $this->modelFactory = $modelFactory;
    }

    public function execute(\MageSuite\ProductVisibilityMonitoring\Model\NotificationRequest $notificationRequest): void
    {
        /** @var \MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsNotificationLog $model */
        $model = $this->modelFactory->create();

        $categoryId = (int)$notificationRequest->getMonitorRequest()->getCategory()->getId();
        $model->setCategoryId($categoryId);

        $collectorId = $this->getCollectorId($notificationRequest);
        $model->setCollectorId($collectorId);

        $this->notificationLogRepository->save($model);
    }

    protected function getCollectorId(NotificationRequest $notificationRequest): int
    {
        $collectorName = $notificationRequest->getCollectorName();
        $collector = $this->collectorRepository->get($collectorName);

        return (int)$collector->getId();
    }
}
