<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $guarded = [];

    public function concerts()
    {
        return $this->hasMany(Concert::class);
    }
}