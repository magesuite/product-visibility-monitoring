<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Model;

class AddQueueLog
{
    public function __construct(
        protected \MageSuite\ProductVisibilityMonitoring\Api\CategoryProductsQueueLogRepositoryInterface $queueLogRepository,
        protected \MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsQueueLogFactory $modelFactory,
    ) {}

    public function execute(MonitorRequest $monitorRequest): void
    {
        $model = $this->modelFactory->create();

        $categoryId = $monitorRequest->getCategoryId();
        $model->setCategoryId($categoryId);

        $storeId = $monitorRequest->getStoreId();
        $model->setStoreId($storeId);

        $this->queueLogRepository->save($model);
    }
}
