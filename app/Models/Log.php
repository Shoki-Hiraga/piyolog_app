<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'baby_name_id',
        'date',
        'time',
        'activity',
        'amount',
        'sleep_minutes',
        'textlog',
    ];

    public function babyName()
    {
        return $this->belongsTo(BabyName::class);
    }

}
