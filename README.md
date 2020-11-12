# Pangaea BE Coding Challenge
* by Emmanuel Abraham

[![N|Solid](https://www.zetamindgroup.com/signature/Emmanuel.jpg)]



Recreating a pub / sub system using HTTP requests.

  - No GCP
  - No Kafka etc.
  - Just http requests

# Publisher Server Requirements
#### Setting up a subscription

- POST /subscribe/{TOPIC}
- BODY { url: "http://localhost:8000/event"}
- The above code would create a subscription for all events of {TOPIC} and forward data to http://localhost:8000/event



#### Publishing an event
- POST /publish/{TOPIC}
- BODY { "message": "hello"}
- The above code would publish on whatever is passed in the body (as JSON) to the - supplied topic in the URL. 
- This endpoint should trigger a forwarding of the data in the body to all of the currently subscribed URL's for that topic.




#### Testing it all out Publishing an event

- $ ./start-server.sh
- $ curl -X POST -d '{ "url": "http://localhost:8000/event"}' http://localhost:8000/subscribe/topic1
- $ curl -X POST -H "Content-Type: application/json" -d '{"message": "hello"}' http://localhost:8000/publish/topic1
                
>The above code would set up a subscription between topic1 and http://localhost:8000/event. When the event is published in line 3, it would send both the topic and body as JSON to http://localhost:8000

>The /event endpoint is just used to print the data and verify everything is working.



### Installation

* If you're using https
```sh
$ git clone https://github.com/abrahamemmanuel/pangaea-be-coding-challenge.git
```

* If you're using ssh
```sh
$ git clone git@github.com:abrahamemmanuel/pangaea-be-coding-challenge.git
```

* If you're using Github cli
```sh
$ gh repo clone abrahamemmanuel/pangaea-be-coding-challenge
```
Start the development server...
```sh
php artisan serve --port=8000
```

### Plugins

Guzzle is used to forward hhtp request within internal api within this appication

* To install Guzzle, use the command
```sh
composer require guzzlehttp/guzzle:^7.0
```
License
----
MIT



