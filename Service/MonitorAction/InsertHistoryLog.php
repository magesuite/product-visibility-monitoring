<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Service\MonitorAction;

class InsertHistoryLog implements ActionInterface
{
    protected \MageSuite\ProductVisibilityMonitoring\Api\CategoryProductsLogRepositoryInterface $logRepository;
    protected \MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsLogFactory $logFactory;
    protected \MageSuite\ProductVisibilityMonitoring\Service\MonitorAction\InsertHistoryLog\CanInsertLog $canInsertLog;
    protected bool $isEnabled;

    public function __construct(
        \MageSuite\ProductVisibilityMonitoring\Api\CategoryProductsLogRepositoryInterface $logRepository,
        \MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsLogFactory $logFactory,
        \MageSuite\ProductVisibilityMonitoring\Service\MonitorAction\InsertHistoryLog\CanInsertLog $canInsertLog,
        bool $isEnabled = true
    ) {
        $this->logRepository = $logRepository;
        $this->logFactory = $logFactory;
        $this->canInsertLog = $canInsertLog;
        $this->isEnabled = $isEnabled;
    }

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
