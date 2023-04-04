<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IngredientTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * A basic unit test example.
     */
    public function test_order_is_presisted_to_database(): void
    {
        $requestPayload = [
            'customerName' => "john doe",
            'products' => [
                [
                    'id' => 1,
                    'quantity' => 2
                ]
            ]
        ];
        $this->post('/api/order', $requestPayload);
        $this->assertDatabaseHas('orders', [
            'customerName' => "john doe"
        ]);

        $this->assertDatabaseHas('order_products', [
            'order_id' => 1,
            'product_id' => 1,
            'quantity' => 2
        ]);
    }

    public function test_stock_was_updated() : void
    {
        $requestPayload = [
            'customerName' => "john doe",
            'products' => [
                [
                    'id' => 1,
                    'quantity' => 2
                ]
            ]
        ];

        $this->post('/api/order', $requestPayload);

        //testing that beef stock was updated correctly
        $this->assertDatabaseHas('ingredients', [
            'currentStock' => 19700,
            'topStock' => 20000
        ]);

        //testing that cheese stock was updated correctly
        $this->assertDatabaseHas('ingredients', [
            'currentStock' => 4940,
            'topStock' => 5000
        ]);

        //testing that onion stock was updated correctly
        $this->assertDatabaseHas('ingredients', [
            'currentStock' => 960,
            'topStock' => 1000
        ]);
    }
}
