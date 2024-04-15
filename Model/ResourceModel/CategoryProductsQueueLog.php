<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Model\ResourceModel;

class CategoryProductsQueueLog extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public const TABLE_NAME = 'category_products_queue_log';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, \MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsQueueLog::LOG_ID);
        $this->_useIsObjectNew = true;
    }
}
