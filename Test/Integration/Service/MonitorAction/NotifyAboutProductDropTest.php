<?php /** @noinspection ObjectManagerInspection */

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Test\Integration\Service\MonitorAction;

use Magento\TestFramework\Fixture\DataFixture;
use MageSuite\ProductVisibilityMonitoring\Test\Fixture\CategoryProductsLog;

class NotifyAboutProductDropTest extends \PHPUnit\Framework\TestCase
{
    protected ?\MageSuite\ProductVisibilityMonitoring\Service\MonitorAction\NotifyAboutProductNumberAnomaly\DropDetector $dropDetector = null;

    protected function setUp(): void
    {
        $om = \Magento\TestFramework\ObjectManager::getInstance();
        $this->dropDetector = $om->get(\MageSuite\ProductVisibilityMonitoring\Service\MonitorAction\NotifyAboutProductNumberAnomaly\DropDetector::class);
    }

    #[DataFixture('Magento/Catalog/_files/category.php')]
    #[DataFixture(CategoryProductsLog::class, ['number_of_products' => 100])]
    #[DataFixture(CategoryProductsLog::class, ['number_of_products' => 105])]
    #[DataFixture(CategoryProductsLog::class, ['number_of_products' => 110])]
    public function testItDetectsDrop(): void
    {
        $request = $this->prepareRequest(4);
        $isDropDetected = $this->dropDetector->isDropDetected($request);
        $this->assertTrue($isDropDetected);

        $request = $this->prepareRequest(100);
        $isDropDetected = $this->dropDetector->isDropDetected($request);
        $this->assertFalse($isDropDetected);
    }

    #[DataFixture('Magento/Catalog/_files/category.php')]
    #[DataFixture(CategoryProductsLog::class, ['number_of_products' => 3])]
    public function testItDoesntDetectDropForSmallCategories(): void
    {
        $request = $this->prepareRequest(1);
        $isDropDetected = $this->dropDetector->isDropDetected($request);
        $this->assertFalse($isDropDetected);
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
