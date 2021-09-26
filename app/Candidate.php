<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    public $timestamps = false; // выключения updated_at и created_at
    protected $fillable = ['fio','email','numz','phone','competencies',
        'course','experience','training_group','project_id','is_mate']; // поля для "массового назначения"
    
    /*
     * Связь с проектом (что карточка кандидата относится к проекту)
     */

    public function project() {
        return $this->belongsTo('App\Project');
    }

    public function skills() {
        return $this->belongsTo('App\Skill');
    }
}
