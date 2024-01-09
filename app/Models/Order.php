<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'amount', 'currency', 'status',
        'payment_method', 'payment_gateway', 'transaction_id',
        'transaction_url', 'shipping_address_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
