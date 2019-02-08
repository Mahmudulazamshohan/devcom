<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
   protected $fillable =['id',
				'user_id',
				'added_by',
				'notfication_string',
				'view_status',
				'action'
			];
	public function profile(){
		return $this->hasOne('App\Profile','user_id','added_by');
	}		
}
