<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::updateOrCreate([
            'sku' => '000001',
            'name' => 'BV Lean leather ankle boots',
            "category" => "boots",
            "price" => 89000
        ]);
        Product::updateOrCreate([
            'sku' => '000002',
            'name' => 'BV Lean leather ankle boots',
            "category" => "boots",
            "price" => 99000
        ]);
        Product::updateOrCreate([
            'sku' => '000003',
            'name' => 'Ashlington leather ankle boots',
            "category" => "boots",
            "price" => 71000
        ]);
        Product::updateOrCreate([
            'sku' => '000004',
            'name' => 'Naima embellished suede sandals',
            "category" => 'sandals',
            "price" => 79500
        ]);
        Product::updateOrCreate([
            'sku' => '000005',
            'name' => 'Nathane leather sneakers',
            "category" => 'sneakers',
            "price" => 59000
        ]);
    }
}
