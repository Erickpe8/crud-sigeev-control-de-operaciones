<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionPlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'subscription_plans';

    protected $fillable = [
        'uuid',
        'name',
        'description',
        'modality_id',
        'is_active',
    ];

    /**
     * Relación: Un plan de suscripción pertenece a una modalidad.
     */
    public function modality()
    {
        return $this->belongsTo(Modality::class);
    }

    /**
     * Relación: Un plan de suscripción puede tener varios precios.
     */
    public function planPrices()
    {
        return $this->hasMany(PlanPrice::class);
    }

    /**
     * Relación: Un plan de suscripción puede tener varios tours en ciudad.
     */
    public function subscriptionPlanCityTours()
    {
        return $this->hasMany(SubscriptionPlanCityTour::class);
    }

    /**
     * Relación: Un plan de suscripción puede tener varios accesos a eventos.
     */
    public function subscriptionPlanEventAccesses()
    {
        return $this->hasMany(SubscriptionPlanEventAccess::class);
    }

    /* public function registrations()
    {
        return $this->hasMany(Registration::class);
    } */


    protected $casts = [
      'is_active'  => 'boolean',
      'created_at' => 'datetime',
      'updated_at' => 'datetime',
      'deleted_at' => 'datetime',
    ];

}
