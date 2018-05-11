<?php
 include("header.php");
 date_default_timezone_set('Europe/Istanbul');
 if ($_GET) {
   $grup_id=$_GET["grup_id"];
   $grubuGetir=mysqli_query($baglanti,"SELECT * FROM gruplar INNER JOIN kullanicilar ON gruplar.grup_kuran_id=kullanicilar.kullanici_id WHERE gruplar.grup_id=$grup_id");
   $grup=mysqli_fetch_array($grubuGetir);
   $varmi=mysqli_query($baglanti,"SELECT * FROM grupuyeleri WHERE grup_id=$grup_id AND kullanici_id=$id AND izin=2");
   $kontrol=false;
   if (mysqli_num_rows($varmi)>0) {
     $kontrol=true;
   }
   /*takip etme*/
    if(@$_GET["takip"]){
      mysqli_query($baglanti,"INSERT INTO grupuyeleri(grup_id,kullanici_id,izin) VALUES($grup_id,$id,1)");
      $bildirim_alici=$grup["grup_kuran_id"];
      $grup_adi=$grup["grup_adi"];
      mysqli_query($baglanti,"INSERT INTO grup_bildirimi(alici_id,gonderici_id,konu) VALUES($bildirim_alici,$id,'$kullanici->ad_soyad, $grup_adi adlı grubunuza katılmak istiyor!')");

    }else if(@$_GET["beklemeiptal"]){
      mysqli_query($baglanti,"DELETE FROM grupuyeleri WHERE grup_id=$grup_id AND kullanici_id=$id");
    }

   //takip etme son
   /*Dosya varsa indir*/
   if (@$_GET["dosya"]&&$kontrol) {
     $dosya="../dokumanlar/".$_GET["dosya"];
     if ((isset($dosya))&&(file_exists($dosya))) {
       header("Content-length: ".filesize($dosya));
       header('Content-Type: application/octet-stream');
       header('Content-Disposition: attachment; filename="' . $dosya . '"');
       readfile("$dosya");
     } else {
       echo '<div class="alert alert-danger" style="margin-top:40px;">
             <strong>Başarısız!</strong> Dosya Bulunamadı.
           </div>';
     }

   }
   /*Dosya indir son*/


   /*Paylaşım Yap*/
   $kullanici_id=$_SESSION["id"];
   if($_POST&&$kontrol){
       $metin=$_POST["metin"];
       $dosya_uzantisi=explode(".",$_FILES["ek_dosya"]["name"]);
       $dosya_uzantisi=$dosya_uzantisi[count($dosya_uzantisi)-1];
       $kabul_edilen_uzantilar=array("jpg","png","pdf","mp4","mp3","txt","rar","zip","docx","xls","pptx","ppt");



       $paylasim_sayisi=mysqli_num_rows(mysqli_query($baglanti,"SELECT * FROM paylasimlar"));
       $ek_dosya_adi=$kullanici_id.$paylasim_sayisi.".".$dosya_uzantisi;

       $dizin="../dokumanlar/".$ek_dosya_adi;
       if ($dosya_uzantisi=="") {
         $paylasim_sorgu=mysqli_query($baglanti,"INSERT INTO paylasimlar(kullanici_id,grup_id,metin,ek_dosya_adi) VALUES($kullanici_id,$grup_id,'$metin','')");
         if (!$paylasim_sorgu) {
           echo '<div class="alert alert-danger" style="margin-top:40px;">
                 <strong>Başarısız!</strong> Paylaşım Başarısız.
               </div>';

         }
       }else{
         if (in_array(mb_strtolower($dosya_uzantisi),$kabul_edilen_uzantilar)) {
             move_uploaded_file($_FILES["ek_dosya"]["tmp_name"],$dizin);
             $paylasim_sorgu=mysqli_query($baglanti,"INSERT INTO paylasimlar(kullanici_id,grup_id,metin,ek_dosya_adi) VALUES($kullanici_id,$grup_id,'$metin','$ek_dosya_adi')");
             if (!$paylasim_sorgu) {
               echo '<div class="alert alert-danger" style="margin-top:40px;">
                     <strong>Başarısız!</strong> Paylaşım Başarısız.
                   </div>';
             }

         }else{
           echo '<div class="alert alert-danger" style="margin-top:40px;">
                 <strong>Başarısız!</strong> Uzantı Geçerli Değil.
               </div>';
         }
       }
       //bildirim
       $sorgugetir=mysqli_query($baglanti,"SELECT * FROM grupuyeleri where grup_id=$grup_id");
       $getir=mysqli_fetch_array($sorgugetir);
       $grup_kullanici=$getir['kullanici_id'];
       $bildirim=mysqli_query($baglanti,"INSERT INTO grup_bildirimi(alici_id,gonderici_id) values('$grup_kullanici','$kullanici_id') ");

   }
   /*Paylaşım Yap Son*/

   $grup_paylasimlari=mysqli_query($baglanti,"SELECT * FROM `paylasimlar` INNER JOIN kullanicilar ON paylasimlar.kullanici_id=kullanicilar.kullanici_id WHERE paylasimlar.grup_id=$grup_id ORDER BY paylasimlar.paylasim_id DESC");

?>
<!--profil-->
<div class="container-fluid">
  <div class="row" style="margin-bottom:2%;">

<!--profil bitiş-->
<!--Sol Taraf-->
<div class="col-12 col-md-3 contentSol text-center">
  <div class="col-12 col-md-12 content">
    <div class="duyuru">
        <?php echo '<img src="../images/gruplogolari/'.$grup["grup_logo"].'" class="grup_logo col-md-offset-2" width="270" height="220"/>'; ?>

            <div class="duyurubaslik"><span><?php echo $grup["grup_adi"]; ?></span></div>
            <p><?php echo $grup["adSoyad"]; ?> tarafından</p>
            <p><?php echo $grup["grup_olusturma_tarihi"]; ?> tarihinde oluşturuldu</p>
            <div class="">
              <?php if ($kontrol){ ?>
               <a data-toggle="modal" href="#tumduyurularmodal" class="btn btn-outline-info my-2 my-sm-0  grupUyeleri" id="tumduyurular">Grup Üyelerini Görüntüle</a>
               <div class="modal fade" id="tumduyurularmodal" role="dialog">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h6>Tüm Üyeler</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <div class="modal-body">
                        <?php
                        $tumUyeler=mysqli_query($baglanti,"SELECT * FROM `grupuyeleri` INNER JOIN kullanicilar ON kullanicilar.kullanici_id=grupuyeleri.kullanici_id WHERE grupuyeleri.grup_id=$grup_id");

                          while ($tumUyelerGetir=mysqli_fetch_array($tumUyeler)) {

                            echo '<div class="" style="padding:2%;">
                              <img src="../profilfotograflari/'.$tumUyelerGetir["profilfotografi"].'" class="profil_foto3" width="40" height="40"style="float:left;margin-right:2%;"/>
                              <span class="tarafindan" style="font-size:13px;"><b>'.$tumUyelerGetir["adSoyad"].'</b> </span><br/>
                              <span style="font-size:12px;float:left">'.$tumUyelerGetir["eMail"].'</span><br>

                              <hr>
                            </div>';
                          }
                        ?>


                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" data-dismiss="modal">Kapat</button>
                      </div>
                    </div>
                  </div>
                </div>
              <?php }else {
                $izin=mysqli_query($baglanti,"SELECT * FROM grupuyeleri WHERE grup_id=$grup_id AND kullanici_id=$id");
                $izinGetir=mysqli_fetch_array($izin);
                if ($izinGetir["izin"]==0) {
                  echo '<a href="grup_ayrinti.php?grup_id='.$grup_id.'&takip=1" class="btn btn-outline-info my-2 my-sm-0 col-md-12  grupUyeleri" style="color:#38bb54;border-color:#38bb54">Takip Et</a>
                  ';
                }else{
                  echo '<a href="grup_ayrinti.php?grup_id='.$grup_id.'&beklemeiptal=1" class="btn btn-outline-info my-2 my-sm-0 col-md-12  grupUyeleri" style="color:#7e8880;border-color:#7e8880">Beklemede</a>
                  ';
                }
              } ?>

          </div>
  </div>
  </div>

</div>

<div class="col-12 col-md-7 contentOrta" style="margin-top:100px;">
  <?php if($kontrol){ ?>
  <!--Paylaşım yapma-->

    <div class="paylasimYap col-md-12 col-12" style="margin-top:0px !important;">
      <form enctype="multipart/form-data" action="" method="post" name="paylasimyap">
        <div class="form-group">
            <textarea class="form-control" rows="1" onkeyup="auto_grow(this)" name="metin" placeholder="Metin giriniz..."></textarea><br>
             <div class="upload" >
                  <div class="fileUpload">

                    <img src="../images/dosya.png" width="25" />
                    <input id="uploadBtn" type="file" class="upload" name="ek_dosya" />
                    </div>
                    <input id="uploadFile" placeholder="Dosya Seçilemedi" disabled="disabled" />
                  <button type="submit" class="btn btn-outline-info my-2 my-sm-0 pull-right paylasbutton" name="paylas">Paylaş</button>
                </div>
        </div>
      </form>
    </div>

  <!--Paylaşım yapma son-->
  <!--Paylaşımlar-->
  <?php
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
				<a href="#" class="paylasan_kullanici">'.$paylasimlariGetir["adSoyad"].'</a>
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
          echo '<div class="text-center" style="margin-bottom: -30px;font-weight:bold;"><a data-toggle="modal" href="#myModal'.$paylasim_id.'" style="color:#673bb7;">Tüm yorumları göster...</a></div><br/>
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
  }else{
    echo '
      <div class="kilitli col-md-12 col-12">
        <img src="../images/kilit.png" alt=""><br>
        <span style="color:red;font-size:18px;">İçerik kilitli!</span><br><span>İçeriği görebilmek için grubu takip etmelisiniz.</span>
      </div>';
  }
   ?>
  <!--Paylaşımlar son-->

</div>
<?php

}else{
  header("Location:gruplar.php");
}
 ?>
 <script type="text/javascript">
   function auto_grow(element) {
     element.style.height = "1px";
     element.style.height = (element.scrollHeight)+"px";

 };
 document.getElementById("uploadBtn").onchange = function () {
 document.getElementById("uploadFile").value = this.value;
 };
 </script>
