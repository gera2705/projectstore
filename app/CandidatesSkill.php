<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class CandidatesSkill extends Model
{
  public $timestamps = false;
  protected $fillable = ['id_candidate', 'id_skill']; 

  public function candidate() {
      return $this->belongsToMany('App\Candidate');
  }

  public function skill() {
    return $this->belongToMany('App\Skill');
  }
}