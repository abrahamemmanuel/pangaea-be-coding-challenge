<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
 /**
  * Display the specified resource
  *
  * @param  \App\Model\Event  $event
  * @return \Illuminate\Http\Response
  */
 public function store(Request $request)
 {
  //instantiate a new Event class
  $event = new Event();

  //assign the request param to the $event object
  $event->event = $request->event;

  //save event into database
  $event->save();

  return response([
   'event' => $event,
  ]);
 }

}