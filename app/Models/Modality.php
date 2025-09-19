<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modality extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'modalitys';

    protected $fillable = [
      'name',
      'is_active'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relación: Una modalidad puede tener muchos eventos.
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Relación: Una modalidad puede tener muchos planes de suscripción.
     */
    public function subscriptionPlans()
    {
        return $this->hasMany(SubscriptionPlan::class);
    }
}
