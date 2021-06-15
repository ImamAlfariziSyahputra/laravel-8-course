<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    use HasFactory;

    protected $table = 'car_types';

    protected $primaryKey = 'id';

    // A car type belongs to a car
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
