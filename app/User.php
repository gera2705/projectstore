<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $timestamps = false;

    protected $fillable = [
        'username','password','fio','email'
    ];

    protected $hidden = [
        'username','password','remember_token'
    ];

    public function projects() {
        return $this->hasMany('App\Project','user_id');
    }

    /*
     * Указание email-строителя при отправки ссылки сброса пароля
     */

    public function sendPasswordResetNotification($token) {
        $this->notify(new ResetPasswordNotification($token));
    }

}
