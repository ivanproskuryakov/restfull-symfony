##Commands in use:
```
composer install
bin/console doctrine:schema:drop --force
bin/console doctrine:schema:create
vendor/bin/phpunit

php-cs-fixer fix tests/
php-cs-fixer fix src/
```

##About:
I'm a big fan of writing as less code as possible, less code was written - less time was spent. 
Annotations for classes like @author were avoided since it's not open-source code and git is used.
Description annotations for methods were also avoided, a code must be self-documented. 

The main point was to show how the amount of code of basic CRUD operations can be significantly reduced by 
writing a single base "ApiControllerTemplate" that takes care or Create = Post, Read = Get, Update = Put and Delete.
For the systems with large amount of entities, lest say 50. this approach can significantly increase the production rate,
decrease code duplications with the bugs that come within.

The second point was to show the beauty of using object deserializer like JMS to deserialize raw 
payload into real objects without writing setter(s), see "app_character_post" & "app_user_post" routes.
Same goes for other operations like update, read and delete - CRUD.

If an operation could not be done withing base crud "ApiControllerTemplate" then its a part of businesses logic 
and "custom" controller is needed. Like "app_game_status", "app_game_new" & "app_game_action_attack"
  
ApiExceptionListener is taking care of exceptions on the side of backend and transforms, 
them to a single format pushed to the client, ex: UserControllerTest, line 140 
  
I can't say that the code I've written is the best I could ship, but it has very few duplications and covered with the tests. 
TDD was used as an approach to writing and testing the code, I've never opened a browser to make sure it works from it.
here I'm using PHPUnit to test API endpoints, entities, and services.


Due the lack of time I could not implement all I planned, functionality was reduced(like always).
The parts that could be improved are there: 
 - Firewall is not making his work, related to user group or settings.
 - Parts of game logic are missing, they marked with "todo".
 - Like always there could be something missing, I hope not much. 