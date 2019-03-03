<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentInterested extends Model
{
    protected $fillable =['user_id','question_categories_as_text'];
}
