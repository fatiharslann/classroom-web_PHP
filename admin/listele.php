<?php
  include("../veritabani.php");
  session_start();
  $gonderici_id=$_SESSION["id"];
  $alici_id=$_GET["alici_id"];
  $array["veriler"]="";
  if ($_POST) {
    $sonid=$_POST["sonid"];
      $sorgu=mysqli_query($baglanti,"SELECT *FROM mesajlar WHERE ((alici_id=$alici_id AND gonderici_id=$gonderici_id)OR(alici_id=$gonderici_id AND gonderici_id=$alici_id)) AND mesaj_id>$sonid");
      while ($sonuc=mysqli_fetch_array($sorgu)) {
        if ($sonuc["gonderici_id"]==$gonderici_id) {
          $array["veriler"]='<li class="divmesaj" id="'.$sonuc["mesaj_id"].'"><div class="mesajAtan col-7 col-md-7 pull-right" >
              '.$sonuc["mesaj"].'
          </div></li>';
        }else{
          $array["veriler"]='<li class="divmesaj" id="'.$sonuc["mesaj_id"].'"><div class="mesajGonderen col-7 col-md-7 pull-left" >
              '.$sonuc["mesaj"].'
          </div></li>';
        }
        $goruldu_uptade = mysqli_query($baglanti,"UPDATE mesajlar SET okundu=1 WHERE (alici_id=$alici_id AND gonderici_id=$gonderici_id)OR(alici_id=$gonderici_id AND gonderici_id=$alici_id)");
      }

  }
  echo json_encode($array);
 ?>
