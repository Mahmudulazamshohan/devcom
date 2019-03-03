<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamBoardUsers extends Model
{
    protected $fillable = ['board_id',
							'user_id',
							'active_status',
							'add_by',
							'permission_role'];
	public function profile(){
		return $this->hasOne('App\Profile','user_id','user_id');
	}	
	public function user(){
		return $this->hasOne('App\User','id','user_id');
	}
	public function team_board(){
		return $this->hasOne('App\TeamBoard','board_id','board_id');
	}					
}
