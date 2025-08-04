<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorReading extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'sensor_values' => 'json'
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class, 'sensor_id');
    }

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id', 'id');
    }
}
