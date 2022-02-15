<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $request["limit"] ? $limit = $request["limit"] : $limit = 10;
        $products = Product::paginate($limit);

        return response()->json([
            "res" => true,
            "data" => $products
        ]);
    }
}