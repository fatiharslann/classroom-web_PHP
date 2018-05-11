
<?php
  include("header.php");
  //Akademisyenleri getir
  $akademisyenler=mysqli_query($baglanti,"SELECT * FROM kullanicilar WHERE yetki=1 LIMIT 0,8");
  $tumakademisyenler=mysqli_query($baglanti,"SELECT * FROM kullanicilar WHERE yetki=1 ");
  $duyurular=mysqli_query($baglanti,"SELECT * FROM duyurular ORDER BY duyuru_id DESC LIMIT 0,10");
  $tumduyurular=mysqli_query($baglanti,"SELECT * FROM kullanicilar INNER JOIN duyurular ON duyurular.duyuru_yapan_id=kullanicilar.kullanici_id ORDER BY duyurular.duyuru_id DESC");
  date_default_timezone_set('Europe/Istanbul');
?>
<!--profil-->
<div class="container-fluid">
  <div class="row">
    <div class="col-md-2  profil text-center">
      <div class="col-md-12">
        <?php echo '<img src="../profilfotograflari/'.$kullanici->profilresmi.'" class="profil_foto" width="150" height="150"/>'; ?>
        <p class="adSoyad"><?php echo $kullanici->ad_soyad; ?></p>
        <span><?php echo $kullanici->mail; ?></span><br/>
        <span><?php echo $kullanici->rutbe; ?></span><br><br>
      </div>
    </div>
