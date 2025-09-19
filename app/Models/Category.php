<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'is_active',
        'description',
    ];


    /**
     * Relación: Una categoría puede estar asociada a muchos eventos.
     */
    public function events()
    {
        return $this->belongsToMany(Event::class, 'category_event');
    }

    /**
     * Relación: Una categoría puede tener muchos accesos a planes de suscripción.
     */
    public function subscriptionPlanAccesses()
    {
        return $this->hasMany(SubscriptionPlanEventAccess::class);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
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
