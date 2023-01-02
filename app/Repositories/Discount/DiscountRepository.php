<?php

namespace App\Repositories\Discount;

use App\Models\Discount;
use Illuminate\Support\Collection;

class DiscountRepository implements DiscountRepositoryInterface
{
    public function __construct(
        private Discount $model
    ){}

    /**
     * Get all discount
     * @return Collection
     */
    public function get(): Collection
    {
        return $this->model->all();
    }

    /**
     * Get types of discount
     * @return Collection
     */
    public function getTypes(): Collection
    {
        return $this->model->newQuery()
            ->groupBy('type')
            ->pluck('type');
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
