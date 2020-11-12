<?php
/**
 * author: Emmanuel Abraham
 * email: sundayemmanuelabraham@gmail.com
 * sugnature: iamaprogrammer
 * dated: 10th - 12th November, 2020
 * Location: Lagos, Niigeria
 */
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

// Route::get('/', function () {
//  return view('welcome');
// });

//route to create topic
Route::post('/topic/create', 'PubSubController@store');
//route to subcribe to an event
Route::post('/subscribe/{topic}', 'PubSubController@subscribe');
//route to publish topic
Route::post('/publish/{topic}', 'PubSubController@publish');
//route to view event
Route::post('/event', 'PubSubController@eventTrigger');