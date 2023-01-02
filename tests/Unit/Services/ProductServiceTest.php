<?php

namespace Tests\Unit\Services;

use App\Http\Requests\GetProductRequest;
use App\Models\Discount;
use App\Models\Product;
use App\Repositories\Discount\DiscountRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Suites\ServiceTestSuite;

/**
 * Class ProductServiceTest
 * @package Tests\Unit\Services
 * @coversDefaultClass \App\Services\ProductService
 */
class ProductServiceTest extends ServiceTestSuite
{
    use WithFaker;

    const CURRENCY = 'EUR';
    const PERCENT_SYMBOL = '%';

    private MockObject|ProductService $service;
    private MockObject|ProductRepositoryInterface $productRepository;
    private MockObject|DiscountRepositoryInterface $discountRepository;
    private MockObject|GetProductRequest $request;

    /**
     * @param array $methods
     * @return void
     */
    public function setService(array $methods = []): void
    {
        $this->productRepository = $this->createMock(ProductRepositoryInterface::class);
        $this->discountRepository = $this->createMock(DiscountRepositoryInterface::class);
        $this->request = $this->createMock(GetProductRequest::class);
        $this->service = $this->getMockBuilder(ProductService::class)
            ->onlyMethods($methods)
            ->setConstructorArgs([
                $this->productRepository,
                $this->discountRepository
            ])
            ->getMock();
    }

    /**
     * @test
     * @covers ::get
     * @covers ::__construct
     */
    public function it_should_return_all_products_when_has_category_discount()
    {
        $this->setService(['getProductDiscount']);

        $product1 = Product::factory()->make(['category' => 'boots', 'price' => 50000]);
        $product2 = Product::factory()->make(['category' => 'sandals', 'price' => 60000]);
        $discount = Discount::factory()->make(['type' => 'category', 'key' => 'boots', 'value' => 30]);
        $expected = [
            'products' => [
                [
                    ...$product1->toArray(),
                    'price' => [
                        "original" => $product1->price,
                        "final" => 35000,
                        "discount_percentage" => 30 . self::PERCENT_SYMBOL,
                        "currency" => self::CURRENCY
                    ]
                ],
                [
                    ...$product2->toArray(),
                    'price' => [
                        "original" => $product2->price,
                        "final" => 60000,
                        "discount_percentage" => null,
                        "currency" => self::CURRENCY
                    ]
                ]
            ]
        ];

        $this->productRepository
            ->expects($this->once())
            ->method('getByFilter')
            ->willReturn(collect([$product1, $product2]));
        $this->service
            ->expects($this->exactly(2))
            ->method('getProductDiscount')
            ->withConsecutive([$product1->toArray()])
            ->willReturnOnConsecutiveCalls($discount);

        $this->assertEquals($expected, $this->service->get($this->request));
    }

    /**
     * @test
     * @covers ::get
     * @covers ::__construct
     */
    public function it_should_return_all_products_when_has_sku_discount()
    {
        $this->setService(['getProductDiscount']);

        $product1 = Product::factory()->make(['sku' => '000003', 'price' => 50000]);
        $product2 = Product::factory()->make(['sku' => '000005', 'price' => 60000]);
        $discount = Discount::factory()->make(['type' => 'sku', 'key' => '000003', 'value' => 15]);
        $expected = [
            'products' => [
                [
                    ...$product1->toArray(),
                    'price' => [
                        "original" => $product1->price,
                        "final" => 42500,
                        "discount_percentage" => 15 . self::PERCENT_SYMBOL,
                        "currency" => self::CURRENCY
                    ]
                ],
                [
                    ...$product2->toArray(),
                    'price' => [
                        "original" => $product2->price,
                        "final" => 60000,
                        "discount_percentage" => null,
                        "currency" => self::CURRENCY
                    ]
                ]
            ]
        ];

        $this->productRepository
            ->expects($this->once())
            ->method('getByFilter')
            ->willReturn(collect([$product1, $product2]));
        $this->service
            ->expects($this->exactly(2))
            ->method('getProductDiscount')
            ->withConsecutive([$product1->toArray()])
            ->willReturnOnConsecutiveCalls($discount);

        $this->assertEquals($expected, $this->service->get($this->request));
    }

    /**
     * @test
     * @covers ::getProductDiscount
     */
    public function it_should_return_discount_for_product()
    {
        $this->setService();

        $product = Product::factory()->make(['sku' => '000003', 'price' => 50000]);
        $discount1 = Discount::factory()->make(['type' => 'sku', 'key' => '000003', 'value' => 20]);
        $discount2 = Discount::factory()->make(['type' => 'sku', 'key' => '000003', 'value' => 15]);

        $this->discountRepository
            ->expects($this->once())
            ->method('getTypes')
            ->willReturn(collect(['category', 'sku']));
        $this->discountRepository
            ->expects($this->exactly(2))
            ->method('get')
            ->willReturn(collect([$discount1, $discount2]));

        $this->assertEquals($discount1, $this->service->getProductDiscount($product->toArray()));
    }
}
