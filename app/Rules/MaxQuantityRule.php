<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxQuantityRule implements ValidationRule
{

    protected $productId;
    protected $errorMessages = [];

    public function __construct($productId)
    {
        $this->productId = $productId;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $product = Product::findOrFail($this->productId);
        if ($product->quantity < $value) {

            $fail("The Max Quantity Of The '{$product->name}' Is {$product->quantity}");
        }

        // $errors = [];
        // foreach ($this->cart as $cart_item) {
        //     $product = Product::findOrFail($cart_item['id']);
        //     if ($product->quantity < $cart_item['quantity']) {
        //         // $fail("The Max Quantity Of The '{$cart_item['name']}' Is {$product->quantity}");
        //         if (!in_array($product->id, $errors)) {
        //             $errors[$product->id] = [
        //                 'product_name' => $product->name,
        //                 'product_quantity' => $product->quantity,

        //             ];
        //         }
        //     }
        // }
        // if (!empty($errors)) {
        //     // dd($errors);
        //     echo 'Start Errors Array ';

        //     echo '<pre>';
        //     print_r($errors);
        //     echo '</pre>';
        //     echo 'End Errors Array ';
        //     echo '<------------------------ >';
        //     foreach ($errors as $error) {
        //         echo '<--------------- Start Error--------- >';

        //         echo '<pre>';
        //         print_r($error);
        //         echo '</pre>';
        //         echo '<--------------- End Error--------- >';
        //         // $fail('hamma');
        //         // $fail("The Max Quantity Of The '{$error['product_name']}' Is {$error['product_quantity']}");
        //     }
        // }

    }

}
