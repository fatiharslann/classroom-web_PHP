<?php
  if ($_GET) {
    include("../veritabani.php");
    $id=$_GET["grup_id"];
    session_start();
    $kullanici_id=$_SESSION["id"];
    $sorgu=mysqli_query($baglanti,"INSERT INTO grupuyeleri(grup_id,kullanici_id,izin) VALUES('$id','$kullanici_id',2)");
    if ($sorgu) {
    $sorgugetir=mysqli_query($baglanti,"SELECT * FROM gruplar where grup_id=$id");
    $getir=mysqli_fetch_array($sorgugetir);
    $alici_id=$getir['grup_kuran_id'];
    $konu="Takip İsteğiniz Var!";
    $bildirim=mysqli_query($baglanti,"INSERT INTO grup_bildirimi(alici_id,gonderici_id,konu) values('$alici_id','$kullanici_id','$konu') ");
      header("Location:gruplar.php");
    }
  }
 ?>
