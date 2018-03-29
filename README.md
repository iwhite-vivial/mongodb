# MongoDB Document Editor
##### This is a quick script to get up and running using PHP to connect to mongo.

 First, run
```terminal
$ composer install
```

To quickly connect, rename the "connection.json.template" file to "connection.json"
##### DO NOT RENAME THE KEYS. 
```json
{ 
      "server" : "<server_name>",
      "port"   : "<port_number>",
      "username" : "<username>",
      "password" : "<password>"
}
```

*If you would like to automate your login, edit the login.php to always use your connection.json.*

Next, create a new PHP file and add login.php to the top and you should be ready to code.

```php
<?php
require 'login.php';

/**
 *  $client is the default client connection setup in login.php
 */
$someDatabase = $client->someDatabase;
```

Once your script is written.

php <yourscript.php>

For more information, refer to the mongodb documentation and/or
[MongoDB PHP Doc](http://php.net/manual/en/book.mongo.php)

