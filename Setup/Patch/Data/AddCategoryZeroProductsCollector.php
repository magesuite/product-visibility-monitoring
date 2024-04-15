<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Setup\Patch\Data;

class AddCategoryZeroProductsCollector implements \Magento\Framework\Setup\Patch\DataPatchInterface
{
    public const COLLECTOR_NAME = 'Products In Categories';

    protected \MageSuite\NotificationDashboard\Api\Data\CollectorInterfaceFactory $collectorFactory;
    protected \MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository;

    public function __construct(
        \MageSuite\NotificationDashboard\Api\Data\CollectorInterfaceFactory $collectorFactory,
        \MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository
    ) {
        $this->collectorFactory = $collectorFactory;
        $this->collectorRepository = $collectorRepository;
    }

    public function apply(): self
    {
        $collector = $this->collectorFactory->create();
        $collector->setName(self::COLLECTOR_NAME);
        $collector->setIsEnabled(1);
        $collector->setSeverity(\MageSuite\NotificationDashboard\Model\Source\Severity::SEVERITY_CRITICAL);
        $collector->setLimitOnDashboard(10);
        $collector->setAddAdminNotification(0);
        $collector->setVisibleOnDashboard(1);
        $collector->setIsStatic(0);

        $this->collectorRepository->save($collector);

        return $this;
    }

    public function getAliases(): array
    {
        return [];
    }

    public static function getDependencies(): array
    {
        return [];
    }
}
