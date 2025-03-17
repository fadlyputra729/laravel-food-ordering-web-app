<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Order;
use App\Services\CheckoutService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $orders = Order::where('user_id', $user_id)->orderBy('date', 'desc')->get();

        // To get total amount for each order:
        foreach ($orders as $order) {
            $total = 0.0;

            foreach ($order->food as $food) {
                $total += $food->price * $food->pivot->quantity;
            }

            $order->total = $total;
        }

        return view('order', ['orders' => $orders]);
    }

    public function create(Order $order)
    {
        $order->save();
    }

    public function addToOrder(Order $order)
    {
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        // For each food in the order:
        foreach ($order->food as $food) {
            // Remove from pivot table
            $order->food()->detach($food->id);
        }
        $order->delete();
        // $order->food()->detach($food_id);
        Session::flash('success', 'Berhasil menghapus pesanan dari history pesanan.');
        return redirect('/order');
    }

    public function updateCart(Request $req)
    {
        if (Auth::check()) {
            if (Session::get('cart') == null) {
                Session::put('cart', array());
            }
            // $food = Food::findOrFail($req['id']);
            // $order->food()->attach($food, ['quantity' => $req['quantity']]);
            // $order->deliveryAddress = 'aaa';

            // Check if in the cart session array already has the same food_id in any of its sub-array's 'id' key.
            $foodExists = false;    // variable for whether that food exists in the cart session array

            // If have, need to add to that quantity, don't push a new array to the cart session array.
            if (is_array(Session::get('cart'))) {
                $cart_arr = Session::get('cart');
                $cart_id = -1;
                foreach ($cart_arr as $subarray) {
                    $cart_id++;
                    // Cart session array consists of subarrays.
                    // Check if array key 'id' is set and whether it is equals to $value that we put into the function
                    if (isset($subarray['id']) && $subarray['id'] == $req->id) {
                        // If true, set $foodExists to true.
                        $foodExists = true;
                        // Increment the food in the cart session array by the specified quantity.
                        Session::increment('cart.' . $cart_id . '.quantity', $req->quantity);
                        Session::save();
                        break;  // break out of this foreach loop
                    }
                }

                // If don't have, push a new array to the cart session array.
                if (!$foodExists) {
                    $food = [
                        'id' => $req->id,
                        'name' => $req->name,
                        'price' => $req->price,
                        'picture' => $req->picture,
                        'quantity' => $req->quantity,
                    ];
                    Session::push('cart', $food);
                }

                Session::flash('success', 'Berhasil menambahkan ke dalam keranjang.');
            }

            return '/home';
        } else {
            Session::flash('info', 'Anda harus login untuk menambahkan ke keranjang dan memesan');
            return '/login';
        }
    }

    public function removeFromCart($id)
    {
        // Function that returns a new cart that doesn't include the food that is to be removed
        function getNewCart($array, $key, $value, $cart_id)
        {
            $cart_arr = array();
            $results = array();

            // check if it is an array
            if (is_array($array)) {

                foreach ($array as $subarray) {
                    $cart_id++;
                    // Cart session array consists of subarrays.
                    // Check if array key 'id' is set and whether it is equals to $value that we put into the function
                    if (isset($subarray[$key]) && $subarray[$key] == $value) {
                        // If true, assign this array to array $results
                        $subarray['cart_id'] = $cart_id;
                        $results[] = $subarray; // $results contains food that is to be deleted
                        break;  // break out of this foreach loop
                    }
                }
            }

            $cart_arr = $array;
            array_splice($cart_arr, $cart_id, 1);   // remove the item from the cart array
            return $cart_arr;
        }

        $new_cart_arr = getNewCart(Session::pull('cart'), 'id', $id, -1);
        Session::save();

        // Replace the existing array in the cart session with $new_cart_arr
        Session::put('cart', $new_cart_arr);

        Session::flash('success', 'Berhasil hapus dari keranjang.');
        return redirect('/cart');
    }

    public function placeOrder(Request $req, CheckoutService $checkoutService)
    {
        $order = Order::create([
            'user_id' => Auth::id(),
            'date' => Carbon::now(),
            'type' => $req->type,
            'deliveryAddress' => $req->address,
        ]);

        $midtrans = $checkoutService->processCheckout($order);

        $cart_arr = Session::pull('cart');
        $total = 0;
        foreach ($cart_arr as $item) {
            $food = Food::findOrFail($item['id']);
            $totalItem = $item['quantity'] * $food['price'];
            $total += $totalItem;
            $order->food()->attach($food, [
                'quantity' => $item['quantity'],
                'harga_item' => $food['price'],
                'total_item' => $totalItem
            ]);
        }

        $order->update(['total' => $total]);

        Session::flash('success', 'Successfully placed order.');

        return redirect($midtrans);
    }

}
