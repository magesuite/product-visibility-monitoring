<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Model\Config\Source;

class Categories implements \Magento\Framework\Data\OptionSourceInterface
{
    public function __construct(
        protected \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $collectionFactory,
    ) {}

    public function toOptionArray(): array
    {
        $collection = $this->collectionFactory->create();

        $collection->addAttributeToSelect(\Magento\Catalog\Api\Data\CategoryInterface::KEY_NAME);
        $collection->addAttributeToSort(\Magento\Catalog\Api\Data\CategoryInterface::KEY_NAME);

        /** @var \Magento\Catalog\Model\Category $categories */
        $categories = $collection->getItems();

        $options = [];

        foreach ($categories as $category) {
            $categoryId = $category->getId();
            $label = sprintf('%s (ID: %s)', $category->getName(), $categoryId);

            $options[] = ['label' => $label, 'value' => $categoryId];
        }

        return $options;
    }
}
