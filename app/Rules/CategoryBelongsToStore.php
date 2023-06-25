<?php

namespace App\Rules;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CategoryBelongsToStore implements ValidationRule
{
    protected $category_id;
    protected $store_id;

    public function __construct($category_id, $store_id)
    {
        $this->category_id = $category_id;
        $this->store_id = $store_id;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $category = Category::findOrFail($this->category_id);

        if ($category->store_id != $this->store_id) {
            $fail("The Selected Category Doesn't Belong To Your Store");
        }
    }
}
