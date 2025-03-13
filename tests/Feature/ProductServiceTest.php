<?php

namespace Tests\Feature;

use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testSingletons(): void
    {
        $productService = $this->app->make(ProductService::class);
        self::assertInstanceOf(ProductService::class, $productService);
    }
}
