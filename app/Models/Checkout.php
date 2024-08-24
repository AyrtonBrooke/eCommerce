<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    protected $table = 'checkout'; // Specify the table name

    protected $fillable = [
        'user_id',
        'pizza_id',
        'pizza_size',
        'pizza_price',
        'body',
        'phone',
        'total',
        'delivery_choice',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pizza()
    {
        return $this->belongsTo(Pizza::class);
    }
}
