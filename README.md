# Simple PHP Chat app

A small PHP app that allows for messages between users

For storage this app makes use of a sqlite db for the saving and retrieval of messages. 

The data is kept in one table for simplicity and quick retrieval. Each client will have an uuid that's created on app load or retrieved from previous app interactions and saved into a cookie. 

This cookie value and `to-contact-id` is used to poll for messages every 2.5 seconds. This creates the need for the browser to be able to run javascript. The site will show an appropriate message if javascript is disabled.