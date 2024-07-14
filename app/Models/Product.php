<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'description',
        'price',
        'stocks_s',
        'stocks_m',
        'stocks_l',
        'stocks_xl',
        'category',
        'image1',
        'image2',
        'ratings',
        'ratings_count',
    ];

    public function decrementStock($size, $quantity)
    {
        $sizeKey = 'stocks_' . strtolower($size);
        if ($this->$sizeKey >= $quantity) {
            $this->$sizeKey -= $quantity;
            $this->save();
        } else {
            // Handle out-of-stock scenario
            throw new \Exception("Insufficient stock for {$size} size of {$this->item_name}");
        }
    }

    public function incrementStock($size, $quantity)
{
    $sizeKey = 'stocks_' . strtolower($size);
        if ($this->$sizeKey >= $quantity) {
            $this->$sizeKey += $quantity;
            $this->save();
        } else {
            // Handle out-of-stock scenario
            throw new \Exception("Insufficient stock for {$size} size of {$this->item_name}");
        }
}
    public function getStockQuantity($size)
{
    $sizeKey = 'stocks_' . strtolower($size);
    
    // Calculate total stock quantity for the size
    $totalStock = $this->$sizeKey ?? 0;

    // Deduct quantities from cancelled orders
    $cancelledOrderItems = $this->orderItems()->where('status', 'cancelled')->get();
    
    foreach ($cancelledOrderItems as $item) {
        $totalStock += $item->quantity;
    }

    return $totalStock;
}

    
    public function ratings()
    {
        return $this->hasMany(ProductRating::class);
    }

    public function averageRating()
    {
        $ratings = $this->ratings()->pluck('rating')->toArray();
        $count = count($ratings);

        if ($count > 0) {
            return array_sum($ratings) / $count;
        }

        return 0;
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getMaxStocksForSize($size)
    {
        switch ($size) {
            case 'S':
                return $this->stocks_s ?? 0;
            case 'M':
                return $this->stocks_m ?? 0;
            case 'L':
                return $this->stocks_l ?? 0;
            case 'XL':
                return $this->stocks_xl ?? 0;
            default:
                return 0;
        }
    }
}
