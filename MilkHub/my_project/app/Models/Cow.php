<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cow extends Model
{

    protected $fillable = [
        'name',
        'morning_quantity',
        'evening_quantity',
    ];

      public function milkProductions()
    {
        return $this->hasMany(MilkProduction::class);
    }
}
