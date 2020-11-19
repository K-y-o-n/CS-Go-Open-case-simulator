<?php
session_start();
error_reporting(-1);
ini_set("display_errors", 1);
$id = $_SESSION['user']['id'];

include("controller/db.php");
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Inventory</title>
  <style>
  .container{
   display: grid;
   grid-template-columns: 25% 25% 25% 25%;
   grid-row-gap: 5px;
  }
  .container>div{
    width: 180px;
    height: 180px;
    box-sizing: border-box;
    border-radius: 10px;
  }
  .container>div>img{
    width: 95%;
    height: 155px;
  }
  .container>div>img::selection{
    background: transparent;
  }
  .container>div>span{
    display: flex;
    justify-content: center;
  }
  .container>div>span::selection{
    background: transparent;
  }
  </style>
</head>
<body>
  <div class="container">
    <?php
      $req = $db->query("SELECT name, img, rare FROM Inventory JOIN gameUser ON id_user=gameUser.id JOIN caseItems ON id_item=caseItems.id WHERE id_user='$id' ORDER BY Inventory.id DESC");
      while(($items = $req->fetch_assoc()) != null){
        $name = $items["name"];
        $url = $items["img"];
        $rare = $items["rare"];
        print "<div style='border: 2px solid $rare'>";
          print "<img src='$url' alt='$name'>";
          print "<span>$name</span>";
        print "</div>";
      }
    ?>
  </div>
</body>
</html>