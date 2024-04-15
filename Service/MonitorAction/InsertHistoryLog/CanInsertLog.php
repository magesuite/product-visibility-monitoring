<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Service\MonitorAction\InsertHistoryLog;

class CanInsertLog
{
    protected \MageSuite\ProductVisibilityMonitoring\Model\ResourceModel\CategoryProductsLog\CollectionFactory $collectionFactory;
    protected \MageSuite\ProductVisibilityMonitoring\Helper\Configuration\Logs $logsConfig;
    protected \MageSuite\ProductVisibilityMonitoring\Model\ThresholdDatetime $thresholdDatetime;

    public function __construct(
        \MageSuite\ProductVisibilityMonitoring\Model\ThresholdDatetime $thresholdDatetime,
        \MageSuite\ProductVisibilityMonitoring\Model\ResourceModel\CategoryProductsLog\CollectionFactory $collectionFactory,
        \MageSuite\ProductVisibilityMonitoring\Helper\Configuration\Logs $logsConfig,
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->logsConfig = $logsConfig;
        $this->thresholdDatetime = $thresholdDatetime;
    }

    public function execute(\MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest $monitorRequest): bool
    {
        $categoryId = $monitorRequest->getCategoryId();

        $storeId = $monitorRequest->getStoreId();
        $excludedCategories = $this->logsConfig->getExcludedCategories($storeId);

        if (in_array($categoryId, $excludedCategories)) {
            return false;
        }

        $interval = $this->logsConfig->getMinIntervalInMinutes();

        if (!$interval) {
            return true;
        }

        $collection = $this->collectionFactory->create();
        $collection->addCategoryFilter($categoryId);

        $storeId = $monitorRequest->getStoreId();
        $collection->addStoreFilter($storeId);

        $thresholdDatetime = $this->thresholdDatetime->get($interval);
        $collection->addCreatedAtThreshold($thresholdDatetime);

        $collection->setOrder(\MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsLog::CREATED_AT);

        if ($collection->getSize() === 0) {
            return true;
        }

        $lastLog = $collection->getFirstItem();

        return $lastLog->getNumberOfProducts() !== $monitorRequest->getNumberOfProducts();
    }
}
