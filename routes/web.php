<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();
//---------------------------------------------------------------------------------
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
Route::get('/test-question/{name}', 'Main\MainController@testQuestion')->name('test-question');

Route::get('/test-question-category', 'Main\MainController@testQuestionCategory')->name('test-question-category');
Route::get('/achievements', 'Main\MainController@achievements')->name('achievements');
Route::get('/notifications', 'Main\MainController@notifications')->name('notifications');
Route::get('/my-questions', 'Main\MainController@myQuestions')->name('my-questions');
Route::get('/my-answers', 'Main\MainController@myAnswers')->name('my-answers');
//Answer Route
Route::post('/store-answer', 'Main\MainController@storeAnswer')->name('store-answer');
Route::get('/most-answered', 'Main\MainController@mostAnswered')->name('most-answered');

Route::get('/tags', 'HomeController@tagsShow')->name('tagsshow');
Route::get('/users', 'HomeController@users')->name('users');
Route::get('/top-users', 'HomeController@topUsers')->name('top-users');


//Team Managerment
Route::prefix('team')->group(function(){
   Route::get('/home', 'TeamController@home')->name('team.home');
   Route::get('/board/{id}/{name}', 'TeamController@board')->name('team.board');
   Route::get('/add-board', 'TeamController@addBoard')->name('team.add-board');
   Route::get('/members', 'TeamController@members')->name('team.members');
   Route::post('/add-board','TeamController@storeBoard')->name('team.store-board');
 
});

Route::get('/ajax_vote', 'HomeController@ajaxVote')->name('ajax_vote');
Route::get('/ajax_vote_delete', 'HomeController@ajaxVoteDelete')->name('ajax_vote_delete');
Route::get('/bookmark-add/{id}','Main\MainController@bookmarkStore')->name('bookmark-add');
Route::get('/team_file/{file}/{type}','Main\MainController@teamFiles')->name('team_file');

//Team Api
Route::get('search','HomeController@apiSearch')->name('api.search');
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



