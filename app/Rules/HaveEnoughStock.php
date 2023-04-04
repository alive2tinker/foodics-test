<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;

class HaveEnoughStock implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $enoughStock = true;
        try{
            foreach($value as $oproduct){
                $product = Product::find($oproduct['id']);
                Log::debug('product info', [
                    'product' => $product,
                    'product_id' => $oproduct['id']
                ]);
                foreach($product->ingredients as $ingredient){
                    Log::debug('ingredient info', [
                        'ingredient' => $ingredient
                    ]);
                    $enoughStock = $enoughStock + (($oproduct['quantity'] * $ingredient->quantity) <= $ingredient->ingredient->currentStock);
                }
            }
        }catch (\Exception $e){
            Log::debug('Stock exception', [
                'e' => $e
            ]);
            $enoughStock = false;
        }

        if(!$enoughStock)
            $fail("we don't have enough stock for :attribute");
    }
}
