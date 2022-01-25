<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Client;
use App\Notifications\SendPasswordNotification;
use App\Notifications\ChangePasswordNotification;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'login_id',
        'email',
        'password',
        'role_id',
        'is_online',
        'email_verified_at'
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

    public function createToken(): string
    {
        return app(PasswordBroker::class)->createToken($this);
    }

    public function accountingOffice(): HasOne
    {
        return $this->hasOne(AccountingOffice::class);
    }

    public function role(): HasOne
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function clientStaff(): HasOne
    {
        return $this->hasOne(ClientStaff::class, 'user_id', 'id');
    }

    public function accountingOfficeStaff(): HasOne
    {
        return $this->hasOne(AccountingOfficeStaff::class, 'user_id', 'id');
    }

    public function sendPasswordNotification($token, $pw, $login_id): void
    {
        $this->notify(new SendPasswordNotification($token, $pw, $login_id));
    }

    public function sendResetPassNotification($token, $login_id): void
    {
        $this->notify(new ChangePasswordNotification($token, $login_id));
    }
}
