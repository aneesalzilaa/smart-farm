<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkSurplus extends Model
{
    use HasFactory;

    protected $table = 'milk_surplus';

    protected $fillable = [
        'date',
        'quantity',
    ];

    protected $casts = [
        'date' => 'date',
        'quantity' => 'float',
    ];
}
