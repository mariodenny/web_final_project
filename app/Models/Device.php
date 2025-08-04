<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $guarded = ['id'];

    public function plant()
    {
        return $this->belongsTo(Plant::class, 'plant_id', 'id');
    }

    public function sensors()
    {
        return $this->hasMany(Sensor::class);
    }

    public function sensorReadings()
    {
        return $this->hasMany(SensorReading::class);
    }
}
