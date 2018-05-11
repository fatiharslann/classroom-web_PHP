<?php
  if ($_GET) {
    include("../veritabani.php");
    $id=$_GET["grup_id"];
    session_start();
    $kullanici_id=$_SESSION["id"];

    $sorgu=mysqli_query($baglanti,"DELETE FROM grupuyeleri WHERE grup_id=$id AND kullanici_id=$kullanici_id");
    if ($sorgu) {
      header("Location:gruplar.php");
    }
  }
 ?>
