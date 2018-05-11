<?php
  include("admin-header.php");
  include("../veritabani.php");
  if ($_GET) {
    if (isset($_GET["adminlikver"])&&$_GET["adminlikver"]) {
      $kullanici_id=$_GET["kullanici_id"];
      $adminlikVerSorgu=mysqli_query($baglanti,"UPDATE kullanicilar SET yetki=2 WHERE kullanici_id=$kullanici_id");

    }else if(isset($_GET["adminlikver"])&&!$_GET["adminlikver"]){
      $kullanici_id=$_GET["kullanici_id"];
      $adminlikAlSorgu=mysqli_query($baglanti,"UPDATE kullanicilar SET yetki=0 WHERE kullanici_id=$kullanici_id");

    }else if($_GET["kullanicisil"]){
      echo "string";
      $kullanici_id=$_GET["kullanici_id"];
      $silSorgu=mysqli_query($baglanti,"DELETE FROM kullanicilar WHERE kullanici_id=$kullanici_id");
    }
  }
  $tumKullanicilar=mysqli_query($baglanti,"SELECT * FROM kullanicilar");
 ?>
 <div class="container-fluid " style="margin-top:120px;">
   <div class="row col-md-10 col-12">
     <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">İd</th>
            <th scope="col">Ad Soyad</th>
            <th scope="col">E-mail</th>
            <th scope="col">Tip</th>
            <th scope="col">Rütbe</th>
            <th scope="col">Adminlik</th>
            <th scope="col">Sil</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($tumKullanicilariGetir=mysqli_fetch_array($tumKullanicilar)) { ?>
          <tr>
            <th scope="row"><?php echo $tumKullanicilariGetir["kullanici_id"]; ?></th>
            <td><?php echo $tumKullanicilariGetir["adSoyad"]; ?></td>
            <td><?php echo $tumKullanicilariGetir["eMail"]; ?></td>
            <td>
              <?php
                if ($tumKullanicilariGetir["yetki"]==0) {
                  echo "Öğrenci";
                }else if($tumKullanicilariGetir["yetki"]==1){
                  echo "Akademisyen";
                }else{
                  echo "Admin";
                }
              ?>
            </td>
            <td><?php echo $tumKullanicilariGetir["rutbe"]; ?></td>
            <td>
              <?php
                if ($tumKullanicilariGetir["yetki"]==0||$tumKullanicilariGetir["yetki"]==1) {?>
                  <a href="index.php?adminlikver=1&kullanici_id=<?php echo $tumKullanicilariGetir['kullanici_id']; ?>" style="color:#28a745;font-weight:bold">Adminlik Ver</a>
                <?php }else{ ?>
                  <a href="index.php?adminlikver=0&kullanici_id=<?php echo $tumKullanicilariGetir['kullanici_id']; ?>" style="color:#dc3545;font-weight:bold">Adminlik Al</a>
                <?php } ?>
            </td>
            <td>
              <a href="index.php?kullanicisil=1&kullanici_id=<?php echo $tumKullanicilariGetir['kullanici_id']; ?>" style="color:#dc3545;font-weight:bold">Kullaniciyi Sil</a>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>




   </div>
 </div>
