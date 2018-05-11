<?php
  include("admin-header.php");
?>
<div class="row">
  <div class="col-md-3">

  </div>
  <div class="col-md-4 baslik text-center" style="margin-top: 70px;background-color: white; padding:10px;">
    <h2 align="center">Şifre Değiştir</h2>
    <hr class="hr1" color="#EEE"/>
    <hr class="hr2" color="#EEE"/>
    <form action="#" method="post">
                <div class="col-md-12" style="padding: 20px;background-color: #edf1f5;">
                <input placeholder="Şifre" name="sifre" id="sifre" type="password" required="" style="margin-bottom: 10px;">*<br>
                <input placeholder="Şifre Tekrar" name="sifreTekrar" type="password" required="" id="sifre" style="margin-bottom: 10px;">*<br>
                <input placeholder="Yeni Şifre" name="yeniSifre" type="password" required="" id="sifre" style="margin-bottom: 10px;">*<br>
                <input type="submit" class="btn btn-outline-info my-2 my-sm-0 paylasbutton" name="degistir" value="Şifre Değiştir">
                </div>
    </form>
    <?php
        $kullanici_id=$_SESSION["id"];
        if(@$_POST["degistir"]){
        $sifre=md5($_POST["sifre"]);
        $sifreTekrar=md5($_POST["sifreTekrar"]);
        $yeniSifre=md5($_POST["yeniSifre"]);
        $kullanicilar=mysqli_query($baglanti,"SELECT * FROM kullanicilar where kullanici_id='$kullanici_id'");
        $getir=mysqli_fetch_array($kullanicilar);
        $kullanici_sifre=$getir['sifre'];

          if($sifre==$kullanici_sifre&&$sifre==$sifreTekrar){
          $sorgu= mysqli_query($baglanti,  "UPDATE kullanicilar SET sifre='$yeniSifre' where kullanici_id='$id'");
        }
        if($sorgu==true){
          echo '<div class="alert alert-success">
                      <strong>Başarılı!</strong> Şifre Değiştirme Başarılı!
                    </div>';
        }
        else{
                    echo '<div class="alert alert-danger">
                  <strong>Başarısız!</strong> Şifre Değiştirilemedi!
                </div>';
        }
      }
    ?>

</div>
</div>
