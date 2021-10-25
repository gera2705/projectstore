<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
  public $timestamps = false;
  protected $fillable = ['role', 'id_project', 'id_candidate', 'id_state', 'id'];
  protected $hidden = ['candidate', 'states', 'projects'];
  protected $appends = ['state', 'skills', 'project'];

  public function getStateAttribute($value) {
    $state = null;
    if ($this->states)
        $state = $this->states->state;
    return $state;
  }

  public function getProjectAttribute($value) {
    $project = null;
    if ($this->projects)
        $project = $this->projects;
    return $project;
  }

  public function getSkillsAttribute() {
    return ParticipationsSkill::join('skills','skills.id','=','participations_skills.id_skill')->select('id_skill as id', 'skill')->where('id_participation', $this->id)->get();
  }

  public function projects() {
    return $this->belongsTo('App\Project', 'id_project');
  }

  public function candidate() {
    return $this->belongsTo('App\Candidate', 'id_candidate');
  }

  public function states() {
    return $this->belongsTo('App\StateParticipation', 'id_state');
  }
}
