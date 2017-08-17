<?php

require "lib/twitteroauth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

session_start();

require "common/constants.php";

# Make Connection
$connection = new TwitterOAuth($consumer_key, $consumer_secret); //, $oauth_access_token, $oauth_access_token_secret);

# Get Request Token
$request_token = $connection->oauth('oauth/request_token', ['oauth_callback' => $oauth_callback]);
//var_dump($request_token);

//var_dump($connection->getLastHttpCode());

/* If last connection failed don't display authorization link. */
switch ($connection->getLastHttpCode()) {
    case 200:

        $_SESSION['oauth_token'] = $request_token['oauth_token'];
        $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

        $url = $connection->url('oauth/authorize', ['oauth_token' => $request_token['oauth_token']]);
	
        header("Location: " . $url);
        break;
    default:
        echo 'Could not connect to Twitter.';
}

?>