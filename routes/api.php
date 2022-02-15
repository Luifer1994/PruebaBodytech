<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



//Rutas protegidas
Route::group(['middleware' => 'auth:sanctum'], function () {
    //Productos
    Route::controller(ProductController::class)->group(function () {
        Route::get('products-list{limit?}', 'index');
        Route::post('products-store', 'store');
        Route::put('products-update/{id}', 'update');
    });
    //Carrito
    Route::controller(CartController::class)->group(function () {
        Route::post('cart-store', 'store');
    });
    //Usuarios
    Route::controller(UserController::class)->group(function () {
        Route::get('user-logout', 'logout');
        Route::post('user-store-for-admin', 'storeAdmin');
    });
});
//Usuarios no protegidas
Route::controller(UserController::class)->group(function () {
    Route::post('user-store', 'store');
    Route::post('/user-login', 'login');
});