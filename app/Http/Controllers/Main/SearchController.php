<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
	private $ajaxResponseError ;
     public function __construct(){
     	$this->ajaxResponseError =['error_message'=>'This is not ajax request'];
     	$this->middleware('auth');
     }
     public function searchPages(Request $r){
       if($r->ajax()){

       }else{
       	 return response()->json($this->ajaxResponseError);
       }
     }

     
}
