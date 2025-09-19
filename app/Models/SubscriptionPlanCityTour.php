<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionPlanCityTour extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'subscription_plan_city_tour';

    /**
     * Atributos que pueden ser asignados masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'subscription_plan_id',  // ID del plan de suscripción
        'city_tour_id',         // ID del tour ciudad
        'included',            // Si está incluido en el plan
        'discount_percentage' // Porcentaje de descuento
    ];

    /**
     * Relación: Un plan de suscripción tiene un tour en ciudad.
     */
    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    /**
     * Relación: Un plan de suscripción tiene un tour en ciudad.
     */
    public function cityTour()
    {
        return $this->belongsTo(CityTour::class);
    }

    protected $casts = [
        'included' => 'boolean',
        'discount_percentage' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Valores por defecto para los atributos.
     *
     * @var array
     */
    protected $attributes = [
        'included' => false,
    ];

    /**
     * Calcula el precio final aplicando descuento si corresponde.
     *
     * @param float $basePrice
     * @return float|null
     */
    public function calculateFinalPrice($basePrice)
    {
        if ($this->included) {
            return 0; // Tour incluido en el plan
        }

        if ($this->discount_percentage) {
            return $basePrice * (1 - ($this->discount_percentage / 100));
        }

        return $basePrice; // Sin descuento
    }
}
