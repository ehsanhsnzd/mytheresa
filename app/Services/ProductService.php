<?php

namespace App\Services;

use App\Entities\ProductSource;
use App\Models\Discount;
use App\Models\Product;
use App\Repositories\Discount\DiscountRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductService
{
    public function __construct(
        private ProductRepositoryInterface  $productRepository,
        private DiscountRepositoryInterface $discountRepository,
    ){}

    /**
     * Get product buy filter
     * @param Request $request
     * @return array|null
     */
    public function get(Request $request): ?array
    {
        $products = $this->productRepository->getByFilter($request->all());

        $products = $products->map(fn(Product $product) =>
            (new ProductSource(
                $product,
                $this->getProductDiscount($product->toArray())
            ))->toArray())
            ->values()
            ?->toArray();

        return compact('products');
    }

    /**
     * Get highest discount for product
     * @param array $product
     * @return Discount|null
     */
    public function getProductDiscount(array $product): ?Discount
    {
        $discounts = $this->discountRepository
            ->getTypes()
            ->map(fn(string $type) => $this->discountRepository
                ->get()
                ->filter(fn (Discount $discount) => $type == $discount->type && $product[$type] === $discount->key)
            )->flatten();

        return $discounts->sortByDesc('value')->first();
    }
}
