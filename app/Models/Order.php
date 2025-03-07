<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
        'username',
        'address',
        'phone',
        'email',
        'notes',
        'total_amount',
        'payment_method',
        'payment_status',
        'order_status',
        'reason'
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
