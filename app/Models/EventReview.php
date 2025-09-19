<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventReview extends Model
{
    use HasFactory, SoftDeletes;
    
    /**
     * Nombre de la tabla asociada al modelo
     *
     * @var string
     */
    protected $table = 'event_reviews';

    /**
     * Constantes para el sistema de calificación
     */
    public const RATING_MIN = 1;         // Calificación mínima permitida (1 estrella)
    public const RATING_MAX = 5;         // Calificación máxima permitida (5 estrellas)
    public const POSITIVE_THRESHOLD = 3; // Umbral para considerar reseña como positiva (≥3 estrellas)

    /**
     * Atributos que se pueden asignar masivamente
     *
     * @var array
     */
    protected $fillable = [
        'uuid',                   // Identificador único universal
        'user_id',               // ID del usuario que hace la reseña
        'event_id',              // ID del evento reseñado
        'event_attendance_id',   // ID de la asistencia (para verificación)
        'rating',                // Calificación (1-5 estrellas)
        'comment',               // Comentario textual
        'is_anonymous',          // Si la reseña es anónima
        'is_positive'           // Si la reseña es positiva
    ];

    /**
     * Relación: Una reseña pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: Una reseña pertenece a un evento.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Relación: Una reseña pertenece a una asistencia de evento.
     */
    public function eventAttendance()
    {
        return $this->belongsTo(EventAttendance::class);
    }

    /**
     * Conversiones de tipos para los atributos
     *
     * @var array
     */
    protected $casts = [
        'rating' => 'integer',           // Convertir rating a entero
        'is_anonymous' => 'boolean',     // Convertir a booleano
        'is_positive' => 'boolean',     // Convertir a booleano
        'created_at' => 'datetime',     // Fechas como objetos Carbon
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Valores por defecto para los atributos
     *
     * @var array
     */
    protected $attributes = [
        'is_anonymous' => false, // Por defecto las reseñas no son anónimas
    ];

    
}
