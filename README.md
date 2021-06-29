# Comic-World NewsLetter in PHP
A Simple PHP application that accepts a visitor’s email address and emails them random XKCD comics every speicified time interval.

## Getting Started
This is an example of instructions on setting up your project locally. To get a local copy up and running, follow these simple example steps.

### Requirment
To run this Project, We need a below Software or Applications.
1. Install [XAMPP](https://www.apachefriends.org/download.html) or [WAMP](https://www.wampserver.com/en/#download-wrapper) Server Or You can Install separately any WebServer Or Database.
1. WebServer - [Apache](https://httpd.apache.org/download.cgi) or [NGINX](http://nginx.org/en/download.html)
1. Database - [MySQL](https://www.mysql.com/downloads/) or Any Relational Database
1. PHP Mailer - [GIT Repo](https://github.com/PHPMailer/PHPMailer/archive/refs/heads/5.2-stable.zip) we can also use the default mail() Function of the PHP to send the mail but here we need to attach the file along with the mail so it's much easy with the PHP Mailer Class.

### Installation
1. Download project ZIP from [HERE](https://github.com/rtlearn/php-nandG12/archive/refs/heads/master.zip) or you can clone the repo using below Command.
   ```
   git clone https://github.com/rtlearn/php-nandG12.git
   ```
1. Download the PHP Mailer from [HERE](https://github.com/PHPMailer/PHPMailer/archive/refs/heads/5.2-stable.zip) and extract that in below location. (You need to create the Lib Folder in the root directory).
   ```
   Extract the downloaded Zip into the Lib Folder.
   Rename that Extracted Folder to phpmailer
   ```
   
1. You need to modify the below files.
   1. include/db_connection.php
      - Read the Comment in that File. Create Database as per comment & Add the DataBase URL & Credentials in the file. 
   1. include/mail_config.php
      - Change the SMTP Configuration as per your mail provider & Add the Email Credentials in the file.
   1. include/comic_mail.php
      - Change the ID & Password to make the script only accessible to admin.

1. The Web-Page is available now, hit the published/Loclhost URL in the Browser.

## Features
- A user Can Read Random Comic Without Subscribe.
- For the News Letter, users need to verify their Email-ID first.
- News Letter Mail Script Send the mail to all users that are verified & Subscribe to every specified time interval (Like 5 or 10 minutes).
- To Verify, Subscribe or Unsubscribe Specific Token Created & Send along with the mail.  

## Description of Task
To Send the Random XKCD Comics, I have created a function that fetches the Random XKCD Comic from https://xkcd.com/{RandomNumber}/info.0.json. A GET request is made in which the comic data is returned in the JSON Format for that particular comic. Then the Necessary Data will be used after decoding the JSON Format. This data will used to show the comic on the Website or Sent to the user's email ID.

Send Mail (comic_mail.php) Script contains the id & password without that any user can't access or run that Mail Script/Page. For sending the comic into email at a specific time interval, Task Scheduler/Cron Job will use this. To Deploy the Website I have used the Heroku Platform. For the Cron/Task Scheduler We can use their add-ons (Heroku Scheduler). We can do it in a local machine or any third party Website that allows to create the Cron Job.

## Live Demo
Visit the [Comic-world](https://comic-world.herokuapp.com/)

## Small Presentation
Small Presentation for this task. Visit the [Prezi](https://prezi.com/view/yCrQID7EVHh3hUxEVlp3/)
