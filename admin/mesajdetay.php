<?php
include("../veritabani.php");
session_start();
$gonderici_id=$_SESSION["id"];
$alici_id=$_GET["alici_id"];
$kullaniciGetir=mysqli_query($baglanti,"SELECT * FROM kullanicilar WHERE kullanici_id=$alici_id");
$gelenKullanici=mysqli_fetch_array($kullaniciGetir);
$eskiMesajlar=mysqli_query($baglanti,"SELECT *FROM mesajlar WHERE (alici_id=$alici_id AND gonderici_id=$gonderici_id)OR(alici_id=$gonderici_id AND gonderici_id=$alici_id)");
?>
<div id="mesajAt" class="tab-pane col-md-12" >
  <div class="yeniAcilan">
  <div class="mesajAtilanKisi col-md-12 text-center"><?php echo $gelenKullanici["adSoyad"]; ?> ile Mesajlarım</div>
  <div class="mesaj" id="mesajlar">
    <ul id="liste">
      <?php
        while ($eskiMesajlariGetir=mysqli_fetch_array($eskiMesajlar)) {
          if ($eskiMesajlariGetir["gonderici_id"]==$gonderici_id) {
            echo '<li class="divmesaj" id="'.$eskiMesajlariGetir["mesaj_id"].'"><div class="mesajAtan col-7 col-md-7 pull-right" >
                '.$eskiMesajlariGetir["mesaj"].'
            </div></li>';
          }else{
            echo '<li class="divmesaj" id="'.$eskiMesajlariGetir["mesaj_id"].'"><div class="mesajGonderen col-7 col-md-7 pull-left" >
                '.$eskiMesajlariGetir["mesaj"].'
            </div></li>';
          }
          $goruldu_uptade = mysqli_query($baglanti,"UPDATE mesajlar SET okundu=1 WHERE (alici_id=$alici_id AND gonderici_id=$gonderici_id)OR(alici_id=$gonderici_id AND gonderici_id=$alici_id)");

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
