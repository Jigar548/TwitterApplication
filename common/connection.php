<?php

require "lib/twitteroauth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

require "common/constants.php";

session_start();

function get_app_connection() {
	global $consumer_key;
	global $consumer_secret;

	$oauth_token = $_SESSION['oauth_token']; # Must be same as $_GET['oauth_token'];
	$oauth_token_secret = $_SESSION['oauth_token_secret'];

	// print_r($_GET);
	// print_r($_SESSION);

	return new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);
}

function get_access_token() {
	if (!isset($_SESSION['access_token'])) {
		$connection = get_app_connection();
		$oauth_verifier = $_GET['oauth_verifier'];

		$_SESSION['access_token'] = $connection->oauth("oauth/access_token", ["oauth_verifier" => $oauth_verifier]);
	}
	return $_SESSION['access_token'];
}

function get_user_connection() {
	global $consumer_key;
	global $consumer_secret;
	
	$access_token = get_access_token();
	$user_oauth_token = $access_token['oauth_token'];
	$user_oauth_token_secret = $access_token['oauth_token_secret'];

	return new TwitterOAuth($consumer_key, $consumer_secret, $user_oauth_token, $user_oauth_token_secret);
}

// var_dump($connection);

// var_dump($access_token);

// var_dump($user_connection);


?>