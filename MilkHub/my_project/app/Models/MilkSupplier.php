<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MilkSupplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
    ];

    public function deliveries()
    {
        return $this->hasMany(MilkSupplierDelivery::class);
    }
}

