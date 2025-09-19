<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use HasFactory, SoftDeletes;

     protected $table = 'agendas';

     /**
     * Atributos que pueden ser asignados masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'title',  // Título de la actividad,
        'start_date', //fecha de inicio
        'end_date', //fecha de fin
        'start_time', //hora de inicio
        'end_time', //hora de fin
        'description',  // Descripción detallada
    ];

    /**
     * Relación: Una agenda puede tener muchos temas.
     */
    public function themes()
    {
        return $this->hasMany(Theme::class);
    }

    /**
     * Relación: Una agenda pertenece a un evento.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }


    /**
     * Conversiones de tipos para los atributos.
     * @var array
     */
    protected $casts = [
        'start_date' => 'date:Y-m-d',  // Formato fecha: Año-Mes-Día
        'end_date' => 'date:Y-m-d',    // Formato fecha: Año-Mes-Día
        'start_time' => 'datetime:H:i:s', // Formato hora: Horas:Minutos:Segundos
        'end_time' => 'datetime:H:i:s',   // Formato hora: Horas:Minutos:Segundos
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    
}
