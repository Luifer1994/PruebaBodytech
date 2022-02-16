<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
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

    public function report(ReportRequest $request)
    {
        $sales = Sale::select(
            'user_id as client_id',
            'users.name as name_client',
            'detail_sales.product_id',
            'products.name as name_product',
            'detail_sales.quantity',
            'sales.created_at',
            'sales.total',

        )
            ->join('users', 'users.id', '=', 'sales.user_id')
            ->join('detail_sales', 'detail_sales.sale_id', '=', 'sales.id')
            ->join('products', 'products.id', '=', 'detail_sales.product_id')
            ->whereBetween('sales.created_at', [$request->start_date, $request->finish_date])
            ->get();

        return response()->json([
            'res' => true,
            'data' => $sales
        ]);
    }
}