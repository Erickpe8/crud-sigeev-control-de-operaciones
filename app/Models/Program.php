<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'programs';

    /**
     * Atributos que pueden ser asignados masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'color',
        'is_active',
        'description'
    ];

    /**
     * Conversiones de tipos para los atributos.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Valores por defecto para los atributos.
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => true,
    ];

    }
