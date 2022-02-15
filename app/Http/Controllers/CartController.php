<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function store(CartRequest $request)
    {
        $itemCart = Cart::where('product_id', $request->product_id)
            ->where('user_id', Auth::user()->id)->first();
        if ($itemCart) {
            $itemCart->quantity = $itemCart->quantity + $request->quantity;
            if ($itemCart->update()) {
                return response()->json([
                    'res' => true,
                    'message' => 'Producto agregado con exito'
                ], 200);
            } else {
                return response()->json([
                    'res' => false,
                    'message' => 'Error al agregar el producto al carrito'
                ], 400);
            }
        }
        $addCart = new Cart();
        $addCart->user_id       = Auth::user()->id;
        $addCart->product_id    = $request->product_id;
        $addCart->quantity      = $request->quantity;
        if ($addCart->save()) {
            return response()->json([
                'res' => true,
                'message' => 'Producto agregado con éxito'
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'message' => 'Error al agregar el producto al carrito'
            ], 400);
        }
    }

    public function destroy($product_id)
    {
        $itemCart = Cart::where('product_id', $product_id)
            ->where('user_id', Auth::user()->id)->first();

        if ($itemCart) {
            if ($itemCart->delete()) {
                return response()->json([
                    'res' => true,
                    'message' => 'Producto eliminado con éxito'
                ], 200);
            } else {
                return response()->json([
                    'res' => false,
                    'message' => 'Error al eliminar el producto al carrito'
                ], 400);
            }
        } else {
            return response()->json([
                'res' => false,
                'message' => 'El producto enviado no está agregado en el carrito'
            ], 400);
        }
    }

    public function detail()
    {
        $data = Cart::select('carts.product_id', 'carts.quantity', 'products.name', 'products.price')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->where('carts.user_id', Auth::user()->id)->get();

        return response()->json([
            'res' => true,
            'data' => $data
        ]);
    }
}