<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CowFeed extends Model
{
    use HasFactory;

    protected $fillable = [
           'cow_id',
        'feed_id',
        'date',
        'morning_quantity',
        'evening_quantity',
        'price',
        'total_price',
    ];

    public function cow()
    {
        return $this->belongsTo(Cow::class);
    }

    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }
}
