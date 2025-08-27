<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Speaker extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'full_name','email','phone','company','role','bio','status'
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class)->withTimestamps();
    }
}
