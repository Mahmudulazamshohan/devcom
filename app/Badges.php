<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Badges extends Model
{
    protected $fillable =  ['badge_name',
                            'category',
							'points',
							'badge_title',
							'badge'];
}
