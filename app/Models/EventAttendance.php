<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class EventAttendance extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Estados posibles de la asistencia
     */
    public const STATUS_VALID = 'valido';
    public const STATUS_REJECTED = 'rechazado';
    public const STATUS_DUPLICATE = 'duplicado';

    /**
     * Nombre de la tabla asociada al modelo
     *
     * @var string
     */
    protected $table = 'event_attendances';

    /**
     * Atributos que pueden ser asignados masivamente.
     *
     * @var array
     */
    /**
     * Atributos que pueden ser asignados masivamente
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'user_id',
        'event_id',
        'registration_event_id',
        'access_token',
        'checked_in_at', // Registra la hora de entrada
        'checked_out_at', //Registra la hora de salida
        'status'
    ];

    /**
     * Relación: Un evento tiene un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: Un evento tiene un evento.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

   /*  public function registrationEvent()
    {
        return $this->belongsTo(RegistrationEvent::class);
    } */


    /**
     * Relación: Un evento tiene varias reseñas.
     */
    public function eventReviews()
    {
        return $this->hasMany(EventReview::class);
    }

    /**
     * Conversiones de tipos para los atributos
     *
     * @var array
     */
    protected $casts = [
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
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
        'status' => self::STATUS_VALID,
    ];

   }
