<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Api\Data;

interface CategoryProductsNotificationLogInterface
{
    public function getNotificationId(): ?int;

    public function setNotificationId(?int $notificationId): void;

    public function getCategoryId(): ?int;

    public function setCategoryId(?int $categoryId): void;

    public function getCreatedAt(): ?string;

    public function setCreatedAt(?string $createdAt): void;
}
