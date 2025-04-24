<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Order;
use App\Services\CheckoutService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Midtrans\Transaction;

class OrderController extends Controller
{
  public function index(CheckoutService $checkoutService)
  {
    $orders = Order::where('user_id', Auth::id())
      ->with(['food' => function ($query) {
        $query->withPivot('quantity');
      }])
      ->select(['orders.*'])
      ->selectSub(function ($query) {
        $query->from('food_order')
          ->join('food', 'food.id', '=', 'food_order.food_id')
          ->whereColumn('food_order.order_id', 'orders.id')
          ->selectRaw('SUM(food.price * food_order.quantity)');
      }, 'total')
      ->orderBy('date', 'desc')
      ->get();

    return view('order', ['orders' => $orders]);
  }

  public function create(Order $order)
  {
    $order->save();
  }

  public function destroy($id)
  {
    $order = Order::findOrFail($id);
    foreach ($order->food as $food) {
      $order->food()->detach($food->id);
    }
    $order->delete();
    Session::flash('success', 'Berhasil menghapus pesanan dari history pesanan.');
    return redirect('/order');
  }

  public function updateCart(Request $req)
  {
    if (Auth::check()) {
      if (Session::get('cart') == null) {
        Session::put('cart', array());
      }
      $foodExists = false;

      if (is_array(Session::get('cart'))) {
        $cart_arr = Session::get('cart');
        $cart_id = -1;
        foreach ($cart_arr as $subarray) {
          $cart_id++;
          if (isset($subarray['id']) && $subarray['id'] == $req->id) {
            $foodExists = true;
            Session::increment('cart.' . $cart_id . '.quantity', $req->quantity);
            Session::save();
            break;
          }
        }

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

      return '/';
    } else {
      Session::flash('info', 'Anda harus login untuk menambahkan ke keranjang dan memesan');
      return '/login';
    }
  }

  public function removeFromCart($id)
  {
    function getNewCart($array, $key, $value, $cart_id)
    {
      $cart_arr = array();
      $results = array();

      if (is_array($array)) {
        foreach ($array as $subarray) {
          $cart_id++;
          if (isset($subarray[$key]) && $subarray[$key] == $value) {
            $subarray['cart_id'] = $cart_id;
            $results[] = $subarray;
            break;
          }
        }
      }

      $cart_arr = $array;
      array_splice($cart_arr, $cart_id, 1);
      return $cart_arr;
    }

    $new_cart_arr = getNewCart(Session::pull('cart'), 'id', $id, -1);
    Session::save();
    Session::put('cart', $new_cart_arr);
    Session::flash('success', 'Berhasil hapus dari keranjang.');
    return redirect('/cart');
  }

  public function placeOrder(Request $request, CheckoutService $checkoutService)
  {
    DB::beginTransaction();

    try {
      $order = Order::create([
        'user_id' => Auth::id(),
        'date' => Carbon::now(),
        'type' => $request->type,
        'deliveryAddress' => $request->address,
      ]);

      $total = 0;
      $carts = Session::get('cart');
      foreach ($carts as $item) {
        $food = Food::findOrFail($item['id']);

        if ($food['stock'] < $item['quantity']) {
          DB::rollBack();
          return back()->with('warning', "Stok Tidak Cukup {$food->name}. Stok Tersedia: {$food->stock}");
        }

        $totalItem = $item['quantity'] * $food['price'];
        $total += $totalItem;

        $order->food()->attach($food, [
          'quantity' => $item['quantity'],
          'harga_item' => $food['price'],
          'total_item' => $totalItem
        ]);

        $food->update(['stock' => $food['stock'] - $item['quantity']]);
      }

      $order->update(['total' => $total]);

      $midtrans = $checkoutService->processCheckout($order);

      $order->update([
        'url_pembayaran' => $midtrans->redirect_url,
        'status_pembayaran' => 'pending',
      ]);

      DB::commit();
      Session::pull('cart');

      return redirect($midtrans->redirect_url)->with('success', 'Successfully placed order.');
    } catch (\Exception $e) {
      DB::rollBack();
      return back()->with('error', 'An error occurred while placing your order. Please try again.');
    }
  }

  public function print($id)
  {
    $order = Order::with('food')->findOrFail($id);

    return view('order.print', compact('order'));
  }
}
