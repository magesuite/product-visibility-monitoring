<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Plugin\Magento\Catalog\Block\Product\ListProduct;

class CategoryProductsMonitoring
{
    protected bool $alreadyUsed = false;

    public function __construct(
        protected \MageSuite\ProductVisibilityMonitoring\Api\AddToMonitoringQueueInterface $addToMonitoringQueue,
        protected \MageSuite\ProductVisibilityMonitoring\Model\MonitorRequestFactory $monitorRequestFactory,
        protected \Magento\Framework\Registry $registry,
    ) {}

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

        if (!$category) {
            return null;
        }

        $categoryId = $category->getId() ?? null;

        if (!$categoryId) {
            return null;
        }

        $monitorRequest = $this->monitorRequestFactory->create();
        $monitorRequest->setCategory($category);
        $monitorRequest->setCollection($collection);
        $monitorRequest->setStoreId($collection->getStoreId());

        return $monitorRequest;
    }
}
