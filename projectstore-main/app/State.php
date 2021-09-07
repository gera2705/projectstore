<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public $timestamps = false;
    protected $fillable = ['state'];

    public function projects() {
        return $this->hasMany('App\Project','state_id');
    }
}
