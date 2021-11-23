<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model {
    public $timestamps = false;
    protected $fillable = ['id', 'id_project', 'text', 'date', 'id_student'];
    
    public function project() {
        return $this->belongsToMany('App\Project');
    }
}
