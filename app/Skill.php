<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    public $timestamps = false;
    protected $fillable = ['skill'];

    public function candidates() {
        return $this->belongsToMany('App\Candidate');
    }
}
