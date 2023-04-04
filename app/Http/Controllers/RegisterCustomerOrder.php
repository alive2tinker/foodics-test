<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class RegisterCustomerOrder extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(OrderRequest $request)
    {
        $order = Order::create([
            'customerName' => $request->input('customerName')
        ]);

        foreach($request->input('products') as $product){
            $order->products()->create([
                'product_id' => $product['id'],
                'quantity' => $product['quantity']
            ]);
        }


        return response()->json('order created successfully', 200);
    }
}
