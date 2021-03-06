<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;
class RegistRecord extends Model
{

     protected $table = 'registrecords';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'activity_id','user_id','status','serial', 'formdata','confirm_type'
   ];


    //uuid for key operation 
    //https://github.com/webpatser/laravel-uuid

    /**
    *  Setup model event hooks
    */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    /**
    * Get the route key for the model.
    *
    * @return string
    */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function Activity(){
        return $this->hasOne('App\Activity', 'id','activity_id');
    }


    public function User(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
