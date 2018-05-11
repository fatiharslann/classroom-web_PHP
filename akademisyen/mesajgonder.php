<?php
  include("../veritabani.php");
  session_start();
  $gonderici_id=$_SESSION["id"];
  $alici_id=$_GET["kullanici_id"];
  $mesaj=$_POST["mesaj"];
  $sorgu=mysqli_query($baglanti,"INSERT INTO mesajlar(alici_id,gonderici_id,mesaj) VALUES($alici_id,$gonderici_id,'$mesaj') ");
 ?>
