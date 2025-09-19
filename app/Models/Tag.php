<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tags';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'color', // Color del tag, por ejemplo: "#FF5733"
        'description'
    ];

    /**
     * Relación: Un tag puede estar asociado a muchos eventos.
     */
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_tag');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Formatea el nombre del tag para consistencia
     * 
     * @param string $name
     * @return string
     */
    protected static function formatTagName(string $name): string
    {
        return ucfirst(strtolower(trim($name)));
    }

    /**
     * Formatea el description del tag para consistencia
     * 
     * @param string $description
     * @return string
     */
    protected static function formatTagDescription(string $description): string
    {
        return ucfirst(strtolower(trim($description)));
    }
}
