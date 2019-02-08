<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoardListCard extends Model
{
    protected $fillable = [
        'user_id',
		'board_id',
		'board_list_id',
		'item_type',
		'item_src',
		'item_description',
		'item_add_by',
    ];
    protected $hidden = ['user_id','created_at','updated_at'];
    public function profile(){
    	return $this->hasOne('App\Profile','user_id','user_id');
    }
    public function user(){
    	return $this->hasOne('App\User','id','user_id');
    }

}
