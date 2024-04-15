<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Test\Integration\Service\MonitorAction\InsertHistoryLog;

class InsertHistoryLogTest extends \PHPUnit\Framework\TestCase
{
    private const CATEGORY_ID = 333;

    protected ?\Magento\Framework\App\ObjectManager $objectManager = null;

    protected function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();
    }

    /**
     * @magentoConfigFixture default/product_visibility_monitoring/logs/min_interval_in_minutes 5
     * @magentoDataFixture Magento/Catalog/_files/category.php
     */
    public function testExecuteWithInterval()
    {
        $service = $this->objectManager->create(
            \MageSuite\ProductVisibilityMonitoring\Service\MonitorAction\InsertHistoryLog::class
        );

        $monitorRequest = $this->getMonitorRequest(5);

        $this->assertTrue($service->execute($monitorRequest));
        $this->assertFalse($service->execute($monitorRequest));
    }

    /**
     * @magentoConfigFixture default/product_visibility_monitoring/logs/min_interval_in_minutes 5
     * @magentoDataFixture Magento/Catalog/_files/category.php
     */
    public function testExecuteWithIntervalAndDifferentNumberOfProducts()
    {
        $service = $this->objectManager->create(
            \MageSuite\ProductVisibilityMonitoring\Service\MonitorAction\InsertHistoryLog::class
        );

        $monitorRequest = $this->getMonitorRequest(5);
        $this->assertTrue($service->execute($monitorRequest));

        $monitorRequest = $this->getMonitorRequest(3);
        $this->assertTrue($service->execute($monitorRequest));
    }

    /**
     * @magentoConfigFixture default/product_visibility_monitoring/logs/min_interval_in_minutes 0
     * @magentoDataFixture Magento/Catalog/_files/category.php
     */
    public function testExecuteWithoutInterval()
    {
        $service = $this->objectManager->create(
            \MageSuite\ProductVisibilityMonitoring\Service\MonitorAction\InsertHistoryLog::class
        );

        $monitorRequest = $this->getMonitorRequest(5);

        $this->assertTrue($service->execute($monitorRequest));
        $this->assertTrue($service->execute($monitorRequest));
    }

    protected function getMonitorRequest(int $numberOfProducts): \MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest
    {
        $category = $this->createMock(\Magento\Catalog\Model\Category::class);
        $category->method('getId')->willReturn(self::CATEGORY_ID);

        $monitorRequest = $this->objectManager->create(\MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest::class);
        $monitorRequest->setCategory($category);
        $monitorRequest->setNumberOfProducts($numberOfProducts);
        $monitorRequest->setStoreId(0);

        return $monitorRequest;
    }
}
