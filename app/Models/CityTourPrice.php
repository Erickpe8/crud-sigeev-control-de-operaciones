<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CityTourPrice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'city_tour_id',
        'user_type_id',
        'price',
        'currency',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relación: Un tour en ciudad tiene un precio.
     */
    public function cityTour()
    {
        return $this->belongsTo(CityTour::class);
    }

    /**
     * Relación: Un tour en ciudad tiene un tipo de usuario.
     */
    public function userType()
    {
        return $this->belongsTo(UserType::class);
    }
}
