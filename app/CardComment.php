<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardComment extends Model
{
    protected $fillable = [
        'user_id',
		'board_list_id',
		'comment_text',	
    ];
    
    public function user(){
    	return $this->hasOne('App\User','id','user_id');
    }
    public function profile(){
    	return $this->hasOne('App\Profile','user_id','user_id');
    }
}
