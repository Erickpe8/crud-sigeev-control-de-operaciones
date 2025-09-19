<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    protected $table = 'themes';

    /**
     * Atributos que pueden ser asignados masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',         // Nombre del eje temático
        'description'   // Descripción detallada
    ];

    /*
     * Relación: Un tema pertenece a una agenda.
     */
    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    /**
     * un evento pertenece a muchos temas
     */
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_theme'); // Relación N:M con eventos
    }


    /**
     * Conversiones de tipos para los atributos.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Filtro para temas activos (no eliminados).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

}
