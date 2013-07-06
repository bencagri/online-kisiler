<?php
require 'FB.php';

$app_id = "508627902539302";
$app_secret = "a486bfc34236e4877bfb9bc5f86c36ba";

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => $app_id ,
  'secret' => $app_secret,
  'cookie' => true
));


// Get User ID
$user = $facebook->getUser();

$accessToken = $facebook->getAccessToken();
$facebook->setAccessToken($accessToken);

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}


// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl  = $facebook->getLoginUrl(
    array(
      'scope' => 'user_online_presence,friends_online_presence,read_stream,email,',
    )
  );
}
