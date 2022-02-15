<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



//Rutas protegidas
Route::group(['middleware' => 'auth:sanctum'], function () {
    //Rustas de acceso solo a usuarios admin
    Route::middleware(['isAdmin'])->group(function () {
        //Productos
        Route::controller(ProductController::class)->group(function () {
            Route::get('products-list{limit?}', 'index');
            Route::post('products-store', 'store');
            Route::put('products-update/{id}', 'update');
            Route::post('products-import', 'import');
        });
        //Registro de usuarios por admin
        Route::post('user-store-for-admin', [UserController::class, 'storeAdmin']);
    });
    //Carrito
    Route::controller(CartController::class)->group(function () {
        Route::post('cart-store', 'store');
        Route::delete('cart-destroy/{product_id}', 'destroy');
    });

    //Cerrar sesión
    Route::get('user-logout', [UserController::class, 'logout']);
});
//Usuarios no protegidas
Route::controller(UserController::class)->group(function () {
    Route::post('user-store', 'store');
    Route::post('/user-login', 'login');
});