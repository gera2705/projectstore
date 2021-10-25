<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectTag extends Model
{
    public $timestamps = false;
    protected $fillable = ['project_id', 'tag_id']; 

    public function project() {
        return $this->belongsToMany('App\Project');
    }

    public function tag() {
      return $this->belongToMany('App\Tag');
    }
}