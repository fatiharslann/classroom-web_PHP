
<?php
  include("header.php");

?>
<!--profil-->
<div class="container-fluid">
  <div class="row">

<!--profil bitiş-->
<!--İçerik-->
<?php include("solmenu.php"); ?>
<!--İçerik Bitti-->
		<div class="col-12 col-md-7 contentOrta">

      <!--Paylaşımlar-->
      <?php
        $uye_oldugum_gruplar=mysqli_query($baglanti,"SELECT * FROM grupuyeleri INNER JOIN gruplar ON gruplar.grup_id=grupuyeleri.grup_id  WHERE grupuyeleri.kullanici_id=$id");
        while($uye_oldugum_gruplari_getir=mysqli_fetch_array($uye_oldugum_gruplar)){
          $grup_id=$uye_oldugum_gruplari_getir["grup_id"];
          $grup_paylasimlari=mysqli_query($baglanti,"SELECT * FROM paylasimlar INNER JOIN kullanicilar ON paylasimlar.kullanici_id=kullanicilar.kullanici_id INNER JOIN gruplar ON paylasimlar.grup_id=gruplar.grup_id WHERE paylasimlar.grup_id=$grup_id ORDER BY paylasimlar.paylasim_id DESC LIMIT 0,1");
          while ($paylasimlariGetir=mysqli_fetch_array($grup_paylasimlari)) {
            $paylasim_id=$paylasimlariGetir["paylasim_id"];
            $yorum_sayisi=mysqli_num_rows(mysqli_query($baglanti,"SELECT * FROM yorumlar WHERE paylasim_id=$paylasim_id"))-3;
            //goruldu ekle
            $gorulduVarMi=mysqli_query($baglanti,"SELECT * FROM goruldu WHERE goruldu_paylasim_id=$paylasim_id AND goruldu_kullanici_id=$id");
            if (!mysqli_num_rows($gorulduVarMi)) {
              $gorulduEkle=mysqli_query($baglanti,"INSERT INTO goruldu(goruldu_paylasim_id,goruldu_kullanici_id) VALUES($paylasim_id,$id)");
            }
            //goruldu ekle bitti
            $tumGorulduler=mysqli_query($baglanti,"SELECT * FROM goruldu INNER JOIN kullanicilar ON goruldu.goruldu_kullanici_id=kullanicilar.kullanici_id WHERE goruldu_paylasim_id=$paylasim_id");
            if ($yorum_sayisi>0) {
              $yorumlar=mysqli_query($baglanti,"SELECT * FROM yorumlar INNER JOIN kullanicilar ON kullanicilar.kullanici_id=yorumlar.kullanici_id  WHERE yorumlar.paylasim_id=$paylasim_id LIMIT $yorum_sayisi,3");
            }else {
              $yorumlar=mysqli_query($baglanti,"SELECT * FROM yorumlar INNER JOIN kullanicilar ON kullanicilar.kullanici_id=yorumlar.kullanici_id  WHERE yorumlar.paylasim_id=$paylasim_id ");
            }
            //ne kadar önce paylaşıldı
            $tarih=strtotime($paylasimlariGetir["paylasim_zamani"]);
            $simdi=strtotime(date('Y-m-d H:i:s'));
            $fark=($simdi-$tarih);//saniye olarak buluyor.
            if ($fark<60) {
              $zaman=$fark." saniye önce";
            }else{
              $fark=intval(($fark)/60);//dakika olarak buluyor.
              if ($fark<60) {
                $zaman=$fark." dakika önce";
              }else{
                $fark=intval(($fark)/60);//saat olarak buluyor.
                if ($fark<24) {
                  $zaman=$fark." saat önce";
                }else{
                  $fark=intval(($fark)/24);//gün olarak buluyor.
                  $zaman=$fark." gün önce";
                }
              }
            }
            //süre hesaplama bitti
            echo '<div class="col-12 col-md-12 content">
            <div class="row">
              <div class="col-2 col-md-2"><img src="../profilfotograflari/'.$paylasimlariGetir["profilfotografi"].'" class="profil_foto2" width="75" height="75"></div>
              <div class="col-10 col-md-10">
              <a href="profilayrinti.php?kullanici_id='.$paylasimlariGetir["kullanici_id"].'"" class="paylasan_kullanici">'.$paylasimlariGetir["adSoyad"].'</a> <a style="font-size:12px;" href="grup_ayrinti.php?grup_id='.$paylasimlariGetir["grup_id"].'"> (('.$paylasimlariGetir["grup_adi"].'))</a>
              <p class="tarih">'.$zaman.'</p>
              <p class="paylasim">'.$paylasimlariGetir["metin"].'</p>';
            if(!empty($paylasimlariGetir["ek_dosya_adi"])){
              echo '<a href="grup_ayrinti.php?grup_id='.$grup_id.'&dosya='.$paylasimlariGetir["ek_dosya_adi"].'"><img src="../images/indir.jpg" width="25" height="24" style="border-radius:100%;margin-right:10px;"/>'.$paylasimlariGetir["ek_dosya_adi"].' </a>';
            }
            //goruldu listele
            echo '<a data-toggle="modal" href="#tumgorenlermodal'.$paylasim_id.'" class="goruldu" id="gorenler">'.mysqli_num_rows($tumGorulduler).' kişi gördü</a>
            <div class="modal fade" id="tumgorenlermodal'.$paylasim_id.'" role="dialog">
               <div class="modal-dialog">
                 <div class="modal-content">
                   <div class="modal-header">
                     <h6>Görenler</h6>
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                   </div>
                   <div class="modal-body">';

                       while ($gorenUyelerGetir=mysqli_fetch_array($tumGorulduler)) {

                         echo '<div class="" style="padding:2%;">
                           <img src="../profilfotograflari/'.$gorenUyelerGetir["profilfotografi"].'" class="profil_foto3" width="40" height="40"style="float:left;margin-right:2%;"/>
                           <span class="tarafindan" style="font-size:13px;"><b>'.$gorenUyelerGetir["adSoyad"].'</b> </span><br/>
                           <span style="font-size:12px;float:left">'.$gorenUyelerGetir["eMail"].'</span><br>

                           <hr>
                         </div>';
                       }

                  echo '
                   </div>
                   <div class="modal-footer">
                     <button type="submit" class="btn btn-danger" data-dismiss="modal">Kapat</button>
                   </div>
                 </div>
               </div>
             </div>';
            //goruldu listele bitti
            echo '
              <hr>
              <p class="baslik_yorumlar">Yorumlar</p><div class="yorumlar">';

              if (mysqli_num_rows($yorumlar)!=0) {
                while ($yorumGetir=mysqli_fetch_array($yorumlar)) {
                  echo '
                  <span class="yorum_kullanici">'.$yorumGetir["adSoyad"].'</span>
                  <p class="yorum">'.$yorumGetir["yorum"].'</p>
                ';
                }
                $tumYorumlar=mysqli_query($baglanti,"SELECT * FROM yorumlar INNER JOIN kullanicilar ON yorumlar.kullanici_id=kullanicilar.kullanici_id WHERE yorumlar.paylasim_id=$paylasim_id");
                echo '<div class="text-center" style="margin-bottom: -30px;font-weight:bold;"><a data-toggle="modal" href="#myModal'.$paylasim_id.'"  style="color:#673bb7;">Tüm yorumları göster...</a></div><br/>
                <div class="modal fade" id="myModal'.$paylasim_id.'" role="dialog" >
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h6>Tüm Yorumlar</h6>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body" style="background-color:#edf1f5">';
                while ($tumYorumlariGetir=mysqli_fetch_array($tumYorumlar)) {
                  echo '<div class="gorenKisiler" >
                  <img src="../profilfotograflari/'.$tumYorumlariGetir["profilfotografi"].'" class="profil_foto3" width="40" height="40"/>
                  <span class="görenler"><b style="font-size:12px;">'.$tumYorumlariGetir["adSoyad"].'</b><span style="font-size:11px;">(('.$tumYorumlariGetir["eMail"].'))</span><br/>
                  <span>'.$tumYorumlariGetir["yorum"].'</span>
                  <hr>
                </div>';
                }
                 echo '</div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-danger" data-dismiss="modal">Kapat</button>
                        </div>
                      </div>
                    </div>
                  </div>';
              }else{
                  echo '<span class="yorum_kullanici">Henüz hiç yorum yapılmamış.</span><br>';
              }

              echo '	</div><hr>
              <form method="post" action="yorumyap.php?grup_id='.$grup_id.'&paylasim_id='.$paylasimlariGetir["paylasim_id"].'">
                <div class="form-group">
                  <label class="yorumYap" for="yorumYap">Yorum Yap</label><br>
                  <textarea class="form-control col-md-11 col-11" id="yorumYap" rows="1" onkeyup="auto_grow(this)" style="height: 35px;float:left" name="yorum"></textarea>
                  <input type="image" value="submit" src="../images/send.png" class="col-1 col-md-1" style="padding-top:7px !important;"/>
                </div>
              </form>
              </div>
            </div>

            </div>';
          }
        }





       ?>
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
  <script src="js/jquery-3.2.1.js"></script>
  <script type="text/javascript" src="js/tether.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>

  </body>
</html>
