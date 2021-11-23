<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //public $timestamps = false;
    protected $fillable = ['title','places','goal','idea','difficulty','date_start','date_end',
        'requirements','customer','expected_result','additional_inf', 'supervisor_id', 'state_id','type_id'];
    public const CREATED_AT = null; // выключение created_at, однако updated_at будет существовать
    protected $hidden = ['supervisor', 'type','state','error_message','is_scanned']; 
    protected $appends = ['tags', 'type_name','supervisor_name','vacant_places','state_name']; // дополнительные свойства


    // взятие типа
    public function getTypeNameAttribute($value) {
        $type_name = null;
        if ($this->type)
            $type_name = $this->type->type;
        return $type_name;
    }

    // взятие вакантных (свободных) мест
    public function getvacantPlacesAttribute($value) {
        $id_activeState = StateParticipation::where('state', 'Участвует')->select('id')->get()[0]['id'];
        return $this->places - Participation::where('id_project', $this->id)->where('id_state', $id_activeState)->count();
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
    
    public function getTagsAttribute($value) {
        return ProjectTag::join('tags','tags.id','=','project_tags.tag_id')->select('tag_id as id', 'tag')->where('project_id', $this->id)->get();
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
