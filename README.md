# Database setup
## Import userslist.sql database
## Set database parameters in file
```
	app\config\parameters.yml
```

#Install dependences
```
	php composer.phar install
```

#Clear cache
```	
	app/console --env=prod cache:clear
```

#Dump assets	
```
	app/console assetic:dump
```	

#To check created command run
```
	php app/console user_cache:invalidate userId=10002
```