<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\TeamBoard;
use Auth;
use App\Profile;
use App\BoardList;
use App\TeamBoardUsers;
use App\BoardListCard;
use App\User;
use App\CardComment;
use App\RecentyViewed;
use App\Notification;
class TeamController extends Controller
{

   public function __construct(){
   	$this->middleware('auth');
   }
    public function home(){
    	$team = TeamBoard::where('user_id',Auth::id())
                         ->get();
        $teamBoardUsers = TeamBoardUsers::where('user_id',Auth::id())
                                        ->get(); 
        $recentViewed = RecentyViewed::where('user_id','=',Auth::id())
                                    ->orderBy('created_at','desc')
                                    ->get();

        $c= collect($recentViewed)->unique('board_id')
                                  ->slice(0,3);

                                  

    	return view('team.main',['team_boards'=>$team,'teamBoardUsers' =>$teamBoardUsers,'recenty_viewes'=>$c->values()->all()]);
    }
    public function board($id,$name){
        if(TeamBoardUsers::where('board_id',$id)->where('user_id',Auth::id())->first() == null){
           return redirect()->route('team.home'); 
        }
    	$board = TeamBoard::where('board_id',$id)
                          ->where('board_title',$name)
                          ->first();
        RecentyViewed::create([
            'user_id'=>Auth::id(),
            'board_id'=>$id
        ]);
       
                         
    	if($board){
    		return view('team.board',['id'=>$id,'name'=>$name]);
    	}else{
    		return redirect()->route('team.home');
    	}
    }
    public function addBoard(){
    	return view('team.add-board');
    }
    public function storeBoard(Request $r){
    	$this->validate($r,[
    		'title'=>'required|string|min:6'
    	]);
    	$teamboard = TeamBoard::create([
			    		'user_id'=>Auth::id(),
			    		'board_id'=>$this->generateRandomString(),
			    		'board_title'=>$r->title
			    	]);
    	$b1 = BoardList::create([
	    		'user_id'=>Auth::id(),
				'board_id'=>$teamboard->board_id,
				'board_list_id'=>$this->generateRandomString(),
				'board_list_title'=>'Todos',
	    	]);
    	$b2 = BoardList::create([
	    		'user_id'=>Auth::id(),
				'board_id'=>$teamboard->board_id,
				'board_list_id'=>$this->generateRandomString(),
				'board_list_title'=>'In Progress',
	    	]);
    	$b3 = BoardList::create([
	    		'user_id'=>Auth::id(),
				'board_id'=>$teamboard->board_id,
				'board_list_id'=>$this->generateRandomString(),
				'board_list_title'=>'Done',
	    	]);
    	if($teamboard && $b1 && $b2 && $b3){
    		TeamBoardUsers::create([
    			'board_id'=>$teamboard->board_id,
    			'user_id'=>Auth::id(),
    			'active_status'=>1,
                'add_by'=>Auth::id(),
    			'permission_role'=>1,
    		]);
    		return redirect()->back()
    		                 ->with('message','Board Created successfully')
    		                 ->with('type','success');
    	}else{
    		return redirect()->back()
    		                 ->with('message','Board Created successfully')
    		                 ->with('type','danger');
    	}
    }
    public function boardAll($id){
    	$boardLists = BoardList::where('board_id',$id)->get();
    	$data = [];
    	$items = null;
        //Loop Started
    	foreach ($boardLists as $key => $boardList) {
    		$boardListCards = BoardListCard::where('board_list_id',$boardList->board_list_id)->get();
    		$items_array= [];
    		//var_dump($boardListCards);
    		foreach($boardListCards  as $boardListCard){
    			$source = "";
    			if($boardListCard->item_type == 'image'){
    			   $source =route('team_file',[explode('/',$boardListCard->item_src)[1],$boardListCard->item_type]) ;
    			}else{
    				$source = $boardListCard->item_src;
    			}

                $imageLocation = !is_null($boardListCard->profile) ? route('view-image',[explode('/',$boardListCard->profile->profile_image)[1],100,100]) : 'http://127.0.0.1/devcom/public/images/user-blank.png';
    			$items = [
		               		'item_name'=>'shohan',
		               		'item_type'=>$boardListCard->item_type,
			   	            'item_src'=>$source,
			   	            'user_id'=>$boardListCard->user_id,
                            'board_list_id'=>$boardListCard->board_list_id,
                            'board_unique_id'=>$boardListCard->id,
                            'item_description'=>$boardListCard->item_description,
                            'id'=>$boardListCard->id,
                            'image_url'=>$imageLocation,
                            'user_name'=>!is_null($boardListCard->user) ? $boardListCard->user->name : 'http://127.0.0.1/devcom/public/images/user-blank.png',
                            'comments'=>[]
		             ];
		         
		       //Pushing Array into arrays 
		       array_push($items_array, $items);
		       

    		} 	
    		$data[] = [
    			'card_title'=>$boardList->board_list_title,
    			'card_title_editable'=>true,
		        'add_new_card'=>false,
    			'user_id'=>$boardList->user_id,
    			'board_id'=>$boardList->board_id,
    			'board_list_id'=>$boardList->board_list_id,
    			'card_items'=>$items_array,
    		];
    	}
    	//Loop Ended
    	
    	return response()->json($data);
    }
    public function generateRandomString($length = 10) {
       return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
    public function createBoard(Request $r){

    }



    public function jsonBoard($id,$name){
    	   $b = BoardList::create([
		    	   	'user_id'=>1,
		    	   	'board_id'=>$id,
		    	   	'board_list_id'=>$this->generateRandomString(),
		    	   	'board_list_title'=>$name
		    	   ]);

			$data = [
				     'card_title'=>$b->board_list_title,
		             'card_title_editable'=>true,
		             'add_new_card'=>false,
		             'card_postion'=>1,
		             'card_items'=>[]
                 ];
    	return response()->json(['cards'=>$data]);
    }
    public function storeCard(Request $r){
    	$file = $r->file('video');
    	$fileExtension = $r->file('video')->getClientOriginalExtension();
    	$location = null;
    	if($r->hasFile('video')){
    	  $location = Storage::put('/files',$file);	
    	}
    
    	$fileTypeHeaders = "";
    	switch ($fileExtension) {
    		case 'png':
    			$fileTypeHeaders = "image";
    			break;
    		case 'jpg':
    			$fileTypeHeaders = "image";
    			break;
    		case 'jpeg':
    			$fileTypeHeaders = "image";
    			break;
    		case 'gif':
    			$fileTypeHeaders = "image";
    			break;
    		
    		default:
    			$fileTypeHeaders = "file";
    			break;
    	}
		$boardListCard = BoardListCard::create([
						        'user_id'=>Auth::id(),
						        'board_id'=>$r->board_id,
						        'board_list_id'=>$r->board_list_id,
						        'item_type'=>$fileTypeHeaders,
						        'item_src'=>$location,
						        'item_add_by'=>Auth::id(),
						    ]);

    	$card_items = [
		               		'item_name'=>explode('/',$location)[1],
		               		'item_type'=>$boardListCard->item_type,
			   	            'item_src'=>route('team_file',[explode('/',$location)[1],$fileTypeHeaders]),
			   	            'user_id'=>1
		               	];
    	return response()->json(['card_items'=>$card_items],200);
    }
    public function boardDataText(Request $r){
    	$boardListCard = BoardListCard::create([
						        'user_id'=>Auth::id(),
						        'board_id'=>$r->board_id,
						        'board_list_id'=>$r->board_list_id,
						        'item_type'=>'text',
						        'item_src'=>$r->card_title,
						        'item_add_by'=>Auth::id(),
						    ]);
    	return response()->json([
    		'item_name'=>'Shohan',
	        'item_type'=>'text',
	   	    'item_src'=>$boardListCard->item_src,
	   	    'item_added'=>'Shohan',
	   	    'user_id'=>$boardListCard->user_id
    	]);
    }
    public function saveBoardListDescription(Request $r){
       $boardListCard = BoardListCard::where('id',$r->id)
                                     ->update([
                                        'item_description'=>$r->description
                                      ]);
       if($boardListCard)
         return response()->json(['success'=>true,'id'=>$r->id,'description'=>$r->description]); 
    }
    public function searchUsers(Request $r){
       $users =  User::where('name','like','%'.$r->q.'%')
                    ->orWhere('email','like','%'.$r->q.'%')
                    ->get();
        $data = [];
        foreach($users as $user){
            if($user->id != Auth::id()){
                $imageFileLocation = asset('images/user-blank.png');
                if(!is_null($user->profile)){
                  if(strlen($user->profile->profile_image) > 0){
                     $imageFileLocation = !is_null($user->profile)?$user->profile->profile_image : '';
                      $imageFileLocation = explode('/',$imageFileLocation)[1];
                      $imageFileLocation = route('view-image',[$imageFileLocation,100,100]); 
                  }
                
                }
                $change_icon = false;
                if(TeamBoardUsers::where('board_id',$r->board_id)->where('user_id',$user->id)->first()){
                    $change_icon = true;

                }
                
                $arr = ['id'=>$user->id,
                        'user_name'=>$user->name,
                        'change_icon'=>$change_icon,
                        'image_url'=>$imageFileLocation
                        ];
                array_push($data, $arr);  
            }
            
        }            
       return response()->json($data);
    }
    public function addBoardMembers(Request $r){
        $teamBoardUsers = null;
        if(TeamBoardUsers::where('board_id',$r->board_id)->where('user_id',$r->user_id)->first() == null){
          $teamBoardUsers =   TeamBoardUsers::create(['board_id'=>$r->board_id,
                                                    'user_id'=>$r->user_id,
                                                    'add_by'=>Auth::id(),
                                                    'active_status'=>0,
                                                    'permission_role'=>0]);
          $notificationString = Auth::user()->name." added a you in board ".$teamBoardUsers->team_board->board_title;

          $notification = Notification::create([
                                            'user_id'=>$teamBoardUsers->user_id,
                                            'notfication_string'=>$notificationString,
                                            'view_status'=>0
                                          ]); 
           $notification->action = $notification->id;
           $notification->save();
                                                                                   
        }
        
        return response()->json($teamBoardUsers);
    }
     public function deleteBoardMembers(Request $r){
        $teamBoardUsers =   TeamBoardUsers::where('board_id',$r->board_id)->where('user_id',$r->user_id)->delete();
        return response()->json(['success'=>$teamBoardUsers]);
    }
    public function boardUsers(Request $r){
        $teamBoardUsers = TeamBoardUsers::where('board_id',$r->board_id)->get();
        $data = [];
        foreach($teamBoardUsers as $teamBoardUser){
                $imageFileLocation = null;
                if(!is_null($teamBoardUser->profile)){
                  $imageFileLocation = !is_null($teamBoardUser->profile)?$teamBoardUser->profile->profile_image : '';
                  $imageFileLocation = explode('/',$imageFileLocation)[1];
                  $imageFileLocation = route('view-image',[$imageFileLocation,100,100]);  
                }
            $arr = [
                'id'=>$teamBoardUser->id,
                'user_id'=>$teamBoardUser->user_id,
                'image_url'=>$imageFileLocation,

            ];
            array_push($data, $arr);
        }

        return response()->json($data);
    }
    public function addCardComments(Request $r){
        $cardComment = CardComment::create([
                                    'user_id'=>Auth::id(),
                                    'board_list_id'=>$r->board_list_id,
                                    'comment_text'=>$r->comment_text, 
                                ]);
        $imageFileLocation = null;
        if(!is_null($cardComment->profile)){
          $imageFileLocation = !is_null($cardComment->profile)?$cardComment->profile->profile_image : '';
          $imageFileLocation = explode('/',$imageFileLocation)[1];
          $imageFileLocation = route('view-image',[$imageFileLocation,100,100]);  
        }
        $data = [
             'user_id'=>$cardComment->user_id,
            'board_list_id'=>$cardComment->board_list_id,
            'user_name'=>$cardComment->user->name,
            'image_url'=>$imageFileLocation,
            'comment_text'=>$cardComment->comment_text
        ];
        return response()->json($data);
    }
    public function cardComments(Request $r){
        $cardComments = CardComment::where('board_list_id',$r->board_list_id)->orderBy('id','desc')->get();
         $data = [];
         foreach($cardComments as $cardComment){
            $imageFileLocation = null;
                if(!is_null($cardComment->profile)){
                  $imageFileLocation = !is_null($cardComment->profile)?$cardComment->profile->profile_image : '';
                  $imageFileLocation = explode('/',$imageFileLocation)[1];
                  $imageFileLocation = route('view-image',[$imageFileLocation,100,100]);  
                }
            $arr = [
                'user_id'=>$cardComment->user_id,
                'board_list_id'=>$cardComment->board_list_id,
                'user_name'=>$cardComment->user->name,
                'image_url'=>$imageFileLocation,
                'comment_text'=>$cardComment->comment_text
            ];
            array_push($data, $arr);
         }                          
       return response()->json($data);                         
    }
    public function changeCardTitle(Request $r){
        $boardList = BoardList::where('board_list_id',$r->board_list_id)
                              ->update([
                                'board_list_title'=>$r->board_list_title
                               ]);
      return response()->json([
                             'success'=>$boardList
                             ]);                        
    }
    public function editTitle(Request $r){
                $boardList = BoardList::where('board_list_id',$r->board_list_id)->update([
                            'board_list_title'=>$r->card_title
                         ]);
        return response()->json(['success'=>$boardList]);
    }
    public function members(){
        return view('team.members');
    }
}


