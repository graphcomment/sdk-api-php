#Graphcomment SDK API PHP
version 1.0


- To use the Wrapper PHP you must have an account on Graphcomment.com and choose the business enterprise package.

With this wrapper you can :
 
 - Register a new User on Graphcomment when he subscribe on your website.
 - Login a user on Graphcomment when he login on your website.
 - Get the list of your users subscribe on Graphcomment.
 - Get the thread by the Url of your subject with all comments to use for the SEO.
 
 
 Example of implementation :
 
 
 `$client = new Sdk(username|email, account_password, Graphcomment_website_id);`
 
 `$client->authentification();`
 
 after theses lines, you call the functions.
 
 - register a User 
 
 `$client->registerUser('username', 'email', 'fr');`
 
 This function return a json contain his "gc_id" that must be save in your database to authenticate a user when log him.
 
 - login a User
 
`$client->loginUser('email', 'gc_id');`

- Get the list of your users

`$client->getUsersQuery("10", "1", "kevin")`

get the list of users with name "kevin" subscribe to GC.

- get the thread by url of your page without http or https

`$client->getThread("//dev.graphcomment.com/demo");`

return the json of the thread with all properties and comments.