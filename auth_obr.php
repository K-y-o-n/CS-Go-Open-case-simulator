<?php
session_start();
error_reporting(-1);
ini_set("display_errors", 1);

$login = $_POST["login"];
$password = $_POST["password"];

include("db.php");

$req = $db->query("SELECT * FROM gameUser WHERE login='$login' AND password='$password'");
//"SELECT * FROM gameUser LEFT JOIN "$login" ON admin.id_user = user.id WHERE email='$email' AND password='$password'"
$user = $req->fetch_assoc();
if($user){
  $_SESSION['user'] = $user;
  print "AUTH_OK";
} else {
  print "AUTH_FALSE";
}
?>