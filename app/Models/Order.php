<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'date',
        'type',
        'status',
        'status_pembayaran',
        'url_pembayaran',
        'deliveryAddress',
        'total'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function food()
    {
        return $this->belongsToMany(Food::class)->withPivot('quantity');
    }
}
