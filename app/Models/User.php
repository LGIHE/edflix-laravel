<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'location',
        'phone',
        'type',
        'role',
        'school',
        'subject_1',
        'subject_2',
        'subject_3',
        'password_confirmation'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const ADMIN = 'admin';
    const TEACHER = 'teacher';
    const FACILITATOR = 'Facilitator';
    const SYS_ADMIN = 'Administrator';

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function isAdmin() {
        return $this->type === self::ADMIN;
    }

    public function isTeacher() {
        return $this->type === self::TEACHER;
    }

    public function isFacilitator() {
        return $this->role === self::FACILITATOR;
    }

    public function isRoleSuperAdmin() {
        return $this->role === self::SYS_ADMIN;
    }

}
