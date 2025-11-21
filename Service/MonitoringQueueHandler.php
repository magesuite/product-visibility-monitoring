<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Service;

class MonitoringQueueHandler implements \MageSuite\Queue\Api\Queue\HandlerInterface
{
    public function __construct(
        protected \MageSuite\ProductVisibilityMonitoring\Api\MonitorInterface $monitor,
        protected \MageSuite\ProductVisibilityMonitoring\Model\MonitorRequestFactory $monitorRequestFactory,
        protected \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
    ) {}

    /**
     * @param array $data
     * [
     *   'category_id' => int,
     *   'number_of_products' => int,
     *   'store_id' => int,
     * ]
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute($data)
    {
        $categoryId = $data[\MageSuite\ProductVisibilityMonitoring\Service\AddToMonitoringQueue::QUEUE_PAYLOAD_KEY_CATEGORY_ID];
        $category = $this->categoryRepository->get($categoryId);

        /** @var \MageSuite\ProductVisibilityMonitoring\Model\MonitorRequest $monitorRequest */
        $monitorRequest = $this->monitorRequestFactory->create();
        $monitorRequest->setCategory($category);
        $monitorRequest->setNumberOfProducts($data[\MageSuite\ProductVisibilityMonitoring\Service\AddToMonitoringQueue::QUEUE_PAYLOAD_KEY_NUMBER_OF_PRODUCTS]);
        $monitorRequest->setStoreId($data[\MageSuite\ProductVisibilityMonitoring\Service\AddToMonitoringQueue::QUEUE_PAYLOAD_KEY_STORE_ID]);

        $this->monitor->run($monitorRequest);
    }
}
