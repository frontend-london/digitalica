<?php
$consumerKey    = '';
$consumerSecret = '';
$oAuthToken     = '';
$oAuthSecret    = '';
define('TWITTER_CURL_PASSWORD', '53Gwv96PW4GRMxA0wr'); 
error_reporting(E_ALL);

if(isset($_POST['password']) && isset($_POST['message']) && $_POST['password']==TWITTER_CURL_PASSWORD && $_POST['message']!='') {
    //require_once($_SERVER['DOCUMENT_ROOT'].'/<insert path to twitteroauth>/twitteroauth.php');
    require_once('twitteroauth/twitteroauth.php');    
    // create a new instance
    $tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);

    //send a tweet
    $tweet->post('statuses/update', array('status' => $_POST['message']));
}
