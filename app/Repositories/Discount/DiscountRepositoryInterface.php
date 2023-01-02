<?php

namespace App\Repositories\Discount;

use Illuminate\Support\Collection;

interface DiscountRepositoryInterface
{
    /**
     * @return Collection
     */
    public function get(): Collection;

    /**
     * @return Collection
     */
    public function getTypes(): Collection;

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
