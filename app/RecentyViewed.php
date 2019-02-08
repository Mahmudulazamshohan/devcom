<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecentyViewed extends Model
{
	protected $table ='recenty_vieweds';
    protected $fillable =['user_id','board_id'];
    public function team_board(){
    	return $this->hasOne('App\TeamBoard','board_id','board_id');
    }
}
