<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
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
        ], 200);
    }

    public function store(ProductRequest $request)
    {
        $newProduct = new Product();
        $newProduct->name = $request->name;
        $newProduct->price = $request->price;

        if ($newProduct->save()) {
            return response()->json([
                "res" => true,
                "message" => "Registro exitoso"
            ], 200);
        } else {
            return response()->json([
                "res" => false,
                "message" => "Error al guardar registro"
            ], 400);
        }
    }
}