<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    public $timestamps = false;
    protected $fillable = ['fio', 'email', 'numz', 'phone', 'competencies',
        'course', 'experience', 'training_group', 'project_id', 'is_mate']; 

    public function skills() {
        return $this->belongsTo('App\Skill');
    }
}
