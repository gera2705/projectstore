<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    public $timestamps = false;
    protected $fillable = ['fio', 'email', 'about', 'numz', 'phone',
        'course', 'training_group', 'experience']; 
    protected $appends = ['active_participate', 'skills'];
    protected $hidden = ['is_watched', 'active_participate', 'competencies'];

    public function getActiveParticipateAttribute($value) {
        return $this->pariticaptions();
    }

    public function getExperienceAttribute() {
        //return Participation::where('id_candidate', $this->id)->get();
    }

    public function getSkillsAttribute($value) {
        return CandidatesSkill::join('skills','skills.id','=','candidates_skills.id_skill')->select('id_skill as id', 'skill')->where('id_candidate', $this->id)->get();
    } 
}
