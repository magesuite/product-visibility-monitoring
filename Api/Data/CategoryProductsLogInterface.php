<?php

declare(strict_types=1);

namespace MageSuite\ProductVisibilityMonitoring\Api\Data;

interface CategoryProductsLogInterface
{
    public function getLogId(): ?int;

    public function setLogId(?int $categoryProductsLogId): void;

    public function getCategoryId(): ?int;

    public function setCategoryId(?int $categoryId): void;

    public function getNumberOfProducts(): ?int;

    public function setNumberOfProducts(?int $numberOfProducts): void;

    public function getCreatedAt(): ?string;

    public function setCreatedAt(?string $createdAt): void;
}
