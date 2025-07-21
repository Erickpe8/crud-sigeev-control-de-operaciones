<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AcademicProgram extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['uuid', 'name', 'code', 'color', 'description', 'institution_id'];

    // Un programa académico pertenece a una institución
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    // Un programa académico puede tener muchos usuarios
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Generar automáticamente un UUID al crear el modelo
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($academicProgram) {
            if (empty($academicProgram->uuid)) {
                $academicProgram->uuid = (string) Str::uuid();
            }
        });
    }
}
