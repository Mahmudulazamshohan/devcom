<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestScore extends Model
{
    protected $fillable =  ['user_id',
							'title',
							'score'];
}
