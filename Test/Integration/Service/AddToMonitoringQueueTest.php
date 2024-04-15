<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Test\Integration\Service;

class AddToMonitoringQueueTest extends \PHPUnit\Framework\TestCase
{
    private const CATEGORY_ID = 333;

    protected ?\Magento\Framework\App\ObjectManager $objectManager = null;

    protected function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();
    }

    /**
     * @magentoConfigFixture default/product_visibility_monitoring/queue/min_interval_in_minutes 5
     * @magentoDataFixture Magento/Catalog/_files/category.php
     */
    public function testExecuteWithInterval()
    {
        $publisher = $this->createMock(\MageSuite\Queue\Service\Publisher::class);
        $publisher->expects($this->once())->method('publish');

        $service = $this->objectManager->create(
            \MageSuite\ProductVisibilityMonitoring\Service\AddToMonitoringQueue::class,
            ['publisher' => $publisher]
        );

        $monitorRequest = $this->getMonitorRequest();

        $this->assertTrue($service->execute($monitorRequest));
        $this->assertFalse($service->execute($monitorRequest));
    }

    /**
     * @magentoConfigFixture default/product_visibility_monitoring/queue/min_interval_in_minutes 0
     * @magentoDataFixture Magento/Catalog/_files/category.php
     */
    public function testExecuteWithoutInterval()
    {
        $publisher = $this->createMock(\MageSuite\Queue\Service\Publisher::class);
        $publisher->expects($this->exactly(2))->method('publish');

        $service = $this->objectManager->create(
            \MageSuite\ProductVisibilityMonitoring\Service\AddToMonitoringQueue::class,
            ['publisher' => $publisher]
        );

        $monitorRequest = $this->getMonitorRequest();

        $this->assertTrue($service->execute($monitorRequest));
        $this->assertTrue($service->execute($monitorRequest));
    }

    protected function getMonitorRequest(): \MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest
    {
        $category = $this->createMock(\Magento\Catalog\Model\Category::class);
        $category->method('getId')->willReturn(self::CATEGORY_ID);

        $monitorRequest = $this->objectManager->create(\MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest::class);
        $monitorRequest->setCategory($category);
        $monitorRequest->setStoreId(0);

        return $monitorRequest;
    }
}
