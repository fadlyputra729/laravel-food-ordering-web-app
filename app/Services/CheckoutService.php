<?php

namespace App\Services;

use App\Repositories\TransactionRepositoryInterface;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutService
{
  protected $transactionRepository;

  public function __construct(TransactionRepositoryInterface $transactionRepository)
  {
    $this->transactionRepository = $transactionRepository;

    // Konfigurasi Midtrans
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');
    Config::$isSanitized = true;
    Config::$is3ds = true;
  }

  public function processCheckout($order)
  {
    $params = [
      'transaction_details' => [
        'order_id' => $order->id,
        'gross_amount' => $order['total']
      ],
      'customer_details' => [
        'first_name' => auth()->user()->name,
        'email' => auth()->user()->email,
      ]
    ];

    return \Midtrans\Snap::createTransaction($params);
  }
}

