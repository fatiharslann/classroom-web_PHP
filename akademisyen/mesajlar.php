<?php
  include("header.php");
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
      $kisiler=mysqli_query($baglanti,"SELECT * FROM kullanicilar");
      while ($kisileriGetir=mysqli_fetch_array($kisiler)) {

                echo '
                  <a href="#" class="link" id="'.$kisileriGetir["kullanici_id"].'"><img src="../profilfotograflari/'.$kisileriGetir["profilfotografi"].'" class="profil_foto3" width="60" height="60"/>
                  '.$kisileriGetir["adSoyad"].'<br><span style="font-size:12px;" title="'.$kisileriGetir["eMail"].'"> (('.substr($kisileriGetir["eMail"],0,10).'. . .))</span></a><br><br>
                  <hr><br>';
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
