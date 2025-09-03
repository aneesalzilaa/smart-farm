<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MilkSupplierDelivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'milk_supplier_id',
        'date',
        'morning_quantity',
        'evening_quantity',
        'price_per_liter',
        'total',
    ];

    protected static function booted()
    {
        static::creating(function ($delivery) {
            $totalQuantity = $delivery->morning_quantity + $delivery->evening_quantity;
            $delivery->total = $totalQuantity * $delivery->price_per_liter;
        });

        static::updating(function ($delivery) {
            $totalQuantity = $delivery->morning_quantity + $delivery->evening_quantity;
            $delivery->total = $totalQuantity * $delivery->price_per_liter;
        });
    }

    // أضف هذه العلاقة
    public function milkSupplier()
    {
        return $this->belongsTo(MilkSupplier::class, 'milk_supplier_id');
    }
}



