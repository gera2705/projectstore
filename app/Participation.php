<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
  public $timestamps = false;
  protected $fillable = ['role', 'skills'];
  protected $hidden = ['id_project', 'id_candidate', 'id_state', 'experience', 'project', 'candidate', 'states'];
  protected $appends = ['project_name', 'candidate_name', 'state'];

  public function getProjectNameAttribute($value) {
    $project_name = null;
    if ($this->project)
        $project_name = $this->project->title;
    return $project_name;
  }

  public function getCandidateNameAttribute($value) {
    $candidate_name = null;
    if ($this->candidate)
        $candidate_name = $this->candidate->fio;
    return $candidate_name;
  }

  public function getStateAttribute($value) {
    $state = null;
    if ($this->states)
        $state = $this->states->state;
    return $state;
  }

  public function getSkillsAttribute() {
    return CandidatesSkill::join('skills','skills.id','=','participations_skills.id_skill')->select('id_skill as id', 'skill')->where('id_participation', $this->id)->get();
  }

  public function project() {
    return $this->belongsTo('App\Project', 'id_project');
  }

  public function candidate() {
    return $this->belongsTo('App\Candidate', 'id_candidate');
  }

  public function states() {
    return $this->belongsTo('App\StateParticipation', 'id_state');
  }
}
