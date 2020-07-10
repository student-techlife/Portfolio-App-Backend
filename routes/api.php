<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//user
Route::post('login','Api\AuthController@login');
Route::post('register','Api\AuthController@register');
Route::get('logout','Api\AuthController@logout');
Route::post('save_user_info','Api\AuthController@saveUserInfo')->middleware('jwtAuth');

//project
Route::post('projects/create','Api\ProjectsController@create')->middleware('jwtAuth');
Route::post('projects/delete','Api\ProjectsController@delete')->middleware('jwtAuth');
Route::post('projects/update','Api\ProjectsController@update')->middleware('jwtAuth');
Route::get('projects','Api\ProjectsController@projects')->middleware('jwtAuth');
Route::get('projects/my_projects','Api\ProjectsController@myProjects')->middleware('jwtAuth');


//comment
Route::post('comments/create','Api\CommentsController@create')->middleware('jwtAuth');
Route::post('comments/delete','Api\CommentsController@delete')->middleware('jwtAuth');
Route::post('comments/update','Api\CommentsController@update')->middleware('jwtAuth');
Route::post('projects/comments','Api\CommentsController@comments')->middleware('jwtAuth');


//like
Route::post('projects/like','Api\LikesController@like')->middleware('jwtAuth');
