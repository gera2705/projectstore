<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StateParticipation extends Model
{
    protected $fillable = ['state'];

    public function participations() {
        return $this->hasMany('App\Participation','id_state');
    }
}
