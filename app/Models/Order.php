<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 'date', 'address', 'total_price', 'status'
    ];
    
    protected $casts = [
        'date' => 'date'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 💥 ON RENOMME LA RELATION POUR QUE LE CONTROLLER COMPRENNE
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')
                    ->withPivot('quantity', 'price');
    }
}
