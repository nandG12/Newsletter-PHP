# Comic-World NewsLetter in PHP
A Simple PHP application that accepts a visitor’s email address and emails them random XKCD comics every speicified time interval.

## Getting Started
This is an example of how you may give instructions on setting up your project locally. To get a local copy up and running follow these simple example steps.

### Requirment
This is an example of how to list things you need to use the software and how to install them.
1. Install [XAMPP](https://www.apachefriends.org/download.html) or [WAMP](https://www.wampserver.com/en/#download-wrapper) Server Or You can Install separately any WebServer Or Database.
1. WebServer - [Apache](https://httpd.apache.org/download.cgi) or [NGINX](http://nginx.org/en/download.html)
1. Database - [MySQL](https://www.mysql.com/downloads/) or Any Relational Database

### Installation
1. Download project ZIP from [HERE](https://github.com/rtlearn/php-nandG12/archive/refs/heads/master.zip) or you can clone the repo using below Command.
   ```
   git clone https://github.com/rtlearn/php-nandG12.git
   ```
1. You need to modified below two files.
   1. include/db_connection.php
      - Read the Comment in that File. Create Database as per comment & Add the DataBase URL & Credentials in file. 
   1. include/mail_config.php
      - Change the SMTP Configuration as per your mail provider & Add the Email Credentials in file.

1. Web-Page is available now, Hit the published/Loclhost URL in Browser.

## Features
- User Can Read Random Comic Without Subscribe.
- For the News Letter User Need to Verify their Email-ID first.
- News Letter Mail Script Send the Mail to all user that are verified & Subscribe to every specified time interval (Like 5 or 10 Min).
- To Verify, Subscribe or Unsubscibe Specified Token Created & Send along with the mail.  

## Live Demo
Visit the [Comic-world](https://comic-world.herokuapp.com/)