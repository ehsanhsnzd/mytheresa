<?php

namespace Database\Seeders;

use App\Models\Discount;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Discount::updateOrCreate([
            'type' => 'category',
            'key' => 'boots',
            'value' => '30',
        ]);
        Discount::updateOrCreate([
            'type' => 'sku',
            'key' => '000003',
            'value' => '15',
        ]);
    }
}
