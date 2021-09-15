<?php

namespace App\Model\User;
class Main extends Model
{

    protected $table = 'user_permissions';

    public function permission(){
        return $this-> belongsTo('App\Model\User\Permission', 'permission_id');
    }

    public function user (){
        return $this-> belongsTo('App\Model\User\Permission', 'user_id');
    }
}