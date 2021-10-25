<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParticipationsSkill extends Model
{
    public $timestamps = false;
    protected $fillable = ['id_participation', 'id_skill']; 

    public function participation() {
        return $this->belongsToMany('App\Participation');
    }

    public function skill() {
      return $this->belongToMany('App\Skill');
    }
}
