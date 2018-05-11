<?php
$ogrenciler=mysqli_query($baglanti,"SELECT * FROM kullanicilar WHERE yetki=0 LIMIT 0,8");
$tumogrenciler=mysqli_query($baglanti,"SELECT * FROM kullanicilar WHERE yetki=0 ");
$duyurular=mysqli_query($baglanti,"SELECT * FROM duyurular ORDER BY duyuru_id DESC LIMIT 0,10");
$tumduyurular=mysqli_query($baglanti,"SELECT * FROM kullanicilar INNER JOIN duyurular ON duyurular.duyuru_yapan_id=kullanicilar.kullanici_id ORDER BY duyurular.duyuru_id DESC");
date_default_timezone_set('Europe/Istanbul');
 ?>
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
                          echo '<li><a href="#">'.$duyuruGetir["duyuru_basligi"].'</a> <span class="yeni"> ((Yeni !))</span></li>';
                        }else{
                          echo '<li><a href="#">'.$duyuruGetir["duyuru_basligi"].'</a></li>';
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
         				        	<form class="" action="duyuruekle.php" method="post">
                            <input type="text" name="baslik" value="" placeholder="Başlık" maxlength="40" style="width:100%;margin-bottom:2%;">
                            <textarea name="duyurumetni" rows="3" style="width:100%;" placeholder="İçerik"></textarea>
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
	           		<div class="akademisyen_baslik"><span>Öğrenciler</span></div>
		            <div class="row">
                  <?php
                    while ($ogrencileriGetir=mysqli_fetch_array($ogrenciler)) {
                      echo '<div class="col-4 col-md-3 text-center">
    		              	 <a href="profilayrinti.php?kullanici_id='.$ogrencileriGetir["kullanici_id"].'"" ><img src="../profilfotograflari/'.$ogrencileriGetir["profilfotografi"].'" class="profil_foto2" width="50" height="50"/>
    		              	<span>'.$ogrencileriGetir["adSoyad"].'</span></a>
    		              </div>';
                    }
                   ?>
                   <a data-toggle="modal" href="#tumakademisyenlermodal" class="btn btn-outline-info my-2 my-sm-0 pull-right paylasbutton" id="tumakademisyenler">Tümünü göster</a>
                   <div class="modal fade" id="tumakademisyenlermodal" role="dialog">
           				    <div class="modal-dialog">
           				      <div class="modal-content">
           				        <div class="modal-header">
           				          <h6>Tüm Öğrenciler</h6>
           				          <button type="button" class="close" data-dismiss="modal">&times;</button>
           				        </div>
           				        <div class="modal-body">
                            <?php
                              while ($tumogrencileriGetir=mysqli_fetch_array($tumogrenciler)) {
                                echo '<div style="padding:2%;text-align:center;">
                        		    	<img src="../profilfotograflari/'.$tumogrencileriGetir["profilfotografi"].'" class="profil_foto3" width="60" height="60"style="margin-left:10%; "/>
                        		    	<span style="font-size:12px"><b>'.$tumogrencileriGetir["adSoyad"].'</b></span><br/> 
                                  <span style="font-size:12px">'.$tumogrencileriGetir["eMail"].'</span><br/>
                                  <span  style="font-size:12px">'.$tumogrencileriGetir["rutbe"].'</span>
                                  <br>
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
