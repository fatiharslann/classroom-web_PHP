<!DOCTYPE HTML>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/style.css"/>
  <link rel="stylesheet" href="../css/font-awesome.css"/>
  <link rel="stylesheet" href="../css/responsive.css"/>
  <link rel="stylesheet" href="../fonts/font-awesome.min.css" />
  <link href="https://fonts.googleapis.com/css?family=Poppins:300" rel="stylesheet">

  <title>Classroom</title>
</head>
<body>
  <?php
    include("../veritabani.php");
    session_start();
    class GirisYapanKullanici
    {
      public $ad_soyad;
      public $mail;
      public $rutbe;
      public $profilresmi;
      function __construct($baglanti,$id)
      {
        $sorgu=mysqli_query($baglanti,"SELECT * FROM kullanicilar WHERE kullanici_id=$id");
        $sonuc=mysqli_fetch_array($sorgu);
        $this->ad_soyad=$sonuc["adSoyad"];
        $this->mail=$sonuc["eMail"];
        $this->rutbe=$sonuc["rutbe"];
        $this->profilresmi=$sonuc["profilfotografi"];
      }

    }
    $id=$_SESSION["id"];
    $kullanici=new GirisYapanKullanici($baglanti,$id);
   ?>
	<header>
		<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
		  <div class="container-fluid">
		  <form class="form-inline my-2 my-lg-0 text-left search col-md-2" style="float: left;">
		      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
		    </form>
		    <ul class="navbar-nav">
		      <li class="nav-item active col-3 col-md-2">
		        <a class="nav-link" href="index.php"><i class="fa fa-home" aria-hidden="true"></i><span class="headerIcerik">Anasayfa</span><span class="sr-only">(current)</span></a>
		      </li>
		      <li class="nav-item  col-3 col-md-2">
		        <a class="nav-link" href="gruplar.php"><i class="fa fa-users " aria-hidden="true"></i><span class="headerIcerik">Gruplar</span></a>
		      </li>
		      <li class="nav-item col-3 col-md-2">
				<a class="nav-link" href="#"><i class="fa fa-envelope"></i><span class="headerIcerik">Mesajlar</span></a>
			  </li>
				<li class="nav-item  col-3 col-md-2">
					<a class="nav-link" href="#"><i class="fa fa-bell"></i><span class="headerIcerik">Bildirimler</span></a>
				</li>

		    </ul>

		  </div>
		</nav>

	</header>
	<div class="container">
	<div class="row">
<!--profil bitiş-->
<!--kullanici içerik-->
		<div class="col-12 col-md-8">
		</div>

		<div class="col-md-2  profil text-center">
			<div class="col-md-12">
        <?php echo '<img src="../profilfotograflari/'.$kullanici->profilresmi.'" class="profil_foto" width="150" height="150"/>'; ?>
				<p class="adSoyad"><?php echo $kullanici->ad_soyad; ?></p>
				<span><?php echo $kullanici->mail; ?></span><br/>
				<span><?php echo $kullanici->rutbe; ?></span><br><br>

			</div>
		</div>
	</div>
</div>
  <script src="../js/jquery-3.2.1.js"></script>
  <script type="text/javascript" src="../js/tether.js"></script>
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