<!--profil bitiş-->
<!--İçerik-->
		<div class="col-12 col-md-3 contentSol">
			<div class="col-12 col-md-12 content">
				<div class="duyuru">
	           		<div class="duyurubaslik"><span>Duyurular</span></div>
		            <div class="">
                  <ul>
                    <?php
                      while ($duyuruGetir=mysqli_fetch_array($duyurular)) {
                        $tarih=strtotime($duyuruGetir["duyuru_tarihi"]);
                        $simdi=strtotime(date('Y-m-d H:i:s'));
                        $fark=($simdi-$tarih)/60;//dakika olarak buluyor.
                        if ($fark<4320) {
                          echo '<li><a href="#">'.$duyuruGetir["duyuru_icerigi"].'</a><span class="yeni">Yeni !</span></li>';
                        }else{
                          echo '<li><a href="#">'.$duyuruGetir["duyuru_icerigi"].'</a></li>';
                        }
                      }
                    ?>
		             </ul>
                 <a data-toggle="modal" href="#tumduyurularmodal" class="btn btn-outline-info my-2 my-sm-0  paylasbutton" id="tumduyurular">Tüm duyuruları göster</a>
                 <div class="modal fade" id="tumduyurularmodal" role="dialog">
         				    <div class="modal-dialog">
         				      <div class="modal-content">
         				        <div class="modal-header">
         				          <h6>Tüm Duyurular</h6>
         				          <button type="button" class="close" data-dismiss="modal">&times;</button>
         				        </div>
         				        <div class="modal-body">
                          <?php


                            while ($tumduyurulariGetir=mysqli_fetch_array($tumduyurular)) {

                              echo '<div class="" style="padding:2%;">
                      		    	<img src="../profilfotograflari/'.$tumduyurulariGetir["profilfotografi"].'" class="profil_foto3" width="60" height="60"style="float:left;margin-right:2%;"/>
                      		    	<span class="tarafindan" style="font-size:12px"><b>'.$tumduyurulariGetir["adSoyad"].'</b> tarafından </span><br/>
                      		    	<p>'.$tumduyurulariGetir["duyuru_icerigi"].'</p>

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
                 <a data-toggle="modal" href="#duyurueklemodal" class="btn btn-outline-info my-2 my-sm-0  paylasbutton" id="duyuruekle">Duyuru Ekle</a><br/>
         				 <div class="modal fade" id="duyurueklemodal" role="dialog">
         				    <div class="modal-dialog">
         				      <div class="modal-content">
         				        <div class="modal-header">
         				          <h6>Duyuru Ekle</h6>
         				          <button type="button" class="close" data-dismiss="modal">&times;</button>
         				        </div>
         				        <div class="modal-body">
         				        	<form class="" action="../duyuruekle.php" method="post">
                            <textarea name="duyurumetni" rows="3" style="width:100%;"></textarea>
                            <input type="submit" class="btn btn-success" style="width:100%;" name="" value="Duyuruyu Ekle">
                           </form>

         				        </div>
         				        <div class="modal-footer">
         				          <button type="submit" class="btn btn-danger" data-dismiss="modal">Kapat</button>
         				        </div>
         				      </div>
         				    </div>
           				</div>
	            </div>
			</div>
			</div>
			<div class="col-12 col-md-12 content">
				<div class="akademisyenler">
	           		<div class="akademisyen_baslik"><span>Akademisyenler</span></div>
		            <div class="row">
                  <?php
                    while ($akademisyenleriGetir=mysqli_fetch_array($akademisyenler)) {
                      echo '<div class="col-3 col-md-3 text-center">
    		              	<img src="../profilfotograflari/'.$akademisyenleriGetir["profilfotografi"].'" class="profil_foto2" width="50" height="50"/>
    		              	<span>'.$akademisyenleriGetir["adSoyad"].'</span>
    		              </div>';
                    }
                   ?>
                   <a data-toggle="modal" href="#tumakademisyenlermodal" class="btn btn-outline-info my-2 my-sm-0 pull-right paylasbutton" id="tumakademisyenler">Tümünü göster</a>
                   <div class="modal fade" id="tumakademisyenlermodal" role="dialog">
           				    <div class="modal-dialog">
           				      <div class="modal-content">
           				        <div class="modal-header">
           				          <h6>Tüm Akademisyenler</h6>
           				          <button type="button" class="close" data-dismiss="modal">&times;</button>
           				        </div>
           				        <div class="modal-body">
                            <?php
                              while ($tumakademisyenleriGetir=mysqli_fetch_array($tumakademisyenler)) {
                                echo '<div class="" style="padding:2%;">
                        		    	<img src="../profilfotograflari/'.$tumakademisyenleriGetir["profilfotografi"].'" class="profil_foto3" width="60" height="60"style="float:left;margin-right:2%;"/>
                        		    	<span class="tarafindan" style="font-size:12px"><b>'.$tumakademisyenleriGetir["adSoyad"].'</b></span><br/>

                                  <br><br>
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
		            </div>
	            </div>
			</div>
		</div>
		<div class="col-12 col-md-7 contentOrta">
		<div class="paylasimYap">
			<form>
				<div class="form-group">
				    <textarea class="form-control" rows="1" onkeyup="auto_grow(this)"></textarea>
				     <div class="upload">
		              <div class="fileUpload">
		                <img src="img/dosya.png" width="25" />
		                <input id="uploadBtn" type="file" class="upload" />
		                </div>
		                <input id="uploadFile" placeholder="Dosya Seçilemedi" disabled="disabled" />
		              <button type="submit" class="btn btn-outline-info my-2 my-sm-0 pull-right paylasbutton" name="paylas">Paylaş</button>
	              </div>
				</div>
			</form>
		</div>


		<div class="col-12 col-md-12 content">
			<div class="row">
				<div class="col-2 col-md-2"><img src="img/foto.jpg" class="profil_foto2" width="75" height="75"/></div>
				<div class="col-10 col-md-10">
				<a href="#" class="paylasan_kullanici">Fatma Delen</a>
				<p class="tarih">3 Saat önce</p>
				<p class="paylasim"> Bitter Çikolata Bitter Çikolata Bitter ÇikolataBitter ÇikolataBitter ÇikolataBitter ÇikolataBitter ÇikolataBitter ÇikolataBitter ÇikolataBitter ÇikolataBitter ÇikolataBitter ÇikolataBitter ÇikolataBitter ÇikolataBitter
				</p>
				<a data-toggle="modal" href="#myModal" class="goruldu">150 kişi gördü</a><br/>
				<div class="modal fade" id="myModal" role="dialog">
				    <div class="modal-dialog">
				      <div class="modal-content">
				        <div class="modal-header">
				          <h6>Paylaşımı Gören Kişiler</h6>
				          <button type="button" class="close" data-dismiss="modal">&times;</button>
				        </div>
				        <div class="modal-body">
				        	<div class="gorenKisiler">
						    	<img src="img/foto.jpg" class="profil_foto3" width="40" height="40"/>
						    	<span class="görenler"><b>Hamdi Tolga Kahraman</b><br/>
						    	<hr>
						    </div>
						    <div class="gorenKisiler">
						    	<img src="img/foto.jpg" class="profil_foto3" width="40" height="40"/>
						    	<span class="görenler"><b>Hamdi Tolga Kahraman</b><br/>
						    	<hr>
						    </div>

				        </div>
				        <div class="modal-footer">
				          <button type="submit" class="btn btn-danger" data-dismiss="modal">Kapat</button>
				        </div>
				      </div>
				    </div>
  				</div>
				</div>
			</div>

			</div>
			<div class="col-12 col-md-12 content">
			<div class="row">
				<div class="col-2 col-md-2"><img src="img/foto.jpg" class="profil_foto2" width="75" height="75"/></div>
				<div class="col-10 col-md-10">
				<a href="#" class="paylasan_kullanici">Fatma Delen</a>
				<p class="tarih">3 Saat önce</p>
				<p class="paylasim"> Bitter Çikolata Bitter Çikolata Bitter ÇikolataBitter ÇikolataBitter ÇikolataBitter ÇikolataBitter ÇikolataBitter ÇikolataBitter ÇikolataBitter ÇikolataBitter ÇikolataBitter ÇikolataBitter ÇikolataBitter ÇikolataBitter
				</p>
				<span class="goruldu">150 kişi gördü</span><br/>
				<hr>
				<p class="baslik_yorumlar">Yorumlar</p>
				<div class="yorumlar">
				<span class="yorum_kullanici">Kullanıcı1</span>
				<p class="yorum"> View more commentsView more commentsView more commentsView more commentsView more commentsView more commentsView more comments
				</p>
				</div>
				<hr>
				<form>
				  <div class="form-group">
				    <label class="yorumYap" for="yorumYap">Yorum Yap</label>
				    <textarea class="form-control" id="yorumYap" rows="1" onkeyup="auto_grow(this)"></textarea>
				  </div>
				</form>
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
  <script src="js/jquery-3.2.1.js"></script>
  <script type="text/javascript" src="js/tether.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>

  </body>
</html>
