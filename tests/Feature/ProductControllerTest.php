<?php

namespace Tests\Feature;

use App\Models\Discount;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Product;
use Illuminate\Support\Arr;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    const CURRENCY = 'EUR';
    const PERCENT_SYMBOL = '%';

    /**
     * @test
     * @covers ::get
     */
    function it_should_return_products_data()
    {
        $product1 = Product::factory()->create(['category' => 'boots', 'price' => 89000]);
        $product2 = Product::factory()->create(['category' => 'boots', 'price' => 99000]);
        $product3 = Product::factory()->create(['sku' => '000003', 'category' => 'boots', 'price' => 71000]);
        $product4 = Product::factory()->create(['category' => 'sandals', 'price' => 79500]);
        $product5 = Product::factory()->create(['category' => 'sneakers', 'price' => 59000]);
        Discount::factory()->create(['type' => 'category', 'key' => 'boots', 'value' => 30]);
        Discount::factory()->create(['type' => 'sku', 'key' => '000003', 'value' => 15]);

        $expected = [
            'products' => [
                [
                    'name' => $product1->name,
                    'category' => $product1->category,
                    'sku' => (string)$product1->sku,
                    'price' => [
                        "original" => $product1->price,
                        "final" => 62300,
                        "discount_percentage" => 30 . self::PERCENT_SYMBOL,
                        "currency" => self::CURRENCY
                    ]
                ],
                [
                    'name' => $product2->name,
                    'category' => $product2->category,
                    'sku' => (string)$product2->sku,
                    'price' => [
                        "original" => $product2->price,
                        "final" => 69300,
                        "discount_percentage" => 30 . self::PERCENT_SYMBOL,
                        "currency" => self::CURRENCY
                    ]
                ],
                [
                    'name' => $product3->name,
                    'category' => $product3->category,
                    'sku' => (string)$product3->sku,
                    'price' => [
                        "original" => $product3->price,
                        "final" => 49700,
                        "discount_percentage" => 30 . self::PERCENT_SYMBOL,
                        "currency" => self::CURRENCY
                    ]
                ],
                [
                    'name' => $product4->name,
                    'category' => $product4->category,
                    'sku' => (string)$product4->sku,
                    'price' => [
                        "original" => $product4->price,
                        "final" => 79500,
                        "discount_percentage" => null,
                        "currency" => self::CURRENCY
                    ]
                ],
                [
                    'name' => $product5->name,
                    'category' => $product5->category,
                    'sku' => (string)$product5->sku,
                    'price' => [
                        "original" => $product5->price,
                        "final" => 59000,
                        "discount_percentage" => null,
                        "currency" => self::CURRENCY
                    ]
                ]
            ]
        ];
        $response = $this->get('products');

        $response->assertOk()->assertExactJson($expected);
    }

    /**
     * @test
     * @covers ::get
     */
    function it_should_return_products_when_category_filter()
    {
        Product::factory()->create(['category' => 'boots', 'price' => 89000]);
        Product::factory()->create(['category' => 'boots', 'price' => 99000]);
        Product::factory()->create(['category' => 'sandals', 'price' => 79500]);
        Product::factory()->create(['category' => 'sneakers', 'price' => 59000]);
        Discount::factory()->create(['type' => 'category', 'key' => 'boots', 'value' => 30]);
        Discount::factory()->create(['type' => 'sku', 'key' => '000003', 'value' => 15]);
        $product = Product::factory()->create(['sku' => '000003', 'category' => 'boots', 'price' => 71000]);

        $expected = [
            'products' => [
                [
                    'name' => $product->name,
                    'category' => $product->category,
                    'sku' => (string)$product->sku,
                    'price' => [
                        "original" => $product->price,
                        "final" => 49700,
                        "discount_percentage" => 30 . self::PERCENT_SYMBOL,
                        "currency" => self::CURRENCY
                    ]
                ]
            ]
        ];

        $response = $this->get('products?' . Arr::query(['category' => 'boots', 'priceLessThan' => 80000]));

        $response->assertOk()->assertJsonFragment($expected);
        $response->assertOk()->assertExactJson($expected);
    }
}
