<?php

namespace Tests\Feature;

use App\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventManagmentTest extends TestCase
{
 use RefreshDatabase;
 /**
  *
  * @test
  */
 public function can_create_event()
 {
  factory(Event::class, 10)->create();
  $response = $this->post('/api/v1/event/create', ['event' => 'Love']);

  $this->assertCount(1, Event::all());
 }
}