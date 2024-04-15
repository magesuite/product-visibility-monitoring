<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Api\Data;

interface CategoryProductsQueueLogInterface
{
    public function getLogId(): ?int;

    public function setLogId(?int $categoryProductsLogId): void;

    public function getCategoryId(): ?int;

    public function setCategoryId(?int $categoryId): void;

    public function getCreatedAt(): ?string;

    public function setCreatedAt(?string $createdAt): void;

    public function getStoreId(): ?int;

    public function setStoreId(?int $storeId): void;
}
