<?php

require "lib/twitteroauth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

require "common/connection.php";

$user_connection = get_user_connection();
// var_dump($user_connection);

$tweets = $user_connection->get("statuses/user_timeline", ["count" => 10, "exclude_replies" => true]);
$followers = $user_connection->get("followers/list", ["count" => 10])->users;
// var_dump($followers);

?>

<style type="text/css">
#tweets,
#followers {
	width: 35%;
	margin: 2% 5%;
	float: left;
	display: inline-block;
	border: 1px solid gray;
}

#tweets .tweet,
#followers .follower {
	line-height: 2em;
}

#tweets .tweet.active,
#followers .follower.active {
	background: #eee;
	font-weight: bold;
}
</style>

<h3>Your Tweets:</h3>
<div id="my-tweets">
	<?php for ($i=0; $i < count($tweets); $i++) { 
		// print_r($tweets[$i]);
		echo '<li class="tweet">' 
			. '<span class="main-info">' . $tweets[$i]->text . '</span>'
			. '<span class="sub-info">' . $tweets[$i]->created_at . '</span>'
			. '</li>';
	} ?>
</div>

<hr />

<h3>Your Followers:</h3>
<b><i>(Click on a follower to get tweets!)</i></b>

<div>
<div id="followers">
	<ul>
	<?php foreach ($followers as $follower) { 
		// print_r($followers[$i]);
		echo '<li class="follower">' 
			. '<span class="main-info name">' . $follower->name . '</span>'
			. '(<a class="sub-info screen_name" href="#" screen_name="' . $follower->screen_name . '">@' . $follower->screen_name . '</a>)'
			. '</li>';
	} ?>
	</ul>
</div>

<div id="tweets">
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.js"></script>
<script type="text/javascript">
$('.screen_name').click(function() {
	var self = this;

	$.ajax({
		url: 'tweets.php',
		data: "screen_name=" + $(self).attr('screen_name'),
		success: function(response) {
			$('#tweets').html(response);
			$(".follower").removeClass('active');
			$(self).closest(".follower").addClass('active');
		},
		error: function() {
			alert('error!!!');
		}
	});
	return false;
});
</script>

