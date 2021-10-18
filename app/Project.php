<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //public $timestamps = false;
    protected $fillable = ['title','places','goal','idea','difficulty','date_start','date_end',
        'requirements','customer','expected_result','additional_inf'];
    public const CREATED_AT = null; // выключение created_at, однако updated_at будет существовать
    protected $hidden = ['supervisor','type','state','error_message','is_scanned','supervisor_id','type_id','state_id']; 
    protected $appends = ['type_name','supervisor_name','vacant_places','state_name']; // дополнительные свойства


    // взятие типа
    public function getTypeNameAttribute($value) {
        $type_name = null;
        if ($this->type)
            $type_name = $this->type->type;
        return $type_name;
    }

    // взятие вакантных (свободных) мест
    public function getvacantPlacesAttribute($value) {
        return $this->places; //- $this->candidates()->where('is_mate', 1)->count();
    }

    // взятие имя руководителя проекта
    public function getSupervisorNameAttribute($value) {
        $user_name = null;
        if ($this->supervisor)
            $user_name = $this->supervisor->fio;
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

    public function supervisor() {
        return $this->belongsTo('App\Supervisor');
    }

    public function type() {
        return $this->belongsTo('App\Type');
    }

    public function state() {
        return $this->belongsTo('App\State');
    }

    public function candidates() {
        return $this->hasMany('App\Participation','id_project');
    }

}
