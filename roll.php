<?php
session_start();
error_reporting(-1);
ini_set("display_errors", 1);
$id = $_SESSION['user']['id'];

$case = $_POST["name"];

include("db.php");

$rare = "";
$rollRare = mt_rand(0,1000)/10;
if($rollRare <= 92){
  $rare = "#2196f3";
} else if($rollRare >=92.1 && $rollRare <=97){
  $rare = "#8847ff";
} else if($rollRare >=97.1 && $rollRare <=99){
  $rare = "#d32ce6";
} else if($rollRare >=99.1 && $rollRare <=99.7){
  $rare = "#eb4b4b";
} else $rare = "#FFD700";

$req = $db->query("SELECT id, name, img FROM caseItems WHERE caseName='$case' AND rare='$rare'");
$arrItems = $req->fetch_all();
$numItems = count($arrItems);
$randItem = rand(0,$numItems-1);
$prize = $arrItems[$randItem];
$prizeId = $prize[0];

$req2 = $db->query("INSERT INTO Inventory(id_user, id_item) VALUES ('$id', '$prizeId')");
array_shift($prize);
$prize[] = $rare;
if($req2) print_r(json_encode($prize));
else print ROLL_ERROR;


?>