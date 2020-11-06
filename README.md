## Very basic skeleton app, ready for development

- laravel 8
- ide-helper
- php cs
- laravel-code/middleware
- laravel-code/event-sourcing


## Setup

copy ```oauth-public.key``` from accounts into ```/storage/oauth-public.key```

Complete the .env file

``docker-compose build``

``docker-compose up`` this will open up a webserver on the given port

``docker-compose run app bash`` run php commands within Docker, for migrations etc.



# Middleware

```oauth``` - Checks Client ID and the bearer token. The user will become available on the ```$request->user()```

``oauth-user`` - Check the bearer token only. 

``oauth-client`` - Check the Client ID

``oauth-acl`` - Check Client ID and bearer token and if the user has the required roles. 
