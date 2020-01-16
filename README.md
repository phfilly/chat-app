# Simple PHP Chat app

# Version 2

## *Please note*

*The API url should be updated according to how your vhosts file might look like for the SLIM app (chat-api) dir _or_ the URL on which you decide to host the PHP app. The URL variable can be found in the `/js/message.js` file. At the top there's a variable called `apiURL`.*

Lastly, please install `composer install` in the `chat-api/` directory before starting up the app :)

A small PHP app that's built on top of the SLIM PHP framework, which allows for elegant HTTP routing and usage of the PHP Request, Response classes and PSR-7 support.

There's an implementation of the Interface Segregation and Dependency Inversion Principle in the Database class, this class depends on the DbInterface abstraction.

This goes for my controllers too - where I created a `BaseController` which implements 'prettifying json' and database connection management. This is inherited by `ResponseController` and `MessageController` to show a bit of Open/Closed and Single Responsibility Principles.

# Version 1

A small PHP app that allows for HTTP messages between users

For storage this app makes use of a sqlite db for the saving and retrieval of messages. 

The data is kept in one table for simplicity and quick retrieval. Each client will have an uuid that's created on app load or retrieved from previous app interactions and saved into a cookie. 

This cookie value and `to-contact-id` is used to poll for messages every 2.5 seconds. This creates the need for the browser to be able to run javascript. The site will show an appropriate message if javascript is disabled.