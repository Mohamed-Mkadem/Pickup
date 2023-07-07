<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Sector;
use App\Models\State;
use Illuminate\Http\Request;

class ShoppingController extends Controller
{
    protected $brands;
    protected $sectors;
    protected $states;

    public function __construct()
    {
        $this->brands = Brand::get();
        $this->sectors = Sector::get();
        $this->states = State::with('cities')->get();
    }
    public function shopping()
    {
        $query = Product::query();
        $query->where('status', 'active');
        $query->whereHas('category', function ($subQuery) {
            $subQuery->where('status', 'active');
        });
        $query->whereHas('store', function ($subQuery) {
            $subQuery->where('status', 'published');
        });
        $query->orderBy('name', 'asc');
        $products = $query->with(['store', 'brand'])->paginate(20);
        return view('Client.shopping',
            [
                'products' => $products,
                'states' => $this->states,
                'sectors' => $this->sectors,
                'brands' => $this->brands,
            ]);
    }

    public function filter(Request $request)
    {

        $search = $request->search ?? '';
        $minPrice = $request->min_price ?? '';
        $maxPrice = $request->max_price ?? '';
        $brands = $request->brands ?? [];
        $sort = $request->sort ?? 'a-z';
        $sectors = $request->sectors ?? [];
        $min_rate = $request->min_rate ?? '';
        $max_rate = $request->max_rate ?? '';
        $state_id = $request->state_id ?? 'all';
        $city_id = $request->city_id ?? 'all';
        $query = Product::query();
        $query->where('status', 'active');
        $query->whereHas('category', function ($subQuery) {
            $subQuery->where('status', 'active');
        });
        $query->whereHas('store', function ($subQuery) {
            $subQuery->where('status', 'published');
        });

        if (!empty($min_rate)) {
            $query->whereHas('store', function ($subQuery) use ($min_rate) {
                $subQuery->where('rate', '>=', $min_rate);
            });
        }
        if (!empty($max_rate)) {
            $query->whereHas('store', function ($subQuery) use ($max_rate) {
                $subQuery->where('rate', '<=', $max_rate);
            });
        }
        if (!empty($sectors)) {
            $query->whereHas('store', function ($subQuery) use ($sectors) {
                $subQuery->whereIn('sector_id', $sectors);
            });
        }

        if ($state_id != 'all') {
            // $query->where('state_id', $state_id);
            // if ($city_id != 'all') {
            //     $query->where('city_id', $city_id);

            // }
            $query->whereHas('store', function ($subQuery) use ($state_id, $city_id) {
                $subQuery->where('state_id', $state_id);
            });
            if ($city_id != 'all') {
                $query->whereHas('store', function ($subQuery) use ($state_id, $city_id) {
                    $subQuery->where('city_id', $city_id);
                });

            }
        }
        if (!empty($brands)) {
            $query->whereIn('brand_id', $brands);
        }
        if (!empty($search)) {
            $query->where('name', 'like', "%$search%");
        }
        if (!empty($maxPrice)) {
            $query->where('price', '<=', $maxPrice);
        }
        if (!empty($minPrice)) {
            $query->where('price', '>=', $minPrice);
        }
        if ($sort == 'z-a') {
            $query->orderBy('name', 'desc');
        }
        if ($sort == 'a-z') {
            $query->orderBy('name', 'asc');
        }
        if ($sort == 'highest_sale_price') {
            $query->orderBy('price', 'desc');
        }
        if ($sort == 'lowest_sale_price') {
            $query->orderBy('price', 'asc');
        }
        $products = $query->with(['store', 'brand'])->paginate(20);
        return view('Client.shopping',
            [
                'products' => $products,
                'states' => $this->states,
                'sectors' => $this->sectors,
                'brands' => $this->brands,
            ]);
    }

}
