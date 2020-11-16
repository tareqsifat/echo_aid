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

Route::get('/', function () {

    $posts = DB::table('posts')
    ->leftJoin('profiles', 'profiles.user_id', 'posts.user_id')
    ->leftJoin('users','users.id','posts.user_id')
    ->get();
    return view('welcome', compact('posts'));
});

Route::get('count', function() {
    $notification = DB::table('notifications')
    ->where('user_to', Auth::user()->id)
    ->get();
    dd($notification);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    
    Route::get('profile/{slug}', 'ProfileController@index')->name('profile');

    Route::get('/changePhoto', 'ProfileController@changePhoto');

    Route::post('/uploadPhoto', 'ProfileController@uploadPhoto');

    Route::get('editProfile', 'ProfileController@editProfile');

    Route::post('/updateProfile','ProfileController@updateProfile');

    Route::get('/findFriends', 'HomeController@findFriends');

    Route::get('addFriend/{id}', 'ProfileController@addFriend'); 

    Route::get('/requests', 'ProfileController@requests');

    Route::get('/accept/{id}','ProfileController@accept');

    Route::get('friends','ProfileController@friends');

    Route::get('removeRequest/{id}', 'ProfileController@removeRequest');

    Route::get('/notifications/{id}', 'profileController@notifications');

    Route::get('unfriend/{id}', 'profileController@unfriend');
});

Route::get('posts', 'postsController@index');
