<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $guarded = ['id'];

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    public function sensorReading()
    {
        return $this->hasOne(SensorReading::class);
    }
}
