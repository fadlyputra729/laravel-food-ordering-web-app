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

    public function sortByPrice($type)
    {
        if ($type) {
            $foods = Food::orderBy('price')->paginate(12);
        } else {
            $foods = Food::orderByDesc('price')->paginate(12);
        }

        return view('food.home', ['foods' => $foods]);
    }

    public function adminIndex()
    {
        $foods = Food::orderBy('id', 'desc')->paginate(10);
        return view('food.viewfood', ['foods' => $foods]);
    }

    public function show($id)
    {
        $food = Food::findOrFail($id);
        return view('food.show', ['food' => $food]);
    }

    public function getForUpdate($id)
    {
        $food = Food::findOrFail($id);
        return view('food.updatefood', ['food' => $food]);
    }

    public function destroy($id)
    {
        $food = Food::findOrFail($id);
        $food->delete();
        return redirect('/food/viewfood');
    }

    public function store(Request $food)
    {
        // Debugging: Check if file is uploaded
        if (!$food->hasFile('picture')) {
            return redirect()->back()->withErrors(['picture' => 'No file uploaded.']);
        }

        $food->validate([
            'name' => 'required | unique:food',
            'description' => 'required',
            'price' => 'required',
            'type' => 'required',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle file upload and store it in public/img/food_pictures directory
        $picturePath = $food->file('picture')->store('img/', 'public');

        $foodData = Food::create([
            'name' => $food->input('name'),
            'description' => $food->input('description'),
            'price' => $food->input('price'),
            'type' => $food->input('type'),
            'picture' => $picturePath, // Keep the original path for now
        ]);

        // Rename the uploaded file to match the food's name
        $newFileName = str_replace(' ', '-', strtolower($foodData->name)) . '.' . $food->file('picture')->extension();
        $newFilePath = 'menu/' . $newFileName;

        Storage::disk('public')->move($picturePath, $newFilePath);

        // Update the food record with the new file path
        $foodData->picture = 'storage/' . $newFilePath;
        $foodData->save();

        return redirect('/food/viewfood');
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

        // Retrieve the existing food item
        $existingFood = Food::find($id);

        if (!$existingFood) {
            return redirect()->back()->withErrors(['food' => 'Food item not found.']);
        }

        // Handle picture update
        $picturePath = $existingFood->picture; // Default to existing picture
        if ($food->hasFile('picture')) {
            // Store new picture
            $uploadedPicturePath = $food->file('picture')->store('img/', 'public');

            // Rename the uploaded file to match the food's name
            $newFileName = str_replace(' ', '-', strtolower($food['name'])) . '.' . $food->file('picture')->extension();
            $newFilePath = 'menu/' . $newFileName;

            Storage::disk('public')->move($uploadedPicturePath, $newFilePath);

            // Update the picture path
            $picturePath = 'storage/' . $newFilePath;
        }

        // Update the food item
        $existingFood->update([
            'name' => $food['name'],
            'description' => $food['description'],
            'price' => $food['price'],
            'type' => $food['type'],
            'picture' => $picturePath,
        ]);

        return redirect('/food/viewfood');
    }


}
