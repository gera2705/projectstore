<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //public $timestamps = false;
    protected $fillable = ['title','places',
        'state_id','type_id','goal','idea','difficulty','date_start','date_end',
        'requirements','customer','expected_result','user_id','additional_inf'];
    public const CREATED_AT = null; // выключение created_at, однако updated_at будет существовать
    protected $hidden = ['error_message','is_scanned','user_id','type_id','type','user','state_id','state']; 
    protected $appends = ['type_name','user_name','vacant_places','state_name']; // дополнительные свойства


    // взятие типа
    public function getTypeNameAttribute($value) {
        $type_name = null;
        if ($this->type)
            $type_name = $this->type->type;
        return $type_name;
    }

    // взятие вакантных (свободных) мест
    public function getvacantPlacesAttribute($value) {
        return $this->places - $this->candidates()->where('is_mate',1)->count();
    }

    // взятие имя руководителя проекта
    public function getUserNameAttribute($value) {
        $user_name = null;
        if ($this->user)
            $user_name = $this->user->fio;
        return $user_name;
    }

    // взятие состояния
    public function getStateNameAttribute($value) {
        $state_name = null;
        if ($this->state)
            $state_name = $this->state->state;
        return $state_name;
    }

    public function tags() {
        return $this->belongsToMany('App\Tag'); /// ??
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function type() {
        return $this->belongsTo('App\Type');
    }

    public function state() {
        return $this->belongsTo('App\State');
    }

    public function candidates() {
        return $this->hasMany('App\Candidate','project_id');
    }

}
