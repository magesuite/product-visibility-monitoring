<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Api;

interface NotificationInterface
{
    public function send(\MageSuite\ProductVisibilityMonitoring\Model\NotificationRequest $notificationRequest): bool;
}
