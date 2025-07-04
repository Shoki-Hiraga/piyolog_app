<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BabyName extends Model
{
    protected $fillable = ['name'];

    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}
