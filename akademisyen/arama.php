
<?php
include("header.php");
?>
<div class="container">
  <div class="row">
<div class="col-12 col-md-8 aramaSonuc">
    <ul class="nav nav-tabs" style="padding: 15px !important">
      <li class="active col-6 col-md-6"><a data-toggle="tab" href="#gruplar">Gruplarda Ara</a></li>
      <li class="col-6 col-md-6"><a data-toggle="tab" href="#kisiAra">Kişilerde Ara</a></li>
    </ul>

   <div class="tab-content">
      <div id="gruplar" class="tab-pane fade show active">
      <div class="yeniAcilan">
     <?php

      @$arama=$_GET['ara'];
      $grupGetir=mysqli_query($baglanti,"SELECT*FROM gruplar WHERE grup_adi LIKE '%$arama%' ");
      $grupVarMi = mysqli_num_rows($grupGetir);
      $ogrenciGetir=mysqli_query($baglanti,"SELECT * FROM kullanicilar WHERE adSoyad LIKE '%$arama%' ");
      $ogrenciVarMi = mysqli_num_rows($ogrenciGetir);

      if($grupVarMi==0&&empty($grupVarMi)){
        echo 'Grup Bulunamadı</div>';
      }
      else{
        while ($tumGruplariGetir=mysqli_fetch_array($grupGetir)) {

                  echo '
                    <a href="deneme.php?grup_id='.$tumGruplariGetir["grup_id"].'"><img src="../images/gruplogolari/'.$tumGruplariGetir["grup_logo"].'" class="profil_foto3" width="60" height="60"/></a>
                    <a href="deneme.php?grup_id='.$tumGruplariGetir["grup_id"].'" class="" style="font-size:15px;margin-top:10px;"><b>'.$tumGruplariGetir["grup_adi"].'</b><br>
                    <span>'.$tumGruplariGetir["grup_olusturma_tarihi"].' tarihinde oluşturuldu.</span></a>
                    <br>
                    <hr>
                  ';
          }
          echo '</div>';
      }
        echo '</div>' ;
      ?>
     <div id="kisiAra" class="tab-pane fade">
     <div class="yeniAcilan2">
     <?php
      if($ogrenciVarMi==0&&empty($ogrenciVarMi)){
        echo 'Öğrenci Bulunamadı</div>';
      }
      else{
        while ($tumOgrencileriGetir=mysqli_fetch_array($ogrenciGetir)) {

                  echo '
                    <a href="profilayrinti.php?kullanici_id='.$tumOgrencileriGetir["kullanici_id"].'"><img src="../profilfotograflari/'.$tumOgrencileriGetir["profilfotografi"].'" class="profil_foto3" width="60" height="60"/></a>
                    <a href="profilayrinti.php?kullanici_id='.$tumOgrencileriGetir["kullanici_id"].'">'.$tumOgrencileriGetir["adSoyad"].'</a><br>
                    <hr>';
          }
          echo '</div>' ;
      }
        echo '</div>' ;
?>



              </div>


  </div>
  </div>
  </div>
