<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
  protected $fillable = ['role', 'skills', 'experience'];
  protected $hidden = ['id_project', 'id_candidate', 'id_state'];
  protected $appends = ['project_name', 'candidate_name', 'state_name'];

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

  public function getStateNameAttribute($value) {
    $state_name = null;
    if ($this->state)
        $state_name = $this->state->state;
    return $state_name;
  }

  public function project() {
    return $this->belongsTo('App\Project');
  }

  public function candidate() {
    return $this->belongsTo('App\Candidate');
  }

  public function state() {
    return $this->belongsTo('App\StateParticipation');
  }
}
