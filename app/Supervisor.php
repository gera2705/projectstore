<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    public $timestamps = false;
    protected $fillable = ['fio', 'email', 'position', 'about'];
    protected $hidden = ['api_token', 'updated_at'];

    public function projects() {
        return $this->hasMany('App\Project', 'supervisor_id');
    }
}
