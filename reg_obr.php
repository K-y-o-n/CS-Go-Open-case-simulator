<?php
session_start();
error_reporting(-1);
ini_set("display_errors", 1);

$login = $_POST["login"];
$password = $_POST["password"];


include("db.php");

$req = $db->query("INSERT INTO gameUser(`login`, `password`) VALUES ('$login','$password')");

if ($req){
  /*$inv = $db->query("CREATE TABLE `$dbname`.`$login` ( `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT , `items` VARCHAR(25) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");*/
  print "REG_OK";
}else{
  print "REG_FALSE";
}
?>