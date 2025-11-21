<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Model;

class CountProductsInCategory implements \MageSuite\ProductVisibilityMonitoring\Api\CountProductsInCategoryInterface
{
    public function __construct(
        protected \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory
    ) {}

    public function execute(\Magento\Catalog\Api\Data\CategoryInterface $category): int
    {
        $collection = $this->collectionFactory->create();
        $collection->addCategoryFilter($category);

        return $collection->getSize();
    }
}
