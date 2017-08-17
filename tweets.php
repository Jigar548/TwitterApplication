<?php

require "lib/twitteroauth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

require "common/connection.php";

$user_connection = get_user_connection();

if ($_GET['screen_name']) {
	$tweets = $user_connection->get("statuses/user_timeline", ["screen_name" => $_GET['screen_name'], "count" => 10, "exclude_replies" => true]);
} else {
	$tweets = $user_connection->get("statuses/user_timeline", ["count" => 10, "exclude_replies" => true]);
}

?>

<ul>
	<?php for ($i=0; $i < count($tweets); $i++) { 
		echo '<li class="tweet">' 
			. '<span class="main-info">' . $tweets[$i]->text . '</span>'
			. '<span class="sub-info">' . $tweets[$i]->created_at . '</span>'
			. '</li>';
	} ?>
</ul>
