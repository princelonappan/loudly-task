## Overview

This application provides the following features.

- User Creation (List/Add)
- Send Invitation 
- Cancel Invitation
- Accept/Reject Invitation

## Requirements and dependencies

- PHP >= 7.2
- Symfony CLI version  v4.28.1

## Features

- This system allows the user to send the invitation to the other user that is already registered in our system. 
- We need to create the user initially to use this application through the User create API request. 
- The sent API request is used for sending the invitation request and the updated API request is used for accepting the different types of status against the invitation.
- STATUS_PENDING = 1;
- STATUS_ACCEPTED = 2;
- STATUS_REJECTED = 3;
- STATUS_CANCELLED = 4;

## Installation

First, clone the repo:
```bash
$ git clone https://github.com/princelonappan/loudly-task.git
```
#### Install dependencies
```
$ cd loudly-task
$ composer install
```
```
$ change the database configuration in the .env file
```
#### Run the following commands to migrate the database change
```
$ php bin/console make:migration
$ php bin/console doctrine:migrations:migrate
$ copy the database with '_test' name and create for testing purpose
```

### Run the application
```
$ symfony server:start
```
#### How to use
```
$ Create the users with 'api/users' API.
$ Use the 'api/users' GET API to see all the users.
$ Use the user ids to send the Invitation.
```

#### Run API Swagger

You can access the Swagger API through the following end point. <br />
```{{ base_url}}/api/doc```

#### Run Test

```
$ php bin/phpunit
```
