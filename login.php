<?php
require 'vendor/autoload.php';
/**
 * Created by PhpStorm.
 * User: isaacwhite
 * Date: 3/23/18
 * Time: 12:34 PM
 */
if(!defined("STDIN")) {
    define("STDIN", fopen('php://stdin','rb'));
}

echo 'Use connection.json file? (Y/n)';

$yesOrNo = 'y' === strtolower(fread(STDIN, 1)); // true; echo PHP_EOL; // Set if you want to auto connect.
if ($yesOrNo) {
    /**
     *   connection.json must be in the form.
     *   { 
     *       "server" : "<server_name>",
     *       "port"   : <port_number,
     *       "username" : "<username>",
     *       "password" : "<password>"
     *   }
     */
    $connInfo = file_get_contents("connection.json");
    extract(json_decode($connInfo, true));
} else {
    $server   = promptInput('Hello, please enter your server', 'mongo.mongodb.com');
    $port     = promptInput('Now enter your port number', '27017');
    $username = promptInput('Enter a valid username');
    $password = promptInput('Enter a valid password');
}

$userandpass = $username ? $username . ':' . $password . '@' : '';

$connection = 'mongodb://'. $userandpass . $server . ':' . $port;
echo 'Your connection information: ' . $connection . PHP_EOL;
$client = new MongoDB\Client($connection);

/**
 * @param  string $messagePrompt
 * @param  null   $default
 * @return bool|null|string
 */
function promptInput($messagePrompt, $default = null) {
    echo $messagePrompt . ' ' . "[$default]:";
    $response = fread(STDIN, 80); // Read up to 80 characters or a newline
    $response = trim($response) != null ? trim($response) : $default;
    return $response;
}





