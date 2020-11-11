<?php

use Illuminate\Support\Facades\Route;

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
 return view('welcome');
});

//route to create event
Route::post('/event/create', 'EventController@store');
//route to create topic
Route::post('/topic/create', 'TopicController@store');
//route to subcribe to an event
Route::post('/subscribe/{topic}', 'TopicController@subscribe');
//route to publish topic
Route::post('/publish/{topic}', 'TopicController@publish');
//route to view event
Route::post('/event', 'TopicController@eventTrigger');