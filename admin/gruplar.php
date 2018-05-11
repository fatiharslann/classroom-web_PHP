<?php
  include("admin-header.php");
  include("../veritabani.php");
  if ($_GET) {
    if (isset($_GET["grup_id"])) {
      $grup_id=$_GET["grup_id"];
      $grup=mysqli_query($baglanti,"SELECT grup_logo FROM gruplar WHERE grup_id=$grup_id");
      $gelenGrup=mysqli_fetch_array($grup);
      mysqli_query($baglanti,"DELETE FROM gruplar WHERE grup_id=$grup_id");
      mysqli_query($baglanti,"DELETE FROM grupuyeleri WHERE grup_id=$grup_id");
      $dosya="../images/gruplogolari/".$gelenGrup["grup_logo"];
      unlink($dosya);

    }
  }
  $tumGruplar=mysqli_query($baglanti,"SELECT * FROM gruplar INNER JOIN kullanicilar ON gruplar.grup_kuran_id=kullanicilar.kullanici_id");
 ?>
 <div class="container-fluid " style="margin-top:120px;">
   <div class="row col-md-10 col-12">
     <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">İd</th>
            <th scope="col">Grup Adı</th>
            <th scope="col">Grubu Kuran Kişi </th>
            <th scope="col">Oluşturulma Tarihi</th>
            <th scope="col">Sil</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($tumGruplariGetir=mysqli_fetch_array($tumGruplar)) { ?>
          <tr>
            <th scope="row"><?php echo $tumGruplariGetir["grup_id"]; ?></th>
            <td><?php echo $tumGruplariGetir["grup_adi"]; ?></td>
            <td><?php echo $tumGruplariGetir["adSoyad"]; ?></td>
            <td><?php echo $tumGruplariGetir["grup_olusturma_tarihi"]; ?></td>
            <td>
              <a href="gruplar.php?grup_id=<?php  echo $tumGruplariGetir["grup_id"];?>" style="color:#dc3545;font-weight:bold">Grubu Sil</a>
            </td>

          </tr>
        <?php } ?>
        </tbody>
      </table>




   </div>
 </div>
