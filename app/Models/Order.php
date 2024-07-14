<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table= 'orders';
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'mobilenumber',
        'address',
        'city',
        'barangay',
        'zipcode',
        'status',
        'message',
        'tracking_no',
    ];
    public function getOrderCount() {
        $orderCount = Order::count(); // Example query to count orders
        
        return $orderCount;
    }
    public function items()
{
    return $this->hasMany(OrderItem::class);
}

}