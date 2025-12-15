<?php

namespace App\Http\Controllers\_superadmin;

use App\Http\Controllers\Controller;
// use App\Models\Product;
// use App\Models\ProductCategory;
// use Illuminate\Http\Request;

class SuperadminProductController extends Controller
{
    public function index()
    {
        $title = 'Manajemen Produk';

        // Data dummy sementara, nanti diganti dengan query Product
        $products = collect([
            (object)[
                'id' => 1,
                'name' => 'Tas Gucci Original',
                'category' => (object)['name' => 'Fashion'],
                'submiter' => (object)['name' => 'Traveler A'],
                'price' => 15000000,
                'status' => 'active',
                'approval' => 'approved',
            ],
            (object)[
                'id' => 2,
                'name' => 'Sneakers Nike Air Jordan',
                'category' => (object)['name' => 'Olahraga'],
                'submiter' => (object)['name' => 'Traveler B'],
                'price' => 2800000,
                'status' => 'inactive',
                'approval' => 'pending',
            ],
        ]);

        return view('_superadmin.products.index', compact('title', 'products'));
    }
}