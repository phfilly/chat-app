# Simple PHP Chat app

# Version 2

## *Please note*

The API url should be updated according to how your vhosts file might look like for the SLIM app (chat-api) dir. This can be found in the `/js/message.js` file. At the top there's a variable called `apiURL`. 

A small PHP app that's built on top of the SLIM framework, which allows for elegant routing and usage of the PHP Request and Response classes

There's an implementation of the Interface Segregation and Dependency Inversion Principle in the Database class which depends upon a DbInterface abstraction.

Same for in my controllers where I created a `BaseController` which implements 'prettifying json' and database connection management. This is inherited by `ResponseController` and `MessageController` to show a bit of Open/Closed and Single Responsibility Principle.

# Version 1
A small PHP app that allows for HTTP messages between users

For storage this app makes use of a sqlite db for the saving and retrieval of messages. 

The data is kept in one table for simplicity and quick retrieval. Each client will have an uuid that's created on app load or retrieved from previous app interactions and saved into a cookie. 

This cookie value and `to-contact-id` is used to poll for messages every 2.5 seconds. This creates the need for the browser to be able to run javascript. The site will show an appropriate message if javascript is disabled.