<?php
require_once('/home/mhsa/includes/include.php');

if(!isset($_SESSION['twitter_id'])) {
  die('-1');
}

$twitter_id = $_SESSION['twitter_id'];
$twitter_token = $_SESSION['twitter_token'];
$twitter_name = $_SESSION['twitter_name'];
$name = $_SESSION['name'];
$email = trim($_POST['email']);
$phone = (string)preg_replace('/\D/', '', $_POST['phone']);

if(strlen($phone) != 10) die('1');

$users = DB::query("SELECT * FROM users WHERE phone = %s", $phone);
if(count($users) > 0) {
  die('2');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('3');
}

$users = DB::query("SELECT * FROM users WHERE email = %s", $email);
if(count($users) > 0) {
  die('4');
}

DB::insert('users', array(
  'name' => $name,
  'unconfirmed_phone' => $phone,
  'email' => $email,
  'twitter_id' => $twitter_id,
  'twitter_token' => $twitter_token,
  'twitter_name' => $twitter_name
));

if(DB::insertId() > 0) {
  singleSMS($phone, MHSA_CONFIRM_MESSAGE);
  die('0');
}

if($result){
  print_r($result);
}

die('-1');

?>
