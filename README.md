#Graphcomment SDK API PHP version 1.0

install with composer :

`composer require graphcomment/sdk-api-php`

- The Wrapper use the last version of Guzzle.

- To use the PHP Wrapper you must create an account on Graphcomment.com and subscribe a paid plan.

With this wrapper you will be able to :

- Register automatically a new User on GraphComment whenever he subscribe on your website.
- Connect a user to GraphComment when he logs in to your website.
- Get the list of all your users who are registered on GraphComment.
- Get the list of threads and comments attached to a page by its url.

Example of implementation :

`$client = new Sdk(username|email, account_password, Graphcomment_website_id);`

`$client->authentification();`

after theses lines, you call the functions.

- register a User

`$client->registerUser('username', 'email', 'fr');`

This function return a json file containing its "gc_id" that must be save in your database to authenticate a user that is logging in.

- login a User, this function return the token JWT that you must save in localStorage to authenticate Graphcomment.

`$client->loginUser('email', 'gc_id');`

- Get the list of your users

`$client->getUsersQuery("10", "1", "kevin");`

get the list of users with name "kevin" that subscribe to GC.

get the threads and comments by url of a page (without http or https) then return a json with all comments and interactions.

`$client->getThread("//graphcomment.com/demo");`