<?php

/*
|-----------------------Web Route----------------------------
|------------------------------------------------------------
*/
/*
 | Authorization Routes
 */
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/tags/{tags}', 'HomeController@tags')->name('tags');
Route::get('/add-question', 'Main\MainController@addQuestion')->name('add-question');
Route::get('/view-question/{id}', 'HomeController@viewQuestion')->name('view-question');
Route::post('/store-question', 'Main\MainController@storeQuestion')->name('store-question');
Route::get('/edit-question/{id}', 'Main\MainController@editQuestion')->name('edit-question');
Route::post('/update-question', 'Main\MainController@updateQuestion')->name('update-question');
Route::get('/profile', 'Main\MainController@profiles')->name('profile');
Route::post('/store-profile', 'Main\MainController@storeProfile')->name('store-profile');
Route::get('/view-image/{filename}/{width}/{height}', 'HomeController@viewImage')->name('view-image');
Route::get('/test-question/{name}/{title}', 'Main\MainController@testQuestion')->name('test-question');
Route::get('/test-question-category', 'Main\MainController@testQuestionCategory')->name('test-question-category');
Route::get('/achievements', 'Main\MainController@achievements')->name('achievements');
Route::get('/notifications', 'Main\MainController@notifications')->name('notifications');
Route::get('/my-questions', 'Main\MainController@myQuestions')->name('my-questions');
Route::get('/my-answers', 'Main\MainController@myAnswers')->name('my-answers');
Route::get('/extend-bookmarks', 'Main\MainController@extendBookmarks')->name('extend-bookmarks');
//Answer Route
Route::post('/store-answer', 'Main\MainController@storeAnswer')->name('store-answer');
Route::get('/most-answered', 'HomeController@mostAnswered')->name('most-answered');

Route::get('/most-visited', 'HomeController@mostVisited')->name('most-visited');
Route::get('/tags', 'HomeController@tagsShow')->name('tagsshow');
Route::get('/users', 'HomeController@users')->name('users');
Route::get('/top-users', 'HomeController@topUsers')->name('top-users');

//Extra
Route::get('/email-support', 'Main\MainController@emailSupport')->name('email-support');

Route::get('/faqs', 'Main\MainController@faqs')->name('faqs');

//Notification Action
Route::get('/join-team','Main\MainController@joinTeam')->name('join-team');


//Team Managerment
Route::prefix('team')->group(function(){
   Route::get('/home', 'TeamController@home')->name('team.home');
   Route::get('/board/{id}/{name}', 'TeamController@board')->name('team.board');
   Route::get('/add-board', 'TeamController@addBoard')->name('team.add-board');
   Route::get('/members/{id}', 'TeamController@members')->name('team.members');
   Route::post('/add-board','TeamController@storeBoard')->name('team.store-board');
});

Route::get('/ajax_vote', 'HomeController@ajaxVote')->name('ajax_vote');
Route::get('/ajax_vote_delete', 'HomeController@ajaxVoteDelete')->name('ajax_vote_delete');
Route::get('/bookmark-add/{id}','Main\MainController@bookmarkStore')->name('bookmark-add');
Route::get('/team_file/{file}/{type}','Main\MainController@teamFiles')->name('team_file');

//Team Api
Route::get('search','HomeController@apiSearch')->name('api.search');
Route::get('search/{q}','HomeController@searchMore')->name('search-more');
Route::get('board/{id}/{name}','TeamController@jsonBoard')->name('api.board');
Route::get('board-all/{id}','TeamController@boardAll')->name('api.board-all');
//Route::get('create-board','TeamController@createBoard')->name('api.create-board');
Route::post('board','TeamController@storeCard')->name('api.store-board');
Route::post('board-data-text','TeamController@boardDataText')->name('api.board-data-text');
Route::get('/save-board-list-description','TeamController@saveBoardListDescription')->name('save-board-list-description');
Route::get('/search-users','TeamController@searchUsers')->name('search-users');
Route::get('/add-board-members','TeamController@addBoardMembers')->name('add-board-members');

Route::get('/delete-board-members','TeamController@deleteBoardMembers')->name('delete-board-members');
Route::get('/board-users','TeamController@boardUsers')->name('board-users');
Route::get('/add-card-comments','TeamController@addCardComments')->name('add-card-comments');
Route::get('/card-comments','TeamController@cardComments')->name('card-comments');
Route::get('/change-card-title','TeamController@changeCardTitle')->name('change-card-title');
Route::get('/edit-title','TeamController@editTitle')->name('edit-title');

//Question Api
Route::get('question-api','PersonController@questionApi')->name('api.question-api');
Route::get('question-score','PersonController@storeScore')->name('api.question-score');
//--------------
Route::prefix('admin')->group(function(){
   //Admin Authentications
  Route::get('login','AdminAuth\AuthController@showLoginForm')->name('admin.login')->middleware('guest:admin');
  
  Route::post('login','AdminAuth\AuthController@authenticate')->name('admin.authenticate-login');
   Route::post('logout','AdminAuth\AuthController@logout')->name('admin.authenticate-logout');
  //Admin Dashboard
  Route::get('dashboard','AdminController@dashboard')->name('admin.dashboard');
  Route::get('add-question','AdminController@addQuestion')->name('admin.add-question');
  Route::post('store-question','AdminController@storeQuestion')->name('admin.store-question');
   Route::get('view-question','AdminController@viewQuestion')->name('admin.view-question');
   
     Route::get('question-category-view','AdminController@questionCategoryView')->name('admin.question-category-view');
    
     Route::get('add-question-category','AdminController@addQuestionCategory')->name('admin.add-question-category');
     Route::post('store-question-category','AdminController@storeQuestionCategory')->name('admin.store-question-category');
});

use App\Badges;
use App\Answer;
use App\Achievements;

Route::get('badge',function(){

 //   Badges::create([
 //   	'badge_name'=>'Good Answer',
 //   	'category'=>'a',
 // 'points'=>25,
 // 'badge_title'=>'Answer score of 25 or more',
 // 'badge'=>'silver'
 //   ]);
 //   Badges::create([
 //   	'badge_name'=>'Great Answer',
 //   	'category'=>'a',
 // 'points'=>100,
 // 'badge_title'=>'Answer score of 100 or more',
 // 'badge'=>'silver'
 //   ]);
 $c = Answer::where('user_id',Auth::id())->count();
 $badge = Badges::where('category','a')->where('points',$c)->first();
 Achievements::truncate();
 if($badge){
    	
    $a = Achievements::create([
    	'user_id'=>Auth::id(),
    	'badge_name'=>$badge->badge_name,
    	'points'=>$badge->points,
    	'badge'=>$badge->badge
    ]);

    dd($a);
 }

          
});



