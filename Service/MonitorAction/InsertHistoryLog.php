<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Service\MonitorAction;

class InsertHistoryLog implements ActionInterface
{
    public function __construct(
        protected \MageSuite\ProductVisibilityMonitoring\Api\CategoryProductsLogRepositoryInterface $logRepository,
        protected \MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsLogFactory $logFactory,
        protected \MageSuite\ProductVisibilityMonitoring\Service\MonitorAction\InsertHistoryLog\CanInsertLog $canInsertLog,
        protected bool $isEnabled = true
    ) {}

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    /**
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function execute(\MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest $monitorRequest): bool
    {
        if (!$this->canInsertLog->execute($monitorRequest)) {
            return false;
        }

        $this->insertLog($monitorRequest);

        return true;
    }

    /**
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function insertLog(\MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest $monitorRequest): void
    {

        /** @var \MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsLog $log */
        $log = $this->logFactory->create();

        $categoryId = $monitorRequest->getCategoryId();
        $log->setCategoryId($categoryId);

        $numberOfProducts = $monitorRequest->getNumberOfProducts();
        $log->setNumberOfProducts($numberOfProducts);

        $storeId = $monitorRequest->getStoreId();
        $log->setStoreId($storeId);

        $this->logRepository->save($log);
    }
}
