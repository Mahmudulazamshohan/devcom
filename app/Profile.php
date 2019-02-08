<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
	protected $table ='profiles';

	protected $fillable =['id',
				'user_id',
				'profile_image',
				'employment',
				'education',
				'location',
				'language'];
	public function user(){
		return $this->hasOne('App\User','id','user_id');
	}
}
