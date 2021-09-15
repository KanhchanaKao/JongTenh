<?php

namespace App\Model\User;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
   
    protected $table = 'permissions';

    public function userPermissions(){
        return $this->hasMany('App\Model\User\UserPermission\Main', 'permission_id');
    }

    public function type(){
        return $this->belongsTo('App\Model\User\UserPermission\Type', 'type_id');
    }
   
}
