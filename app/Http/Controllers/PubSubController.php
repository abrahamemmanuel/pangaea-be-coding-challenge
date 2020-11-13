<?php

namespace App\Http\Controllers;

use App\Event;
use App\Jobs\PubSubJob;
use App\Topic;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

/**
 * author: Emmanuel Abraham
 * email: sundayemmanuelabraham@gmail.com
 * sugnature: iamaprogrammer
 * dated: 10th - 12th November, 2020
 * Location: Lagos, Niigeria
 */
class PubSubController extends Controller
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
   'topic' => $topic->topic,
   'data'  => [
    'message' => $topic->message,
   ],
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

  //intantiate a new event class
  $event = new Event();

  //set subscription url
  $event->url      = $request->url;
  $event->topic_id = $topic->id;

  //save to event subscription
  $event->save();

  //invoke the http request helper fucntion
  $this->httpForwarder($topic->message, $topic->topic);
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

  //invoke the http request helper fucntion
  $this->httpForwarder($topic->message, $topic->topic);

  //forward data to all of the currently subscribed URL's for this topic.
  //defer the task to Job:queue
  $this->job($topic->message, $topic->topic);

 }

 //this method handles the display of the data passed to the /event end-point
 public function eventTrigger(Request $request)
 {
  return response([
   'topic' => $request->topic,
   'data'  => [
    'message' => $request->message,
   ],
  ]);
 }

 //http request helper function
 public function httpForwarder($message, $topic)
 {
  //forward data to /event endpoint to print the data and verify everything is working.
  //should you test on your machine without a virtual host, then set base URL to http://localhost:8000/
  $client = new Client(['base_uri' => 'http://pangaea.test/']);

  $options = [
   'json' => [
    'message' => $message,
    'topic'   => $topic,
   ],
  ];

  $response = $client->post('event', $options);

  echo $response->getBody();
 }

 //job helper fucntion that handles forwarding of data to multiple events url
 public function job($message, $topic)
 {
//deffer this task: delegating to Queue worker
  PubSubJob::dispatch($message, $topic)
   ->delay(Carbon::now()->addSeconds(5));
 }
}