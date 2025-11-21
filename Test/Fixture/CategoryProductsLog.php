<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Test\Fixture;

class CategoryProductsLog implements \Magento\TestFramework\Fixture\RevertibleDataFixtureInterface
{
    public function __construct(
        protected \MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsLogFactory $categoryProductsLogFactory,
        protected \MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsLogRepository $categoryProductsLogRepository,
    ) {}

    public function apply(array $data = []): ?\Magento\Framework\DataObject
    {
        $log = $this->categoryProductsLogFactory->create();
        $log->setCategoryId($data[\MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsLog::CATEGORY_ID] ?? 333);
        $log->setStoreId($data[\MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsLog::STORE_ID] ?? 1);
        $log->setNumberOfProducts($data[\MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsLog::NUMBER_OF_PRODUCTS] ?? 10);
        $log->setCreatedAt($data[\MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsLog::CREATED_AT] ?? date('Y-m-d H:i:s'));

        try {
            $this->categoryProductsLogRepository->save($log);
        } catch (\Magento\Framework\Exception\AlreadyExistsException $e) {}

        return $log;
    }

    public function revert(\Magento\Framework\DataObject $data): void
    {
        $this->categoryProductsLogRepository->delete($data);
    }
}
