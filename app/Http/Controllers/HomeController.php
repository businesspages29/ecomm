<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $brands = Brand::all();
        $productQuery = Product::query();
        $inputs = request()->only('brand', 'search');
        if (request()->has('brand')) {
            $productQuery->whereHas('brand', function ($query) use ($inputs) {
                $query->where('slug', $inputs['brand']);
            });
        }

        if (request()->has('search')) {
            $productQuery->where('name', 'like', '%'.$inputs['search'].'%');
        }

        $products = $productQuery->get();

        return view('home', compact('brands', 'products'));
    }
}
