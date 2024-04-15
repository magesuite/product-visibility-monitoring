<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Plugin\Magento\Catalog\Block\Product\ListProduct;

class CategoryProductsMonitoring
{
    protected \MageSuite\ProductVisibilityMonitoring\Api\AddToMonitoringQueueInterface $addToMonitoringQueue;
    protected \MageSuite\ProductVisibilityMonitoring\Model\MonitorRequestFactory $monitorRequestFactory;
    protected \Magento\Framework\Registry $registry;

    protected bool $alreadyUsed = false;

    public function __construct(
        \MageSuite\ProductVisibilityMonitoring\Api\AddToMonitoringQueueInterface $addToMonitoringQueue,
        \MageSuite\ProductVisibilityMonitoring\Model\MonitorRequestFactory $monitorRequestFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->addToMonitoringQueue = $addToMonitoringQueue;
        $this->monitorRequestFactory = $monitorRequestFactory;
        $this->registry = $registry;
    }

    public function afterGetLoadedProductCollection(
        \Magento\Catalog\Block\Product\ListProduct $subject,
        \Magento\Eav\Model\Entity\Collection\AbstractCollection $collection
    ): \Magento\Eav\Model\Entity\Collection\AbstractCollection {
        if ($this->alreadyUsed) {
            return $collection;
        }

        $monitorRequest = $this->prepareMonitorRequest($collection);

        if (!$monitorRequest) {
            return $collection;
        }

        $this->addToMonitoringQueue->execute($monitorRequest);
        $this->alreadyUsed = true;

        return $collection;
    }

    protected function prepareMonitorRequest(
        \Magento\Eav\Model\Entity\Collection\AbstractCollection $collection
    ): ?\MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest {
        $category = $this->registry->registry('current_category');
        $categoryId = $category->getId() ?? null;

        if (!$categoryId) {
            return null;
        }

        $numberOfProducts = $collection->getSize();
        $storeId = $collection->getStoreId();

        $monitorRequest = $this->monitorRequestFactory->create();
        $monitorRequest->setCategory($category);
        $monitorRequest->setNumberOfProducts($numberOfProducts);
        $monitorRequest->setStoreId($storeId);

        return $monitorRequest;
    }
}
