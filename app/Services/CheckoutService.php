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

    public function processCheckout($data)
    {
//        $transaction = $this->transactionRepository->createTransaction([
//            'product_id' => $data['product_id'],
//            'customer_id' => $data['customer_id'],
//            'quantity' => $data['quantity'],
//            'total_price' => $data['total_price'],
//            'status' => 'pending'
//        ]);

        // Membuat Snap Token Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $data->id,
                'gross_amount' => 200000
            ],
            'customer_details' => [
                'first_name' => 'tes',
                'email' => 'tes@gmail.com',
                'phone' => '082181556565'
            ]
        ];

        return \Midtrans\Snap::createTransaction($params)->redirect_url;
    }
}

