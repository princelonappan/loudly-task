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
$ git clone https://github.com/princelonappan/internations-coding-challenge.git
```
#### Install dependencies
```
$ cd internations-coding-challenge
$ composer install
```
```
$ change the database configuration in the .env file
```
#### Run the following commands to migrate the database change
```
$ php bin/console make:migration
$ php bin/console doctrine:migrations:migrate
```
#### Add the following sql to the database for adding admin user.
admin@admin.com/admin
```
$ INSERT INTO `admin` (`id`, `email`, `roles`, `password`) VALUES
(1, 'admin@admin.com', '[\"ROLE_ADMIN\"]', '$2y$13$SdAsUDtP1TzaG.B8T1ILYuNKEU2bL0jqN19LCQMccHUwaxBMofM9C');
```

### URL Routes
```
$ {{ base_url}}/admin - Admin URL
```

#### Run API Swagger

You can access the Swagger API through the following end point. <br />
```/api```
