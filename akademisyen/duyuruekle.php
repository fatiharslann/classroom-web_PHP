<?php

 include("../veritabani.php");
 session_start();
 $id=$_SESSION["id"];
 $baslik=$_POST["baslik"];
 $metin=$_POST["duyurumetni"];
 $sorgugetir=mysqli_query($baglanti,"SELECT * FROM kullanicilar where kullanici_id!=$id");
 $duyuruekle=mysqli_query($baglanti,"INSERT INTO duyurular(duyuru_yapan_id,duyuru_basligi,duyuru_icerigi) VALUES($id,'$baslik','$metin')");
 if ($duyuruekle) {
 	while($getir=mysqli_fetch_array($sorgugetir))
    {
 	$alici_id=$getir['kullanici_id'];
 	$konu="Duyurunuz Var!";
 	$bildirim=mysqli_query($baglanti,"INSERT INTO grup_bildirimi(alici_id,gonderici_id,konu) values('$alici_id','$id','$konu')");
 	}
   header("Location:index.php");

 }
 ?>
