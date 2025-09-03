<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkProduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'cow_id',
        'morning_amount',
        'evening_amount',
        'date',
        'price',
        'total',
    ];
        protected $casts = [
        'date' => 'datetime',
    ];

    public function cow()
    {
        return $this->belongsTo(Cow::class);
    }
}
