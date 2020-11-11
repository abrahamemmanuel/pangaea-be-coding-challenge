<?php

namespace App\Http\Controllers;

use App\Event;
use App\Topic;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TopicController extends Controller
{

/**
 * Display the specified resource
 *
 * @param  \App\Model\Topic  $topic
 * @return \Illuminate\Http\Response
 */
 public function store(Request $request)
 {
  //instantiate a new Topic class
  $topic = new Topic();

  //assign the request param to the $topic object
  $topic->topic = $request->topic;

  //save topic into database
  $topic->save();

  return response([
   $topic,
  ]);
 }

 /**
  * @param  \App\Model\Topic  $topic
  * @return \Illuminate\Http\Response
  */
 public function subscribe(Request $request, $id)
 {
  //find topic by topic id
  $topic = Topic::find($id);

  //set event for the topic subscription
  $event = Event::all()->where('event', $request->event)->first();
  //set subscription url
  $topic->url = 'http://menskin.test/' . $event->event;
  //save to DB
  $topic->save(['topic' => $topic]);

  //forward data
  $client  = new Client(['base_uri' => 'http://menskin.test/']);
  $options = [
   'json' => [
    'url'     => $topic->url,
    'topic'   => $topic->topic,
    'message' => $topic->message,
   ],
  ];
  $response = $client->post('event', $options);

  echo $response->getBody();
 }

 /**
  * @param  \App\Model\Topic  $topic
  * @return \Illuminate\Http\Response
  */
 public function publish(Request $request, $id)
 {
  //find topic by topic id
  $topic = Topic::find($id);
  //set message
  $topic->message = $request->message;

  //save to DB
  $topic->save(['topic' => $topic]);

  //forward data
  $client  = new Client(['base_uri' => 'http://menskin.test/']);
  $options = [
   'json' => [
    'message' => $topic->message,
    'topic'   => $topic->topic,
    'url'     => $topic->url,
   ],
  ];
  $response = $client->post('event', $options);

  echo $response->getBody();

 }

 //this method handles the display of the data passed to the /event end-point
 public function eventTrigger(Request $request)
 {
  return response([
   'topic' => $request->topic,
   'data'  => [
    'message' => $request->message,
    'url'     => $request->url,
   ],
  ]);
 }
}