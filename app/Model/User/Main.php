<?php 

namespace App\Model\User;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Main extends Authenticatable
{

    use Notifiable;

    protected $table  ='user';

    protected $fillable = [
        'name','email','password',
    ];

    protected $hidden = [
        'password','remember_token','goodle2fa_secret', 'telegram_chat_id',
    ];

    public function type(){
        return $this->belongsTo('App\Model\User\Type', 'type_id');
    }
    
    public function country()
    {
        return $this->belongsTo('App\Model\Setup\Country', 'country_id');
    }

    public function province(){
        return $this->belongsTo('App\Model\Setup\Province', 'province_id');
    }

    public function logs(){
        return $this->hasMany('App\Model\User\Log', 'user_id');
    }

    public function admin(){
        return $this->hasOne('App\Model\Admin\Admin', 'user_id');
    }

    public function customer(){
        return $this->hasOne('App\Model\Customer\Customer', 'user_id');
    }
}
