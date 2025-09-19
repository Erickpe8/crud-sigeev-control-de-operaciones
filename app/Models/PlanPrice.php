<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanPrice extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'plan_prices';

    protected $fillable = [
        'uuid',
        'subscription_plan_id',
        'user_type_id',
        'price',
        'currency',
    ];

    /**
     * Relación: Un precio pertenece a un plan de suscripción.
     */
    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    /**
     * Relación: Un precio puede estar asociado a un tipo de usuario.
     */
    public function userType()
    {
        return $this->belongsTo(UserType::class);
    }

    
    protected $attributes = [
        'currency' => 'COP',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

}
