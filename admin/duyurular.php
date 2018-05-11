<?php
  include("admin-header.php");
  include("../veritabani.php");
  if ($_GET) {
    if (isset($_GET["duyuru_id"])) {
      $duyuru_id=$_GET["duyuru_id"];
      $grup=mysqli_query($baglanti,"SELECT grup_logo FROM gruplar WHERE grup_id=$grup_id");
      $gelenGrup=mysqli_fetch_array($grup);
      mysqli_query($baglanti,"DELETE FROM gruplar WHERE grup_id=$grup_id");
      mysqli_query($baglanti,"DELETE FROM grupuyeleri WHERE grup_id=$grup_id");
      $dosya="../images/gruplogolari/".$gelenGrup["grup_logo"];
      unlink($dosya);

    }
  }
  $tumDuyurular=mysqli_query($baglanti,"SELECT * FROM duyurular INNER JOIN kullanicilar ON duyurular.duyuru_yapan_id=kullanicilar.kullanici_id");
 ?>
 <div class="container-fluid " style="margin-top:120px;">
   <div class="row col-md-10 col-12">
     <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">İd</th>
            <th scope="col">Duyuru Başlığı</th>
            <th scope="col">Duyuru İçeriği </th>
            <th scope="col">Duyuruyu Yapan Kişi</th>
            <th scope="col">Duyuru Tarihi</th>
            <th scope="col">Sil</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($tumDuyurulariGetir=mysqli_fetch_array($tumDuyurular)) { ?>
          <tr>
            <th scope="row"><?php echo $tumDuyurulariGetir["duyuru_id"]; ?></th>
            <td><?php echo substr($tumDuyurulariGetir["duyuru_basligi"],0,15)."..."; ?></td>
            <td><?php echo substr($tumDuyurulariGetir["duyuru_icerigi"],0,15)."..."; ?></td>
            <td><?php echo $tumDuyurulariGetir["adSoyad"]; ?></td>
            <td><?php echo $tumDuyurulariGetir["duyuru_tarihi"]; ?></td>
            <td>
              <a href="duyurular.php?duyuru_id=<?php  echo $tumDuyurulariGetir["duyuru_id"];?>" style="color:#dc3545;font-weight:bold">Duyuruyu Sil</a>
            </td>

          </tr>
        <?php } ?>
        </tbody>
      </table>




   </div>
 </div>
