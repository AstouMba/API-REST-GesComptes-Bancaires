<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'login',
        'password',
        'code',
        'is_admin',
    ];

   protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
    ];
       public function username()
    {
        return 'login';
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'utilisateur_id');
    }
}
