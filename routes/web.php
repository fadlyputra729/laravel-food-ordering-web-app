<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use \App\Http\Controllers\HistoryOrderController;

Route::get('/', [FoodController::class, 'index']);
Auth::routes();

Route::get('logout', [LoginController::class, 'logout']);

// food routes with policy
Route::get('updatefood/{food}', [FoodController::class, 'getForUpdate'])->middleware('auth');
Route::get('home', [FoodController::class, 'index']);
Route::get('home/{type}', [FoodController::class, 'filter']);
Route::get('food/viewfood', [FoodController::class, 'adminIndex'])->middleware('auth');

Route::view('food/addfood', 'food.addfood')->middleware('auth');
Route::resource('food', FoodController::class);

Route::middleware(['auth'])->group(function () {
  Route::resource('order', OrderController::class);

  Route::post('addToCart', [OrderController::class, 'updateCart']);
  Route::delete('cart/remove/{food_id}', [OrderController::class, 'removeFromCart']);
  Route::post('cart/placeorder', [OrderController::class, 'placeOrder']);
  Route::view('cart', 'cart');

  Route::resource('history-order', HistoryOrderController::class);
});

Route::resource('user', UserController::class);


