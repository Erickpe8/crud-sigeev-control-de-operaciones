<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected static function boot()
{
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'email',
        'birthdate',
        'profile_photo',
        'gender_id',
        'document_type_id',
        'document_number',
        'phone',
        'user_type_id',
        'academic_program_id',
        'institution_id',
        'company_name',
        'company_address',
        'status',
        'accepted_terms',
        'password'
    ];

    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }


    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function userType(): BelongsTo
    {
        return $this->belongsTo(UserType::class);
    }

    public function academicProgram(): BelongsTo
    {
        return $this->belongsTo(AcademicProgram::class);
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
    'birthdate' => 'date:Y-m-d',
    'accepted_terms' => 'boolean',
    'status' => 'boolean',
    ];

    /**
     * Mutador para formatear el campo first_name antes de guardar.
     * Aplica trim, minúsculas y capitaliza las palabras.
     */
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucwords(strtolower(trim($value)));
    }

    /**
     * Mutador para formatear el campo last_name antes de guardar.
     * Aplica trim, minúsculas y capitaliza las palabras.
     */
    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucwords(strtolower(trim($value)));
    }

    /**
     * Mutador para formatear el campo company_name antes de guardar.
     * Esto asegura que el nombre de la empresa tenga formato legible.
     */
    public function setCompanyNameAttribute($value)
    {
        $this->attributes['company_name'] = ucwords(strtolower(trim($value)));
    }
}
