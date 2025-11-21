<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Service\MonitorAction\NotifyAboutProductNumberAnomaly;

class DropDetector
{
    public function __construct(
        protected \MageSuite\ProductVisibilityMonitoring\Helper\Configuration\Notifications $config,
        protected \MageSuite\ProductVisibilityMonitoring\Model\ResourceModel\CategoryProductsLog\CollectionFactory $productsLogCollectionFactory,
        protected \MageSuite\ProductVisibilityMonitoring\Service\MonitorAction\InsertHistoryLog\CanInsertLog $canInsertLog,
    ) {}

    public function isDropDetected(\MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest $monitorRequest): bool
    {
        if (!$this->canInsertLog->execute($monitorRequest)) {
            return false;
        }

        $categoryId = $monitorRequest->getCategoryId();
        $storeId = $monitorRequest->getStoreId();
        $excludedCategories = $this->config->getExcludedCategories($storeId);

        if (in_array($categoryId, $excludedCategories)) {
            return false;
        }

        $averageNumberOfProducts = $this->getAverageNumberOfProducts($monitorRequest);

        if ($averageNumberOfProducts < $this->config->getMinAverageNumber()) {
            return false;
        }

        $currentNumberOfProducts = $monitorRequest->getNumberOfProducts();

        if ($currentNumberOfProducts > $averageNumberOfProducts) {
            return false;
        }

        $thresholdPercentage = $this->config->getThresholdPercent($storeId);
        $difference = $averageNumberOfProducts - $currentNumberOfProducts;
        $differencePercentage = ($difference / $averageNumberOfProducts) * 100;

        if ($differencePercentage < $thresholdPercentage) {
            return false;
        }

        return true;
    }

    public function getAverageNumberOfProducts(\MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest $monitorRequest): int
    {
        $logsCollection = $this->productsLogCollectionFactory->create();
        $connection = $logsCollection->getConnection();
        $select = $connection->select()
            ->from(
                $logsCollection->getMainTable(),
                ['avg_number' => new \Zend_Db_Expr('ROUND(AVG(number_of_products))')]
            )
            ->where('category_id = ?', $monitorRequest->getCategoryId())
            ->where('store_id = ?', $monitorRequest->getStoreId());

        return (int)$connection->fetchOne($select);
    }
}
