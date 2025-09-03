<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// أضف هذا السطر:
use App\Models\Customer;

class MilkSale extends Model
{
    protected $fillable = ['sale_type', 'customer_id', 'quantity', 'price', 'total'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
