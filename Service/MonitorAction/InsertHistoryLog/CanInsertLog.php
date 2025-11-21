<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Service\MonitorAction\InsertHistoryLog;

class CanInsertLog
{
    public function __construct(
        protected \MageSuite\ProductVisibilityMonitoring\Model\ThresholdDatetime $thresholdDatetime,
        protected \MageSuite\ProductVisibilityMonitoring\Model\ResourceModel\CategoryProductsLog\CollectionFactory $collectionFactory,
        protected \MageSuite\ProductVisibilityMonitoring\Helper\Configuration\Logs $logsConfig,
    ) {}

    public function execute(\MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest $monitorRequest): bool
    {
        $categoryId = $monitorRequest->getCategoryId();

        $storeId = $monitorRequest->getStoreId();
        $excludedCategories = $this->logsConfig->getExcludedCategories($storeId);

        if (in_array($categoryId, $excludedCategories)) {
            return false;
        }

        $collection = $this->collectionFactory->create();
        $collection->addCategoryFilter($categoryId);

        $storeId = $monitorRequest->getStoreId();
        $collection->addStoreFilter($storeId);

        $collection->setOrder(\MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsLog::CREATED_AT);

        if ($collection->getSize() === 0) {
            return true;
        }

        $lastLog = $collection->getFirstItem();

        return $lastLog->getNumberOfProducts() !== $monitorRequest->getNumberOfProducts();
    }
}
