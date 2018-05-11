
<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Giriş Yap& Üye Ol-Classroom</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link href="css/stylegiris.css" rel='stylesheet' type='text/css'/>
	<link href="css/bootstrap.min.css" rel='stylesheet'/>
	<link href="css/font-awesome.css" rel="stylesheet"> <!-- Font-Awesome-Icons-CSS -->
	<link href="//fonts.googleapis.com/css?family=Hind:300,400,500,600,700&amp;subset=devanagari,latin-ext" rel="stylesheet">
	<style media="screen">
		select{
			display: block;
    width: 100%;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da
		}
		.ppsec{
			padding-top: 6%;
		}
	</style>

</head>
<body>
	<?php

		include("veritabani.php");
		session_start();
		if ($_SESSION) {
			if ($_SESSION["giris"]) {
				$id=$_SESSION["id"];
				$sorgu=mysqli_query($baglanti,"SELECT * FROM kullanicilar WHERE kullanici_id='$id'");
				$girisyapankullanici=mysqli_fetch_array($sorgu);
				if($girisyapankullanici["yetki"]==0){
						header("Location:ogrenci/index.php");
				}else if($girisyapankullanici["yetki"]==1){
						header("Location:akademisyen/index.php");
				}else if($girisyapankullanici["yetki"]==2){
						header("Location:admin/index.php");
				}
			}
		}
		if($_POST){
			if(@$_POST["uyeol"]){
				if($_POST["radio"]=="Öğrenci"){
		      $yetki=0;
					$rutbe=$_POST["ogrencirutbe"];
		    }else{
		      $yetki=1;
					$rutbe=$_POST["akademisyenrutbe"];
		    }
				$adSoyad=$_POST["adSoyad"];
				$eMail=$_POST["eMail"];
				$sifre=$_POST["sifre"];
				$sifreTekrar=$_POST["sifreTekrar"];

				$dosya_uzantisi=explode(".",$_FILES["pp"]["name"]);
	      $dosya_uzantisi=$dosya_uzantisi[count($dosya_uzantisi)-1];
	      $kabul_edilen_uzantilar=array("jpg","jpeg","png","");

				$kullanici_sayisi=mysqli_num_rows(mysqli_query($baglanti,"SELECT * FROM kullanicilar"));
				$ek_dosya_adi=$kullanici_sayisi.".".$dosya_uzantisi;
				$dizin="profilfotograflari/".$ek_dosya_adi;
				if (in_array(mb_strtolower($dosya_uzantisi),$kabul_edilen_uzantilar)) {
					if($sifre==$sifreTekrar){
						if (move_uploaded_file($_FILES["pp"]["tmp_name"],$dizin)) {
							$sifre=md5($sifre);
							$sorgu=mysqli_query($baglanti,"INSERT INTO kullanicilar(adSoyad,eMail,sifre,rutbe,yetki,profilfotografi) VALUES('$adSoyad','$eMail','$sifre','$rutbe',$yetki,'$ek_dosya_adi')");
							if($sorgu){
								$_SESSION["giris"]=true;
								$sonEklenenkullanici=mysqli_query($baglanti,"SELECT kullanici_id,yetki FROM kullanicilar ORDER BY kullanici_id DESC LIMIT 0,1 ");
								$sonKullanici=mysqli_fetch_array($sonEklenenkullanici);
								$_SESSION["id"]=$sonKullanici["kullanici_id"];
								if($sonKullanici["yetki"]==0){
										header("Location:ogrenci/index.php");
								}else if($sonKullanici["yetki"]==1){
										header("Location:akademisyen/index.php");
								}else if($sonKullanici["yetki"]==2){
										header("Location:admin/index.php");
								}
								echo '<div class="alert alert-success">
					            <strong>Başarılı!</strong> Kayıt Başarılı.
					          </div>';
							}else{
								echo '<div class="alert alert-danger">
					            <strong>Başarısız!</strong> Kayıt Başarısız.
					          </div>';
							}
		        }else{
							echo '<div class="alert alert-danger">
										<strong>Başarısız!</strong> Kayıt Başarısız.
									</div>';
		        }

					}else{
						echo '<div class="alert alert-danger">
			            <strong>Başarısız!</strong> Şifreler Uyumsuz.
			          </div>';
					}
				}else{
					echo '<div class="alert alert-danger">
								<strong>Başarısız!</strong> Profil resmi için uzantı geçersiz.
							</div>';
				}

			}
			 if(@$_POST["giris"]){
				$eMail=$_POST["giriseMail"];
				$sifre=md5($_POST["girissifre"]);
				$tumKullanicilar=mysqli_query($baglanti,"SELECT * FROM kullanicilar");
				while($sonuc=mysqli_fetch_array($tumKullanicilar)){
					if($eMail==$sonuc["eMail"]&&$sifre==$sonuc["sifre"]){
						$kontrol=true;
						$_SESSION["id"]=$sonuc["kullanici_id"];
						break;
					}
				}
				if($kontrol==true){
					$_SESSION["giris"]=true;
					$id=$_SESSION["id"];
					$sorgu=mysqli_query($baglanti,"SELECT * FROM kullanicilar WHERE kullanici_id='$id'");
	        $girisyapankullanici=mysqli_fetch_array($sorgu);
					if($girisyapankullanici["yetki"]==0){
							header("Location:ogrenci/index.php");
					}else if($girisyapankullanici["yetki"]==1){
							header("Location:akademisyen/index.php");
					}else{
							header("Location:admin/index.php");
					}
				}
			}
		}
	 ?>
