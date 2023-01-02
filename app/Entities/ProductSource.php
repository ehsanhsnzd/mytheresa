<?php

namespace App\Entities;

use App\Models\Discount;
use App\Models\Product;

final class ProductSource
{
    const TO_PERCENT = 100;
    const CURRENCY = 'EUR';
    const PERCENT_SYMBOL = '%';

    public function __construct(
        private Product   $product,
        private ?Discount $discount,
    ){}

    public function getSku(): string
    {
        return $this->product->sku;
    }

    public function getName(): string
    {
        return $this->product->name;
    }

    public function getCategory(): string
    {
        return $this->product->category;
    }

    public function getFinalPrice(): int
    {
        return $this->discount ?
            $this->product->price - (int)($this->product->price * ($this->discount?->value / self::TO_PERCENT))
            : $this->product->price;
    }

    public function getDiscountPercentage(): ?string
    {
        return $this->discount?->value ? $this->discount?->value . self::PERCENT_SYMBOL : null;
    }

    public function getPrice(): array
    {
        return [
            "original" => $this->product->price,
            "final" => $this->getFinalPrice(),
            "discount_percentage" => $this->getDiscountPercentage(),
            "currency" => self::CURRENCY
        ];
    }

    public function toArray(): array
    {
        return [
            'sku' => $this->getSku(),
            'name' => $this->getName(),
            'category' => $this->getCategory(),
            'price' => $this->getPrice(),
        ];
    }
}
