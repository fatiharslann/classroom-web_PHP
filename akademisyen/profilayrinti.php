<?php
 include("header.php");
 if ($_GET) {
   $kullanici_id=$_GET["kullanici_id"];
   $kullaniciGetir=mysqli_query($baglanti,"SELECT * FROM kullanicilar WHERE kullanici_id=$kullanici_id");
   $gelenKullanici=mysqli_fetch_array($kullaniciGetir);
   $tumGruplarr=mysqli_query($baglanti,"SELECT * FROM gruplar INNER JOIN kullanicilar ON gruplar.grup_kuran_id=kullanicilar.kullanici_id ORDER BY gruplar.grup_id DESC");
   $mesajlar=mysqli_query($baglanti,"SELECT * FROM mesajlar WHERE (alici_id=$kullanici_id AND gonderici_id=$id) OR (gonderici_id=$kullanici_id AND alici_id=$id)");
   $gonderici_id=$_SESSION["id"];

?>
<!--profil-->
<div class="container-fluid">
  <div class="row">

<!--profil bitiş-->
<!--Sol Taraf-->
<div class="col-12 col-md-3 contentSol text-center">
  <div class="col-12 col-md-12 content">
    <div class="duyuru">
        <?php echo '<img src="../profilfotograflari/'.$gelenKullanici["profilfotografi"].'" class="col-md-offset-2 profil_foto4" width="270" height="220"/>'; ?>

            <div class="kullaniciBilgisi">
            <b><?php echo $gelenKullanici["adSoyad"]; ?></b><br>
            <span class="kullaniciAdresi"><?php echo $gelenKullanici["eMail"]; ?></span><br/>
            <span><?php echo $gelenKullanici["rutbe"]; ?></span>
            </div>
  </div>
  </div>

</div>

<!--Sol Taraf Bitiş-->
    <div class="col-12 col-md-6 profile">
    <ul class="nav nav-tabs">
      <li class="active col-6 col-md-6"><a data-toggle="tab" href="#gruplar">Takip Ettiği Gruplar</a></li>
      <li class="col-6 col-md-6"><a data-toggle="tab" href="#mesajAt">Mesaj At</a></li>
    </ul>

    <div class="tab-content">
     <div id="gruplar" class="tab-pane fade">
            <?php

              while ($tumGruplariGetir=mysqli_fetch_array($tumGruplarr)) {
                $grup_id=$tumGruplariGetir["grup_id"];
                $uyeolunangruplar=mysqli_query($baglanti,"SELECT * FROM grupuyeleri WHERE kullanici_id=$kullanici_id AND grup_id=$grup_id");
                if (mysqli_num_rows($uyeolunangruplar)) {
                  echo '<div class="yeniAcilan">
                    <a href="grup_ayrinti.php?grup_id='.$tumGruplariGetir["grup_id"].'"><img src="../images/gruplogolari/'.$tumGruplariGetir["grup_logo"].'" class="profil_foto3" width="60" height="60"/></a>
                    <a href="grup_ayrinti.php?grup_id='.$tumGruplariGetir["grup_id"].'" class="paylasan_kullanici" style="font-size:18px;">'.$tumGruplariGetir["grup_adi"].'</a><br>
                    <span class="tarafindan"><b>'.$tumGruplariGetir["grup_olusturma_tarihi"].'</b> tarihinde, </span><br/>
                    <span><b>'.$tumGruplariGetir["adSoyad"].'</b> tarafından oluşturuldu.</span>
                    <hr>
                  </div>';

                }

              }
             ?>

          </div>
          <div id="mesajAt" class="tab-pane col-md-10" style="margin-top:150px;">
            <div class="yeniAcilan">
            <div class="mesajAtilanKisi col-md-12 text-center"><?php echo $gelenKullanici["adSoyad"]; ?> ile Mesajlarım</div>
            <div class="mesaj" id="mesajlar">
              <ul id="liste">
                <?php
                  while ($eskiMesajlariGetir=mysqli_fetch_array($mesajlar)) {
                    if ($eskiMesajlariGetir["gonderici_id"]==$gonderici_id) {
                      echo '<li class="divmesaj" id="'.$eskiMesajlariGetir["mesaj_id"].'"><div class="mesajAtan col-7 col-md-7 pull-right" >
                          '.$eskiMesajlariGetir["mesaj"].'
                      </div></li>';
                    }else{
                      echo '<li class="divmesaj" id="'.$eskiMesajlariGetir["mesaj_id"].'"><div class="mesajGonderen col-7 col-md-7 pull-left" >
                          '.$eskiMesajlariGetir["mesaj"].'
                      </div></li>';
                    }
                  }
                ?>
              </ul>

          </div>

            <form id="mesajForm" action="mesajgonder.php?kullanici_id=<?php echo $alici_id;  ?>" method="post">
              <textarea class="form-control col-md-11 col-11" id="mesaj" class="input" rows="1" onkeyup="auto_grow(this)" style="height: 35px;float:left" name="mesaj"></textarea>
              <input id="gonder" type="image" value="submit" src="../images/send.png" class="col-1 col-md-1" style="float: right;"/>

            </form>
            </div>
          </div>
    </div>
    </div>




</div>
</div>
<script>
  $('.nav-tabs a').click(function(){
    $(this).tab('show');
})

// Select tab by name
$('.nav-tabs a[href="#gruplar"]').tab('show')

</script>
<script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>

    <script type="text/javascript">
      $("#mesajForm").on('submit',function() {
        return  false;
      });
      $("#gonder").click(function() {
        var mesaj=$("#mesaj").serialize();
        $('#mesaj').val('');
        $.ajax({
          type: 'POST',
          url: $('#mesajForm').attr("action"),
          data:mesaj,
          success:function () {

          }
        });

      });
    </script>
    <script type="text/javascript">
      var vericek=function() {
        var elemanlar=document.getElementById("liste").children;
        var sonid=0;
        if (elemanlar.length!=0) {
          sonid=document.getElementById("liste").lastElementChild.id;
        }
        var mesajdivi=document.getElementById("mesajlar");
        mesajdivi.scrollTop = mesajdivi.scrollHeight;
        $.ajax({
          type:'POST',
          url:'listele.php?alici_id=<?php echo $alici_id; ?>',
          data:{'sonid':sonid},
          dataType:'json',
          success:function(cevap) {
            $("#liste").append(cevap.veriler);
          }
        });
      }
      vericek();
      setInterval('vericek()',500);
    </script>

<?php
}
 ?>
