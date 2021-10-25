<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    protected $fillable = ['fio', 'email', 'position'];
    protected $hidden = ['api_token'];

    public function projects() {
        return $this->hasMany('App\Project','supervisor_id');
    }
}
