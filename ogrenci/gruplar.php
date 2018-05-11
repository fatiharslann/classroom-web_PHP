    <?php
      include("header.php");
      include("../veritabani.php");
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

    <div class="container">
    	<div class="row">
    <!--profil bitiş-->
    <!--kullanici içerik-->
    		<div class="col-12 col-md-10 profile" style="margin-top:130px !important">




    		  <div id="gruplar" class="tab-pane" >

    		    <div class="takipEttiklerin" style="padding:2%;">
    		    	<img src="img/foto.jpg" class="profil_foto3" width="60" height="60"/>
    		    	<span class="tarafindan"><b>Hamdi Tolga Kahraman</b> tarafından </span><br/>
    		    	<span class="grupAdi">Yapay Zeka Grubu</span>
    		    	<a href="#" class="takip" style="float: right;">Takipten Çık</a>
    		    	<hr>
    		    </div>
    		    <div class="takipEttiklerin" style="padding:2%;">
    		    	<img src="img/foto.jpg" class="profil_foto3" width="60" height="60"/>
    		    	<span class="tarafindan"><b>Hamdi Tolga Kahraman</b> tarafından </span><br/>
    		    	<span class="grupAdi">Yapay Zeka Grubu</span>
    		    	<a href="#" class="takip" style="float: right;">Takipten Çık</a>
    		    	<hr>
    		    </div>

    		  </div>


    		</div>


    	</div>
    </div>

  </body>
</html>
