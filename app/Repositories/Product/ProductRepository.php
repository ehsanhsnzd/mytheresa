<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Support\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        private Product $model
    ){}

    /**
     * @param array|null $filter
     * @return Collection
     */
    public function getByFilter(?array $filter = []): Collection
    {
        return $this->model
            ->all()
            ->when(isset($filter['category']),
                fn (Collection $query) => $query->where('category', $filter['category']))
            ->when(isset($filter['priceLessThan']),
                fn (Collection $query) => $query->where('price', '<', $filter['priceLessThan']));
    }

    /**
     * @param array $product
     * @return bool
     */
    public function create(array $product): bool
    {
        // TODO: Implement create() method.
    }

    /**
     * @param array $product
     * @return bool
     */
    public function update(array $product): bool
    {
        // TODO: Implement update() method.
    }
}
