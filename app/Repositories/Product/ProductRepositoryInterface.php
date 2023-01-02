<?php

namespace App\Repositories\Product;

use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    /**
     * @param array|null $filter
     * @return Collection
     */
    public function getByFilter(?array $filter = []): Collection;

    /**
     * @param array $product
     * @return bool
     */
    public function create(array $product): bool;

    /**
     * @param array $product
     * @return bool
     */
    public function update(array $product): bool;
}
