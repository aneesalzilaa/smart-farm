<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoredMilkQuantity extends Model
{
    protected $fillable = [
        'stored_date',
        'quantity',
    ];
}
