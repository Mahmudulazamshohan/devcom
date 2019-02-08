<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BoardListCard;
class BoardList extends Model
{
    protected $fillable = [
        'user_id',
		'board_id',
		'board_list_id',
		'board_list_title',
    ];
    protected $hidden = ['id','created_at','updated_at'];

    public function boardListCards(){
    	return BoardListCard::where('board_list_id',$this->board_list_id)->get();
    }
   

}
