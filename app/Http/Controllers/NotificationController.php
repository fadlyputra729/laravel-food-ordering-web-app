<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Notification;

class NotificationController extends Controller
{
    public function index(Request  $request)
    {
      $transaction = Order::find($request->order_id);

      if (!$transaction) {
        return response()->json(['message' => 'Transaction not found'], 404);
      }

      if ($request->transaction_status == 'settlement' || $request->transaction_status == 'capture') {
        $transaction->status = 'paid'; // Status pembayaran berhasil
      } elseif ($request->transaction_status == 'cancel' || $request->transaction_status == 'expire') {
        $transaction->status = 'failed'; // Status pembayaran gagal atau kadaluarsa
      } elseif ($request->transaction_status == 'pending') {
        $transaction->status = 'pending'; // Status menunggu pembayaran
      }

      $transaction->save();

    }
}
