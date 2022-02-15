<?php

namespace App\Observers;

use App\Models\DetailSale;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;

class SaleObserver
{

    public function creating(Sale $sale)
    {
        $sale->user_id = Auth::user()->id;
        $data = Auth::user()->cart;
        foreach ($data as  $value) {
            $product        = Product::find($value->product_id);
            $sale->total    += $product->price * $value->quantity;
        }
    }

    public function created(Sale $sale)
    {
        $data = Auth::user()->cart;
        foreach ($data as  $value) {
            $newDetailSale = new DetailSale();
            $newDetailSale->product_id  = $value->product_id;
            $newDetailSale->quantity    = $value->quantity;
            $newDetailSale->sale_id     = $sale->id;
            $newDetailSale->save();
            $value->delete();
        };
    }
}