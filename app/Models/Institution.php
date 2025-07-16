<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory, SoftDeletes;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'uuid',
        'name',
        'acronym',
        'city',
        'country',
    ];

    // Relación: una institución tiene muchos usuarios
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Una institución tiene muchos programas académicos
    public function academicPrograms()
    {
        return $this->hasMany(AcademicProgram::class);
    }

    // Generar automáticamente un UUID al crear el modelo
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($institution) {
            if (empty($institution->uuid)) {
                $institution->uuid = (string) Str::uuid();
            }
        });
    }
}
