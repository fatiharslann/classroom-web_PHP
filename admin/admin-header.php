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
  <title>Admin Paneli -Classroom-</title>
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
   <?php
      $bildirimler="";
      $sorgu=mysqli_query($baglanti,"SELECT*FROM grup_bildirimi INNER JOIN kullanicilar ON grup_bildirimi.gonderici_id=kullanicilar.kullanici_id where grup_bildirimi.alici_id='$id' LIMIT 0,3");
      $sorgu2=mysqli_query($baglanti,"SELECT*FROM grup_bildirimi where grup_bildirimi.alici_id='$id' and grup_bildirimi.durum='0'");
      $bildirimler=mysqli_num_rows($sorgu2);

      $mesaj_sayisi=mysqli_num_rows(mysqli_query($baglanti,"SELECT * FROM mesajlar WHERE alici_id=$id AND okundu=0"));
      //$grup_id=$_GET["grup_id"];
     // $paylasim_id=$_GET["paylasim_id"];

   ?>
  <header>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
      <form class="form-inline my-2 my-lg-0 text-left search col-md-2" style="float: left;">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" name="arama" aria-label="Search">
        </form>
        <ul class="navbar-nav">
          <li class="nav-item active col-3 col-md-2">
            <a class="nav-link" href="index.php"><i class="fa fa-user" aria-hidden="true"></i><span class="headerIcerik">Kullanicilar</span><span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item  col-3 col-md-2">
            <a class="nav-link" href="gruplar.php"><i class="fa fa-users " aria-hidden="true"></i><span class="headerIcerik">Gruplar</span></a>
          </li>
          <li class="nav-item col-3 col-md-2">
            <a class="nav-link" href="duyurular.php"><i class="fa fa-bullhorn"></i><span class="headerIcerik">Duyurular</span></a>
          </li>
          <li class="nav-item col-3 col-md-2">
            <a class="nav-link" href="mesajlar.php"><i class="fa fa-envelope"></i><span class="headerIcerik"><span class="bildirimSayisi"><?php echo $mesaj_sayisi; ?></span>Mesajlar</span></a>
          </li>
          <li class="nav-item  col-3 col-md-2">
            <a class="nav-link" href="bildirimler.php"><i class="fa fa-bell"></i><span class="headerIcerik"><span class="bildirimSayisi"><?php echo $bildirimler; ?></span>Bildirimler</span></a>
            <div>
            <ul>
            <?php while($getir=mysqli_fetch_array($sorgu))
            {
              echo '<li style="list-style:circle;"><a href="#"><span class="bldrm" >'.$getir['zaman'].' tarihinde <b>'.$getir['adSoyad'].'</b> kişisinden '.$getir['konu'].'</span></a></li>
              ';
            }?>
              </ul>
            </div>
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
        <span class="kullaniciAdresi"><?php echo $kullanici->mail; ?></span><br/>
        <p><?php echo $kullanici->rutbe; ?></p><br>
        <a href="sifredegistir.php" class="cikisYap"><i class="fa fa-key"></i> <span>Şifre Değiştir</span> </a> <br> <br>
        <a href="../cikisyap.php" class="sifreDegistir"><i class="fa fa-power-off"></i> <span>Çıkış Yap</span> </a>

      </div>
    </div>
  </div>
</div>
<?php
if($_GET&&@$_GET['arama']){
      @$arama=$_GET['arama'];
      header("Location:arama.php?ara=$arama");
      }
?>
  <script src="../js/jquery-3.2.1.js"></script>
  <script type="text/javascript" src="../js/tether.js"></script>
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
