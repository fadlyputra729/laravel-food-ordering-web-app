<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use \App\Http\Controllers\HistoryOrderController;
use \App\Http\Controllers\HomeController;

Route::get('home/{type}', [HomeController::class, 'filter']);
Route::get('/', [HomeController::class, 'index'])->name('home.index');

Auth::routes();

Route::get('logout', [LoginController::class, 'logout']);

Route::get('updatefood/{food}', [FoodController::class, 'getForUpdate'])->middleware('auth');
Route::get('food/viewfood', [FoodController::class, 'adminIndex'])->middleware('auth');
Route::resource('food', FoodController::class)->middleware('auth');

Route::middleware(['auth'])->group(function () {
  Route::get('order/{id}/print', [OrderController::class, 'print'])->name('order.print');
  Route::resource('order', OrderController::class);

  Route::post('addToCart', [OrderController::class, 'updateCart']);
  Route::delete('cart/remove/{food_id}', [OrderController::class, 'removeFromCart']);
  Route::post('cart/placeorder', [OrderController::class, 'placeOrder']);
  Route::view('cart', 'cart');

  Route::resource('history-order', HistoryOrderController::class);
});

Route::resource('user', UserController::class);


