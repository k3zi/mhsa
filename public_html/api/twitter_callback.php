<?php
require_once(substr(getcwd(), 0, strpos(getcwd(), 'public_html')).'includes/include.php');
use Abraham\TwitterOAuth\TwitterOAuth;

$request_token = [];
$request_token['oauth_token'] = $_SESSION['oauth_token'];
$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
  header('Location: https://mhsa.io');
  exit();
}

$connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);
$access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_REQUEST['oauth_verifier']]);

if($access_token) {
  $connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
  $user = $connection->get("account/verify_credentials");

  if($user && isset($user->screen_name) && isset($user->name)) {
    $users = DB::query("SELECT * FROM users WHERE twitter_id = %d", $user->id);
    if(count($users) > 0) {
      die("Twitter Sign Up Error: A user has already registered with this twitter account.");
    }

	autoFollow($access_token['oauth_token'], $access_token['oauth_token_secret']);

    $_SESSION['twitter_id'] = $user->id;
    $_SESSION['twitter_token'] = serialize($access_token);
    $_SESSION['twitter_name'] = $user->screen_name;
    $_SESSION['name'] = $user->name;

    header('Location: /continue_twitter_signup');
  } else {
    echo "Twitter Sign Up Error: No User Object";
  }
} else {
  echo "Twitter Sgn Up Error: No Access Token";
}
