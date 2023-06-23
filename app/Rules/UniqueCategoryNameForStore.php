<?php

namespace App\Rules;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueCategoryNameForStore implements ValidationRule
{
    protected $storeId;
    protected $excludeCategoryId;

    public function __construct($storeId, $excludeCategoryId = null)
    {
        $this->storeId = $storeId;
        $this->excludeCategoryId = $excludeCategoryId;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // if (Category::where('store_id', $this->storeId)
        //     ->where('name', $value)
        //     ->exists()) {
        //     $fail('The Name Is Already Used');
        // }

        $query = Category::where('store_id', $this->storeId)
            ->where('name', $value);

        if ($this->excludeCategoryId) {
            $query->where('id', '!=', $this->excludeCategoryId);
        }
        if ($query->exists()) {
            $fail('The Name Field Must Be Unique');
        }

    }
}
