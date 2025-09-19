<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'locations';


       /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'room',
        'address',
        'image',
        'reference_point',
        'latitude',
        'longitude',
        'google_maps_link',
        'country',
        'city',
        'is_active'
    ];

    /**
     * Relación many-to-many con Event a través de la tabla pivot
     */
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_schedule_location');
    }

    /**
     * Relación many-to-many con Schedule a través de la tabla pivot
     */
    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'event_schedule_location');
    }

    protected $casts = [
        'is_active'  => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => true,
    ];

}
