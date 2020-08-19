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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     dd("Het werkt!");
// });

Route::middleware('auth:api')->group(function () {
    // User
    Route::post('save_user_info','Api\AuthController@saveUserInfo');
    Route::post('logout','Api\AuthController@logout');
    Route::get('user', 'Api\AuthController@getUserInfo');
    
    // project
    Route::post('projects/create','Api\ProjectsController@create');
    Route::post('projects/delete','Api\ProjectsController@delete');
    Route::post('projects/update','Api\ProjectsController@update');
    Route::get('projects','Api\ProjectsController@projects');
    Route::get('projects/my_projects','Api\ProjectsController@myProjects');
    
    //comment
    Route::post('comments/create','Api\CommentsController@create');
    Route::post('comments/delete','Api\CommentsController@delete');
    Route::post('comments/update','Api\CommentsController@update');
    Route::post('projects/comments','Api\CommentsController@comments');

    //like
    Route::post('projects/like','Api\LikesController@like');
});


// user (without authentication)
Route::post('login','Api\AuthController@login');
Route::post('register','Api\AuthController@register');
Route::post('refresh', 'Api\AuthController@refresh');