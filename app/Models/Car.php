<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Car extends Model
{
    use HasFactory;

    protected $table = 'cars';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = ['name', 'founded', 'description'];

    // Hidden & visible only works on toJson() and toArray()
    // protected $hidden = ['updated_at'];

    // protected $visible = ['id', 'name', 'founded', 'description', 'created_at'];

    public function carTypes()
    {
        return $this->hasMany(CarType::class);
    }

    public function engines()
    {
        return $this->hasManyThrough(
            Engine::class,
            CarType::class,
            'car_id', // Foreign key on CarType table
            'type_id', // Foreign key on Engine table
        );
    }

    // Define a has one trhough realitionship
    public function productionDate()
    {
        return $this->hasOneThrough(
            CarProductionDate::class,
            CarType::class,
            'car_id',
            'type_id',
        );
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
