<?php
  include("admin-header.php");
?>
<div class="row">
  <div class="col-md-1">

  </div>
  <div class="col-md-8 baslik" style="margin-top: 70px;background-color: white; padding-top: 10px;">
  <h2 align="center">Bildirimler</h2>
  <hr class="hr1" color="#EEE"/>
  <hr class="hr2" color="#EEE"/>
<ul style="text-align: center;>

<?php
      $kullanici_id=$_SESSION['id'];
      $durumguncelle=mysqli_query($baglanti,"UPDATE grup_bildirimi SET durum=1 where alici_id='$kullanici_id'");
      $sorgu=mysqli_query($baglanti,"SELECT*FROM grup_bildirimi INNER JOIN kullanicilar ON grup_bildirimi.gonderici_id=kullanicilar.kullanici_id where grup_bildirimi.alici_id='$kullanici_id'");
      $sorgu2=mysqli_query($baglanti,"SELECT*FROM grup_bildirimi where grup_bildirimi.alici_id='$kullanici_id' and grup_bildirimi.durum='0'");
          $bildirimler=mysqli_num_rows($sorgu2);
      while($getir=mysqli_fetch_array($sorgu))
      {
        echo '<li><span class="bldrm" >'.$getir['zaman'].' tarihinde '.$getir['adSoyad'].' kişisinden '.$getir['konu'].'</span></li>
        ';
      }
?>

</div>
