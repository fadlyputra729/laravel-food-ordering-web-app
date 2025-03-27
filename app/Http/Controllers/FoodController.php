<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Order;
use App\Services\CheckoutService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class FoodController extends Controller
{
  public function index()
  {
    $foods = Food::orderBy('id', 'desc')->paginate(10);
    return view('food.viewfood', ['foods' => $foods]);
  }

  public function create()
  {
    return view('food.addfood');
  }

  public function store(Request $food)
  {
    if (!$food->hasFile('picture')) {
      return redirect()->back()->withErrors(['picture' => 'No file uploaded.']);
    }

    $food->validate([
      'name' => 'required | unique:food',
      'description' => 'required',
      'price' => 'required',
      'type' => 'required',
      'stock' => 'required|integer',
      'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $picturePath = $food->file('picture')->store('img/', 'public');

    $foodData = Food::create([
      'name' => $food->input('name'),
      'description' => $food->input('description'),
      'price' => $food->input('price'),
      'type' => $food->input('type'),
      'stock' => $food->input('stock'),
      'picture' => $picturePath,
    ]);

    $newFileName = str_replace(' ', '-', strtolower($foodData->name)) . '.' . $food->file('picture')->extension();
    $newFilePath = 'menu/' . $newFileName;

    Storage::disk('public')->move($picturePath, $newFilePath);

    $foodData->picture = 'storage/' . $newFilePath;
    $foodData->save();

    return redirect()->route('food.index');
  }

  public function update(Request $food, $id)
  {
    // Validate the request
    $food->validate([
      'name' => [
        'required',
        Rule::unique('food')->ignore($id),
      ],
      'description' => 'required',
      'price' => 'required',
      'type' => 'required',
      'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Allow nullable for the picture
    ]);

    $existingFood = Food::find($id);

    if (!$existingFood) {
      return redirect()->back()->withErrors(['food' => 'Food item not found.']);
    }

    $picturePath = $existingFood->picture;
    if ($food->hasFile('picture')) {
      $uploadedPicturePath = $food->file('picture')->store('img/', 'public');
      $newFileName = str_replace(' ', '-', strtolower($food['name'])) . '.' . $food->file('picture')->extension();
      $newFilePath = 'menu/' . $newFileName;
      Storage::disk('public')->move($uploadedPicturePath, $newFilePath);
      $picturePath = 'storage/' . $newFilePath;
    }

    // Update the food item
    $existingFood->update([
      'name' => $food['name'],
      'description' => $food['description'],
      'price' => $food['price'],
      'type' => $food['type'],
      'stock' => $food['stock'],
      'picture' => $picturePath,
    ]);

    return redirect()->route('food.index');
  }

  public function show($id)
  {
    $food = Food::findOrFail($id);
    return view('food.show', ['food' => $food]);
  }

  public function edit($id)
  {
    $food = Food::findOrFail($id);
    return view('food.updatefood', ['food' => $food]);
  }
  public function destroy($id)
  {
    $food = Food::findOrFail($id);
    $food->delete();
    return redirect()->route('food.index');
  }
}
