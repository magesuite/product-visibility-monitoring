<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Model;

class CanAddToQueue
{
    protected \Magento\Framework\App\RequestInterface $request;
    protected \MageSuite\ProductVisibilityMonitoring\Model\ResourceModel\CategoryProductsQueueLog\CollectionFactory $collectionFactory;
    protected \MageSuite\ProductVisibilityMonitoring\Helper\Configuration\Queue $queueConfig;
    protected \MageSuite\ProductVisibilityMonitoring\Model\ThresholdDatetime $thresholdDatetime;
    protected array $allowedRequestParams;

    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \MageSuite\ProductVisibilityMonitoring\Helper\Configuration\Queue $queueConfig,
        \MageSuite\ProductVisibilityMonitoring\Model\ResourceModel\CategoryProductsQueueLog\CollectionFactory $collectionFactory,
        \MageSuite\ProductVisibilityMonitoring\Model\ThresholdDatetime $thresholdDatetime,
        array $allowedRequestParams = []
    ) {
        $this->request = $request;
        $this->collectionFactory = $collectionFactory;
        $this->queueConfig = $queueConfig;
        $this->thresholdDatetime = $thresholdDatetime;
        $this->allowedRequestParams = $allowedRequestParams;
    }

    public function execute(\MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest $monitorRequest): bool
    {
        if (!$this->queueConfig->isEnabled()) {
            return false;
        }

        if ($this->hasRequestParams()) {
            return false;
        }

        return !$this->isAlreadyAdded($monitorRequest);
    }

    protected function isAlreadyAdded(\MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest $monitorRequest): bool
    {
        $interval = $this->queueConfig->getMinIntervalInMinutes();

        if (!$interval) {
            return false;
        }

        $categoryId = $monitorRequest->getCategoryId();

        $collection = $this->collectionFactory->create();
        $collection->addCategoryFilter($categoryId);

        $storeId = $monitorRequest->getStoreId();
        $collection->addStoreFilter($storeId);

        $thresholdDatetime = $this->thresholdDatetime->get($interval);
        $collection->addCreatedAtThreshold($thresholdDatetime);

        return $collection->getSize() > 0;
    }

    protected function hasRequestParams(): bool
    {
        $params = $this->request->getParams();
        $paramsKeys = array_keys($params);

        $notAllowedRequestParams = array_diff($paramsKeys, $this->allowedRequestParams);

        return !empty($notAllowedRequestParams);
    }
}
