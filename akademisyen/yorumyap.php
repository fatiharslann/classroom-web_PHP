<?php
if ($_GET) {
  include("../veritabani.php");
  $yorum=$_POST["yorum"];
  $grup_id=$_GET["grup_id"];
  $paylasim_id=$_GET["paylasim_id"];
  session_start();
  $kullanici_id=$_SESSION["id"];
  $yorum_sorgu=mysqli_query($baglanti,"INSERT INTO yorumlar(paylasim_id,kullanici_id,yorum) VALUES($paylasim_id,$kullanici_id,'$yorum')");
  if ($yorum_sorgu) {
    $sorgugetir=mysqli_query($baglanti,"SELECT * FROM gruplar where grup_id=$grup_id");
    $getir=mysqli_fetch_array($sorgugetir);
    $alici_id=$getir['grup_kuran_id'];
    $konu="Paylaşımınıza Yorum Var!";
    $bildirim=mysqli_query($baglanti,"INSERT INTO grup_bildirimi(alici_id,gonderici_id,konu) values('$alici_id','$kullanici_id','$konu') ");
    header("Location:grup_ayrinti.php?grup_id=$grup_id");

  }
}

 ?>
