<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Model;

class CountProductsInCategory implements \MageSuite\ProductVisibilityMonitoring\Api\CountProductsInCategoryInterface
{
    protected \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory;

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    public function execute(\Magento\Catalog\Api\Data\CategoryInterface $category): int
    {
        $collection = $this->collectionFactory->create();
        $collection->addCategoryFilter($category);

        return $collection->getSize();
    }
}
