<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_number',
        'total_amount',
        'order_date',
        'status',
        'payment_status',
        'payment_method',
        'shipping_address',
        'shipping_method',
        'discount_amount',
        'tax_amount',
        // Add more fields as needed for your specific use case
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Define other properties and methods of the Order model
}
