<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    public $timestamps = false;
    protected $fillable = ['fio', 'email', 'about', 'numz', 'phone', 'competencies',
        'course', 'experience', 'training_group']; 
    protected $appends = ['active_participate'];

    public function getActiveParticipateAttribute($value) {
        return $this->pariticaptions();
    }

    public function pariticaptions() {
        return $this->hasMany('App\Participation', 'id_candidate');
    }

    public function skills() {
        return $this->belongsTo('App\Skill');
    }
}
