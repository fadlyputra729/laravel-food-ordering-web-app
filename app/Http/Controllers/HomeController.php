<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function index()
  {
    if (request()->has('asc')) {
      if (request()->asc == 'true') {
        $foods = Food::orderBy('price')->orderBy('name')->paginate(12);
      }
      if (request()->asc == 'false') {
        $foods = Food::orderBy('price', 'DESC')->orderBy('name')->paginate(12);
      }
    } else {
      $foods = Food::paginate(12);
    }
    return view('food.home', ['foods' => $foods]);
  }

  public function filter($type)
  {
    $foods = Food::where('type', '=', $type);

    if (request()->has('asc')) {
      if (request()->asc == 'true') {
        $sorted = $foods->orderBy('price');
      }
      if (request()->asc == 'false') {
        $sorted = $foods->orderBy('price', 'DESC');
      }
    } else {
      $sorted = $foods;
    }
    return view('food.home', ['foods' => $foods->paginate(12)]);
  }
}
