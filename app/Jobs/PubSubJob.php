<?php

namespace App\Jobs;

use App\Event;
use App\Topic;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * author: Emmanuel Abraham
 * email: sundayemmanuelabraham@gmail.com
 * sugnature: iamaprogrammer
 * dated: 10th - 12th November, 2020
 * Location: Lagos, Niigeria
 */
class PubSubJob implements ShouldQueue
{
 public $message;
 public $topic;
 use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

 /**
  * Create a new job instance.
  *
  * @return void
  */
 public function __construct($message, $topic)
 {
  $this->message;
  $this->topic;
 }

 /**
  * Execute the job.
  *
  * @return void
  */
 public function handle()
 {
  /**
   * TODO's
   * 1. Pull all subcribed events from the DB
   * 2. Loop through the result set
   * 3. Pull all topic of events from the DB
   * 4. Loop through the result set
   * 5. Check for all of the currently subscribed URL's for topic matched.
   * 6. If it matched then forward data that was passed in the body as JSON
   */

  foreach (Event::all() as $event) {
   foreach (Topic::all() as $topic) {
    if ($event->topic_id === $topic->id) {
     //set request options (params)
     $options = ['topic' => $this->topic, 'message' => $this->message];
     //set the event url
     $url = $event->url;

     //instantiate a new Guzzle client
     $client = new Client();
     //strike a request
     $client->request('POST', $url, $options);
    }
   }
  }
 }
}