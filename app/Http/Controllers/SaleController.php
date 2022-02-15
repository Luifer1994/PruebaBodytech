<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function store()
    {

        if (Auth::user()->cart->count() > 0) {
            $newSale = new Sale();
            //Ejecuta el observer para agregar el detalle de la venta
            if ($newSale->save()) {
                return response()->json([
                    'res' => true,
                    'message' => 'Registro exitoso',
                    'data' => $newSale,
                ], 200);
            } else {
                return response()->json([
                    'res' => false,
                    'message' => 'Error al guardar registro',
                ], 400);
            }
        } else {
            return response()->json([
                'res' => false,
                'message' => 'No hay productos en tu carrito',
            ], 400);
        }
    }
}