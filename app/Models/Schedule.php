<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'schedules';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
    ];

    /**
     * Relación many-to-many con Event a través de la tabla pivot
     */
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_schedule_location');
    }

    /**
     * Relación many-to-many con Location a través de la tabla pivot
     */
    public function locations()
    {
        return $this->belongsToMany(Location::class, 'event_schedule_location');
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Obtiene la fecha y hora de inicio combinadas.
     *
     * @return Carbon
     */
    public function getStartDateTimeAttribute()
    {
        return Carbon::parse($this->start_date->format('Y-m-d') . ' ' . $this->start_time);
    }

    /**
     * Obtiene la fecha y hora de finalización combinadas.
     *
     * @return Carbon
     */
    public function getEndDateTimeAttribute()
    {
        return Carbon::parse($this->end_date->format('Y-m-d') . ' ' . $this->end_time);
    }

    /**
     * Verifica si el horario es para un solo día.
     *
     * @return bool
     */
    public function getIsSingleDayAttribute()
    {
        return $this->start_date->equalTo($this->end_date);
    }

    /**
     * Calcula la duración en minutos.
     *
     * @return int
     */
    public function getDurationInMinutesAttribute()
    {
        return $this->end_datetime->diffInMinutes($this->start_datetime);
    }

    /**
     * Scope a query to only include schedules on a specific date.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnDate($query, $date)
    {
        return $query->where('start_date', '<=', $date)
                    ->where('end_date', '>=', $date);
    }

    /**
     * Filtra horarios para una fecha específica.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUpcoming($query)
    {
        return $query->where('end_date', '>=', now()->format('Y-m-d'));
    }

}
