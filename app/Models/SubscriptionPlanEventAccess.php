<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionPlanEventAccess extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Modos de acceso disponibles
     */
    public const MODE_ALLOW = 'permitir';
    public const MODE_DENY = 'denegar';
    public const MODE_QUOTA = 'cuota';

    /**
     * Nombre de la tabla asociada al modelo
     *
     * @var string
     */
    protected $table = 'subscription_plan_event_access';

    /**
     * Atributos que pueden ser asignados masivamente
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'subscription_plan_id',
        'event_type_id',
        'event_id',
        'mode',
        'quota',
        'notes'
    ];

    /**
     * Relación: Un plan de suscripción tiene un evento.
     */
    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    /**
     * Relación: Un plan de suscripción tiene una categoría.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relación: Un plan de suscripción tiene un evento.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Conversiones de tipos para los atributos
     *
     * @var array
     */
    protected $casts = [
        'quota' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Valores por defecto para los atributos
     *
     * @var array
     */
    protected $attributes = [
        'mode' => self::MODE_ALLOW,
    ];


    /**
     * Verifica si el acceso está permitido
     *
     * @return bool
     */
    public function isAllowed()
    {
        return $this->mode === self::MODE_ALLOW;
    }

    /**
     * Verifica si el acceso está denegado
     *
     * @return bool
     */
    public function isDenied()
    {
        return $this->mode === self::MODE_DENY;
    }

    /**
     * Verifica si el acceso tiene cuota limitada
     *
     * @return bool
     */
    public function hasQuota()
    {
        return $this->mode === self::MODE_QUOTA && !is_null($this->quota);
    }

    /**
     * Filtro para reglas de acceso permitido
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAllowed($query)
    {
        return $query->where('mode', self::MODE_ALLOW);
    }

    /**
     * Filtro para reglas de acceso denegado
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDenied($query)
    {
        return $query->where('mode', self::MODE_DENY);
    }

    /**
     * Filtro para reglas con cuota limitada
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithQuota($query)
    {
        return $query->where('mode', self::MODE_QUOTA)
                    ->whereNotNull('quota');
    }

    /**
     * Obtiene el alcance de la regla (tipo de evento, evento específico o global)
     *
     * @return string
     */
    public function getScopeAttribute()
    {
        if ($this->event_id) {
            return 'evento_específico';
        }

        if ($this->event_type_id) {
            return 'tipo_de_evento';
        }

        return 'global';
    }
}
