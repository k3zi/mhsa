<?php
require_once('/home/mhsa/includes/include.php');
use Abraham\TwitterOAuth\TwitterOAuth;

$_SESSION = array();

$connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET);
$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => TWITTER_OAUTH_CALLBACK));

if($request_token) {
  $token = $request_token['oauth_token'];
  $_SESSION['oauth_token'] = $token;
  $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

  $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
  header('Location: ' . $url);
} else {
  echo "Error Receiving Request Token from Twitter";
}

?>
