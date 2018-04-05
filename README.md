# MongoDB Document Editor
##### This is a quick script to get up and running using PHP to connect to mongo. As of this writing, use PHP5.6

Quick Precursor: you may need the mongo and mongodb drivers.

* [PHP Mongo Install Doc - *Nix](http://php.net/manual/en/mongo.installation.php#mongo.installation.nix)
* [PHP Mongo Install Doc - MacOSX](http://php.net/manual/en/mongo.installation.php#mongo.installation.osx)

Don't use Windows.

If all goes well...

Run
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
```terminal
$ php <yourscript.php>
```

For more information, refer to the mongodb documentation and/or
[MongoDB PHP Doc](http://php.net/manual/en/book.mongo.php)

