<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamBoard extends Model
{
     protected $fillable = [
        'user_id', 'board_id', 'board_title',
    ];
    public function user(){
    	return $this->hasOne('App\User','id','user_id');
    }
}
