
<?php
  include("header.php");
  //Akademisyenleri getir

  $giris_yapan_id=$_SESSION["id"];
  $akademisyenler=mysqli_query($baglanti,"SELECT * FROM kullanicilar WHERE yetki=1 LIMIT 0,8");
  $tumakademisyenler=mysqli_query($baglanti,"SELECT * FROM kullanicilar WHERE yetki=1 ");
  $duyurular=mysqli_query($baglanti,"SELECT * FROM duyurular ORDER BY duyuru_id DESC LIMIT 0,10");
  $tumduyurular=mysqli_query($baglanti,"SELECT * FROM kullanicilar INNER JOIN duyurular ON duyurular.duyuru_yapan_id=kullanicilar.kullanici_id ORDER BY duyurular.duyuru_id DESC");
  $tumGruplar=mysqli_query($baglanti,"SELECT * FROM gruplar INNER JOIN kullanicilar ON gruplar.grup_kuran_id=kullanicilar.kullanici_id ORDER BY gruplar.grup_id DESC");
  $tumGruplarr=mysqli_query($baglanti,"SELECT * FROM gruplar INNER JOIN kullanicilar ON gruplar.grup_kuran_id=kullanicilar.kullanici_id ORDER BY gruplar.grup_id DESC");

  date_default_timezone_set('Europe/Istanbul');
?>
<!--profil-->
<div class="container-fluid">
  <div class="row">

<!--profil bitiş-->
<!--İçerik-->
<?php include("solmenu.php"); ?>
<!--İçerik Bitti-->
		<div class="col-12 col-md-7 contentOrta">
		<div class="paylasimYap">
			<form enctype="multipart/form-data" action="grupkur.php" method="post">
				<div class="form-group">
				    <textarea class="form-control" rows="1" onkeyup="auto_grow(this)" name="grupadi" placeholder="Grup adını giriniz..."></textarea><br>
            <span style="float:left;font-size:12px;margin:3px">Grup Logosu : </span>
				     <div class="upload" style="margin-left:15%;">
		              <div class="fileUpload">

		                <img src="../images/dosya.png" width="25" />
		                <input id="uploadBtn" type="file" class="upload" name="gruplogo" />
		                </div>
		                <input id="uploadFile" placeholder="Dosya Seçilemedi" disabled="disabled" />
		              <button type="submit" class="btn btn-outline-info my-2 my-sm-0 pull-right paylasbutton" name="paylas">Grubu Kur</button>
	              </div>
				</div>
			</form>
		</div>
    <!--Grupları listeleme-->
    <div class="col-12 col-md-12 profile" style="margin-bottom:5%;">
    <ul class="nav nav-tabs" style="padding:15px;background-color:#c7c8ca;">
      <li class="col-6 col-md-6"><a data-toggle="tab" href="#newGroups" class="show active">Tüm Gruplar</a></li>
      <li class="col-6 col-md-6"><a data-toggle="tab" href="#gruplar">Takip Ettiğim Gruplar</a></li>

    </ul>

    <div class="tab-content">

      <div id="gruplar" class="tab-pane fade ">
        <?php

          while ($tumGruplariGetir=mysqli_fetch_array($tumGruplarr)) {
            $grup_id=$tumGruplariGetir["grup_id"];
            $uyeolunangruplar=mysqli_query($baglanti,"SELECT * FROM grupuyeleri WHERE kullanici_id=$giris_yapan_id AND grup_id=$grup_id");
            if (mysqli_num_rows($uyeolunangruplar)) {
              echo '<div class="yeniAcilan">
                <a href="grup_ayrinti.php?grup_id='.$tumGruplariGetir["grup_id"].'"><img src="../images/gruplogolari/'.$tumGruplariGetir["grup_logo"].'" class="profil_foto3" width="60" height="60"/></a>
                <a href="grup_ayrinti.php?grup_id='.$tumGruplariGetir["grup_id"].'" class="paylasan_kullanici" style="font-size:18px;">'.$tumGruplariGetir["grup_adi"].'</a><br>
                <span class="tarafindan"><b>'.$tumGruplariGetir["grup_olusturma_tarihi"].'</b> tarihinde, </span><br/>
                <span><b>'.$tumGruplariGetir["adSoyad"].'</b> tarafından oluşturuldu.</span>
                <a href="takiptencik.php?grup_id='.$tumGruplariGetir["grup_id"].'" class="takip" style="float: right;">Takipten Çık</a>
                <hr>
              </div>';

            }

          }
         ?>

      </div>
      <div id="newGroups" class="tab-pane fade show active">

        <?php

          while ($tumGruplariGetir=mysqli_fetch_array($tumGruplar)) {
            $grup_id=$tumGruplariGetir["grup_id"];
            $uyeolunangruplar=mysqli_query($baglanti,"SELECT * FROM grupuyeleri WHERE kullanici_id=$giris_yapan_id AND grup_id=$grup_id");
            if (!(mysqli_num_rows($uyeolunangruplar))) {
              echo '<div class="yeniAcilan">
                <a href="grup_ayrinti.php?grup_id='.$tumGruplariGetir["grup_id"].'"><img src="../images/gruplogolari/'.$tumGruplariGetir["grup_logo"].'" class="profil_foto3" width="60" height="60"/></a>
                <a href="grup_ayrinti.php?grup_id='.$tumGruplariGetir["grup_id"].'" class="paylasan_kullanici" style="font-size:18px;">'.$tumGruplariGetir["grup_adi"].'</a><br>
                <span class="tarafindan"><b>'.$tumGruplariGetir["grup_olusturma_tarihi"].'</b> tarihinde, </span><br/>
                <span><b>'.$tumGruplariGetir["adSoyad"].'</b> tarafından oluşturuldu.</span>
                <a href="takipet.php?grup_id='.$tumGruplariGetir["grup_id"].'" class="takipEt" style="float: right;">Takip Et</a>
                <hr>
              </div>';

            }

          }
         ?>

      </div>
    </div>
    </div>





		</div>


	</div>
</div>
	<script type="text/javascript">
	  function auto_grow(element) {
	    element.style.height = "1px";
	    element.style.height = (element.scrollHeight)+"px";

	};
	document.getElementById("uploadBtn").onchange = function () {
  document.getElementById("uploadFile").value = this.value;
  };
	</script>
  <script src="../js/jquery-3.2.1.js"></script>
  <script type="text/javascript" src="../js/tether.js"></script>
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script>
$('.nav-tabs a').click(function(){
  $(this).tab('show');
})
$('.nav-tabs a[href="#newGroups"]').tab('show')
</script>
  </body>
</html>
