<?php
  include("admin-header.php");
?>
<div class="row">
  <div class="col-md-1">

  </div>
  <div class="col-md-8 baslik" style="margin-top: 70px;background-color: white; padding-top: 10px;padding-bottom: 10px;">
  <h2 align="center">Mesajlarım</h2>
  <hr class="hr1" color="#EEE"/>
  <hr class="hr2" color="#EEE"/>
  <div class="row">
  <div class="col-12 col-md-4">
        <form class="form-inline my-2 my-lg-0 text-left search col-md-12">
          <input class="form-control" type="search" placeholder="Mesaj Atılacak Kişiyi Ara" name="kisiAra" aria-label="Search">
        </form>
      <ul class="nav nav-tabs" style="padding: 15px !important; margin-top: 30px;">
        <li class="active col-6 col-md-12"><a data-toggle="tab" href="#kisi">Mesaj Atılacak Kişiyi Seç</a></li>
      </ul>
      <div class="tab-content">
      <div id="kisi" class="tab-pane fade show active">
      <div class="yeniAcilan">
<?php
if($_GET&&@$_GET['kisiAra']){
      @$arama=$_GET['kisiAra'];

      $kisiGetir=mysqli_query($baglanti,"SELECT * FROM kullanicilar WHERE adSoyad LIKE '%$arama%'");
      $kisiVarMi = mysqli_num_rows($kisiGetir);
      if($kisiVarMi==0&&empty($kisiVarMi)){
        echo 'Kullanıcı Bulunamadı</div>';
      }
      else{
        while ($tumkisileriGetir=mysqli_fetch_array($kisiGetir)) {

                  echo '
                    <a href="#" class="link" id="'.$tumkisileriGetir["kullanici_id"].'"><img src="../profilfotograflari/'.$tumkisileriGetir["profilfotografi"].'" class="profil_foto3" width="60" height="60"/>
                    '.$tumkisileriGetir["adSoyad"].'<br><span style="font-size:12px;" title="'.$tumkisileriGetir["eMail"].'"> (('.substr($tumkisileriGetir["eMail"],0,10).'. . .))</span></a><br><br>
                    <hr><br>';
          }
      }
    }else{
      $kullanicilar_id_dizisi=array();
      $kullanicilar_dizisi=array();
      $kisiler=mysqli_query($baglanti,"SELECT * FROM mesajlar INNER JOIN kullanicilar ON mesajlar.gonderici_id=kullanicilar.kullanici_id WHERE mesajlar.alici_id=$id ORDER BY mesajlar.mesaj_id DESC");
      while ($kisileriGetir=mysqli_fetch_array($kisiler)) {
        if (!in_array($kisileriGetir["kullanici_id"],$kullanicilar_id_dizisi)) {
          array_push($kullanicilar_id_dizisi,$kisileriGetir["kullanici_id"]);
        }
      }
      foreach ($kullanicilar_id_dizisi as $key => $value) {
        $kisi=mysqli_fetch_array(mysqli_query($baglanti,"SELECT * FROM kullanicilar WHERE kullanici_id=$value"));
        $yeni_mesaj_varmi=mysqli_query($baglanti,"SELECT * FROM mesajlar WHERE alici_id=$id AND gonderici_id=$value AND okundu=0 ");
        if (mysqli_num_rows($yeni_mesaj_varmi)<=0) {
          echo '
            <a href="#" class="link" id="'.$kisi["kullanici_id"].'"><img src="../profilfotograflari/'.$kisi["profilfotografi"].'" class="profil_foto3" width="60" height="60"/>
            '.$kisi["adSoyad"].'<br><span style="font-size:12px;" title="'.$kisi["eMail"].'"> (('.substr($kisi["eMail"],0,10).'. . .))</span></a><br><br>
            <hr><br>';
        }else{
          echo '
            <a href="#" class="link" id="'.$kisi["kullanici_id"].'"><img src="../profilfotograflari/'.$kisi["profilfotografi"].'" class="profil_foto3" width="60" height="60"/>
            '.$kisi["adSoyad"].'<br><span style="font-size:12px;" title="'.$kisi["eMail"].'"> (('.substr($kisi["eMail"],0,10).'. . .))</span><br><span style="color:green;font-weight:bold">(YENİ)</span></a><br><br>
            <hr><br>';
        }

      }


    }
?>
</div>
</div>
</div>
</div>
<div class="col-md-8" id="icerik">
</div>

</div>
<script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
      $(document).ready(function () {
        $(".link").click(function () {
          var id=$(this).attr("id");
          $.get("mesajdetay.php",{alici_id:id},function (getir) {
            $("#icerik").html(getir);
          });
        });
      });
</script>