<div class="layer">
	<img src="images/logo.png" style="width:30%;margin-left:35%;" />
	<div class="main-agile1" >
		<div class="w3layouts-main" style="margin-bottom:9.5%;margin-left:25%;margin-top:3%;" id="girisdiv">
			<h2>Giriş Yap</h2>
						<form action="#" method="post">
							<div class="email">
							<input placeholder="E-Mail" name="giriseMail" id="giriseMail" type="email" required="">
							<span class="icons i1"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
							</div>
							<div class="email">
							<input placeholder="Şifre" name="girissifre" type="password" required="">
							<span class="icons i2"><i class="fa fa-unlock" aria-hidden="true"></i></span>
							</div>
							<input type="submit" value="Giriş Yap" name="giris">
							<br><br><span style="color:white" onclick="gizle()">Üye Olmak için <i>tıklayın...</i></span><br>

						</form>
		</div>
		<div class="w3layouts-main" style="margin-bottom:7.5%;margin-left:25%;margin-top:3%;display:none" id="uyeoldiv">
			<h2>Üye Ol</h2>
			<form action="" enctype="multipart/form-data" method="post" autocomplete="off" style="margin-top:5%;">
					<label style="color:white;"><input type="radio" id="akademisyen" name="radio" value="Akademisyen"/>Akademisyen</label>
					<label style="color:white"><input type="radio" id="ogrenci" name="radio" value="Öğrenci" checked/>Öğrenci</label>

					<div class="email">
					<input placeholder="Ad Soyad" name="adSoyad" type="text" required="" >
					<span class="icons i1"><i class="fa fa-user" aria-hidden="true"></i></span>
					</div>
					<div class="email">

					<input placeholder="E-Mail" name="eMail" type="email" required="">
					<span class="icons i1"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
					</div>
					<div class="email">
					<input placeholder="Şifre" name="sifre" type="password" required="">
					<span class="icons i1"><i class="fa fa-unlock" aria-hidden="true"></i></span>
					</div>
					<div class="email">
					<input placeholder="Şifre Tekrar" name="sifreTekrar" type="password" required="">
					<span class="icons i1"><i class="fa fa-unlock" aria-hidden="true"></i></span>
					</div>
					<div id="secogrenci">
						<select name="ogrencirutbe" class="form-control">
							<option selected>HAZIRLIK</option>
							<option>1.SINIF</option>
							<option>2.SINIF</option>
							<option>3.SINIF</option>
							<option>4.SINIF</option>
						</select>
				</div>
				<div id="secakademisyen" style="display:none;">
						<select name="akademisyenrutbe" class="form-control">
							<option selected>ÖĞRETİM GÖREVLİSİ</option>
							<option>YARDIMCI DOÇENT</option>
							<option>DOÇENT</option>
							<option>PROFESÖR</option>
						</select>
				</div>
				<div class="ppsec">
					<label for="ozelbuton" style="margin-top:2%;">
						<img src="images/upload.png" style="width:25px;height:25px;" alt="">
						<span style="color:#9dbde0;">Profil Fotoğrafı Seç</span>
					</label><br>
					<input id="ozelbuton" name="pp" type="file" style="display:none;"/>
				</div>


				<input type="submit" value="Üye ol" name="uyeol">
				<br><br><span style="color:white" onclick="goster()">Giriş yapmak <i>tıklayın...</i></span><br>
			</form>
		</div>

		<div class="clear"></div>
	</div>
</div>
<script type="text/javascript" src="js/jquery.min.js">

</script>
<script>
$(document).ready(function() {
	$("#akademisyen, #ogrenci").change(function() {
			$("#secakademisyen, #secogrenci").toggle();
	});
});
function goster(){
	document.getElementById("girisdiv").style.display="block";
	document.getElementById("uyeoldiv").style.display="none";

}
function gizle(){
	document.getElementById("girisdiv").style.display="none";
	document.getElementById("uyeoldiv").style.display="block";

}

</script>
</body>
</html>
