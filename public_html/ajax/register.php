<?php
require_once('/home/mhsa/includes/include.php');

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$phone = (string)preg_replace('/\D/', '', $_POST['phone']);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('1');
}

if(strlen($phone) != 10) die('2');

if(strlen($name) == 0) {
  die('3');
}

$users = DB::query("SELECT * FROM users WHERE phone = %s", $phone);
if(count($users) > 0) {
  die('4');
}

$users = DB::query("SELECT * FROM users WHERE email = %s", $email);
if(count($users) > 0) {
  die('5');
}

DB::insert('users', array(
  'name' => $name,
  'unconfirmed_phone' => $phone,
  'email' => $email
));

if(DB::insertId() > 0) {
  singleSMS($phone, MHSA_CONFIRM_MESSAGE);
  die('0');
}

die('-1');
