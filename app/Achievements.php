<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Achievements extends Model
{
    protected $fillable =  [
    	                    'user_id',
    	                    'badge_name',
							'points',
							'badge'];
}
