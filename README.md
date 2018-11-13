[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/graphcomment/sdk-api-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/graphcomment/sdk-api-php/?branch=master)

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

`$client = new Sdk(GC_PUBLIC_KEY, GC_SECRET_KEY);`

after theses lines, you call the functions.

- register a User

`$client->registerUser('username', 'email', 'fr', 'https://graphcomment.com/image.jpg');`

This function return a json file containing its "gc_id" that must be save in your database to authenticate a user that is logging in and do_sync date of synchronisation to save too.

- login a User, this function return the token JWT as JSON that you must save in localStorage to authenticate Graphcomment.

`$client->loginUser('gc_id');`

to save in localStorage the gc_token, call this url in an iframe with 0px width, 0px width of user to authenticate him => https://graphcomment.com/fr/auth.html?gc_token=[TOKEN-without-JWT-only-token]

to destroy session localStorage, call this url in an iframe with 0px width, 0px width of user => https://graphcomment.com/fr/destroy.html

Example : 

Connexion :

`<iframe src="https://graphcomment.com/fr/auth.html?gc_token=eyJhbGciOiJIUzI1NiIsInR5cCI6kpXVCJ9.eyJfaWQiOiI1OGY5ZjQ5OTk3NzkwOTBkODYyMDgwOTIiLCJ1c2VybmFtZSI6ImRhdmlkIGRqaWFuIiwiZW1haWwiOiJzaXJiYWxkdXJAZ21haWwuY29tIiwiZmFjZWJvb2tfaWQiOiIxMDE1NDE3Mjk2NzQ1MTQ5MSIsImdvb2dsZV9pZCI6IjExNjEwMTAxNzgxODA3MjI5MDk0OCIsInJvbGUiOJ1c2VyIiwicGljdHVyZSI6Ii9pbWFnZXMvYXZhdGFyXzMucG5nIiwibGFuZ3VhZ2UiOiJmciIsImZyb21fd2Vic2l0ZSI6IjU4MWQyMTlmOGRmY2EwMzlhY2MMGZiZiIsInZhbGlkYXRpb24iOnt9LCJpYXQiOjE0OTk2ODYxMjIsImV4cCI6MTUwMjI3ODEyMn0.YyiANmL4-wzu1XGak1SbBmywZOWLHwjYsXtBW-Ikqx4
" frameborder="0" style="width:0px;height:0px;"></iframe>`

Disconnection :

`<iframe src="https://graphcomment.com/fr/destroy.html" frameborder="0" style="width:0px;height:0px;"></iframe>`

- Get last informations from a user

`$client->getUser('gc_id');`

get user's informations, return a JSON.

```
{
	gc_id: 'gc_id',
	username: 'username',
	email: 'email@email.com',
	language : 'en',
	picture : 'https://graphcomment.com/image.jpg',
	do_sync : date of synchronisation
}
```
- Update a User on Graphcomment

`$client->updateUser('gc_id', 'username', 'email', 'fr', 'https://graphcomment.com/image.jpg');`

return do_sync date and gc_id with state 'updated'

- Count Comments of a thread

`$client->countCommentscountComments('https://graphcomment.com/thread.html', 'content123');`
