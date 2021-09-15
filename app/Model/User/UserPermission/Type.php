<?php 

namespace App\Model\User\UserPermission;
use Illuminate\Database\Eloquent\Model;

class Type extends Model 
{
    protected $table = 'permission_type';

    public function permissions(){

        return $this->hasMany('App\Model\User\UserPermission', 'type_id');
        
    }
}