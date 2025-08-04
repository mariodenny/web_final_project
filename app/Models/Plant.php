<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    protected $guarded = ['id'];

    public function sensors()
    {
        return $this->hasMany(Sensor::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}
