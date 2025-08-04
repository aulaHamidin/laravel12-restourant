<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use SoftDeletes ,HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'fullname',
        'email',
        'password',
        'phone',
        'role_id',
    ];

    protected $dates = ['deleted_at'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
