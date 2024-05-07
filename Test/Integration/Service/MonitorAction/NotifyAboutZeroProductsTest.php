<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Test\Integration\Service\MonitorAction\CategoryZeroProducts;

class NotifyAboutZeroProductsTest extends \PHPUnit\Framework\TestCase
{
    protected ?\MageSuite\ProductVisibilityMonitoring\Service\MonitorAction\NotifyAboutZeroProducts $service = null;

    protected function setUp(): void
    {
        $objectManager = \Magento\TestFramework\ObjectManager::getInstance();
        $this->service = $objectManager->get(\MageSuite\ProductVisibilityMonitoring\Service\MonitorAction\NotifyAboutZeroProducts::class);
    }

    /**
     * @magentoDataFixture Magento/Catalog/_files/category.php
     */
    public function testExecuteEmptyCategoryWithExpectedNotEmpty()
    {
        $request = $this->prepareRequest(0);

        $this->assertFalse($this->service->execute($request));
    }

    /**
     * @magentoConfigFixture default_store product_visibility_monitoring/notifications/categories_with_expected_zero_products 333
     * @magentoDataFixture Magento/Catalog/_files/category.php
     */
    public function testExecuteEmptyCategoryWithExpectedEmpty()
    {
        $request = $this->prepareRequest(0);

        $this->assertTrue($this->service->execute($request));
    }

    /**
     * @magentoDataFixture Magento/Catalog/_files/category.php
     */
    public function testExecuteNotEmptyCategoryWithExpectedNotEmpty()
    {
        $request = $this->prepareRequest(5);

        $this->assertTrue($this->service->execute($request));
    }

    /**
     * @magentoConfigFixture default_store product_visibility_monitoring/notifications/categories_with_expected_zero_products 333
     * @magentoDataFixture Magento/Catalog/_files/category.php
     */
    public function testExecuteNotEmptyCategoryWithExpectedEmpty()
    {
        $request = $this->prepareRequest(5);

        $this->assertFalse($this->service->execute($request));
    }

    /**
     * @magentoConfigFixture default_store product_visibility_monitoring/notifications/excluded_categories 333
     * @magentoDataFixture Magento/Catalog/_files/category.php
     */
    public function testExecuteNotEmptyCategoryWithExcluded()
    {
        $request = $this->prepareRequest(5);

        $this->assertTrue($this->service->execute($request));
    }

    /**
     * @magentoConfigFixture default_store product_visibility_monitoring/notifications/excluded_categories 333
     * @magentoDataFixture Magento/Catalog/_files/category.php
     */
    public function testExecuteEmptyCategoryWithExcluded()
    {
        $request = $this->prepareRequest(0);

        $this->assertTrue($this->service->execute($request));
    }

    protected function prepareRequest(int $numberOfProducts): \MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest
    {
        $request = $this->createMock(\MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest::class);
        $request->method('getCategoryId')->willReturn(333);
        $request->method('getNumberOfProducts')->willReturn($numberOfProducts);
        $request->method('getStoreId')->willReturn(1);

        return $request;
    }
}
