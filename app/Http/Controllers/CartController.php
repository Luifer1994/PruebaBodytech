<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(CartRequest $request)
    {
        $addCart = new Cart();
        $addCart->user_id       = 1;
        $addCart->product_id    = $request->product_id;
        $addCart->quantity      = $request->quantity;
        return $addCart;
    }
}