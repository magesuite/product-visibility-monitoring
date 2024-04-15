<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Model;

class AddQueueLog
{
    protected \MageSuite\ProductVisibilityMonitoring\Api\CategoryProductsQueueLogRepositoryInterface $queueLogRepository;
    protected \MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsQueueLogFactory $modelFactory;

    public function __construct(
        \MageSuite\ProductVisibilityMonitoring\Api\CategoryProductsQueueLogRepositoryInterface $queueLogRepository,
        \MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsQueueLogFactory $modelFactory,
    ) {
        $this->queueLogRepository = $queueLogRepository;
        $this->modelFactory = $modelFactory;
    }

    public function execute(MonitorRequest $monitorRequest): void
    {
        $model = $this->modelFactory->create();

        $categoryId = $monitorRequest->getCategory()->getId();
        $model->setCategoryId($categoryId);

        $storeId = $monitorRequest->getStoreId();
        $model->setStoreId($storeId);

        $this->queueLogRepository->save($model);
    }
}
