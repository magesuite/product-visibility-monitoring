<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Model\ResourceModel;

class CategoryProductsNotificationLog extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public const TABLE_NAME = 'category_products_notification_log';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, \MageSuite\ProductVisibilityMonitoring\Model\CategoryProductsNotificationLog::NOTIFICATION_ID);
        $this->_useIsObjectNew = true;
    }
}
