# Genesis
Test task for Genesis 
https://github.com/socialtechio/auth-service/blob/master/TechnicalTask.md

* Build the images

It is a time to build the images. To do that, inside docker directory run the following command in your terminal:

> docker-compose build
 
Docker will download all needed files and will build PHP-FPM, Nginx images which you will be able to run later on.

* Run Symfony Application using Docker

To run the application, inside docker directory run the command in your terminal:

> docker-compose up -d


* How to Access Symfony App from inside the Docker?

The web server is exposed on port 80 on your local machine. 
So to access it you have to go to the url: http://127.0.0.1:80 in your browser.

* Also you can get your App via domain name

For this you should make run this command in your terminal :

> sudo vim /etc/hosts

Add this line into file:

127.0.0.1  genesis.test

Save the changes and quit.

After that, go to the url: http://genesis.test and enjoy the application.


#####Route list
* http://genesis.test/api/users    GET - list of all users
* http://genesis.test/api/users    POST - add new user (registration)
* http://genesis.test/api/login    POST - user login 
* http://genesis.test/api/stats    GET - list of all user tracking stats
* http://genesis.test/api/stats    POST - add new record to user tracking stats
