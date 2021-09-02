<?php

$db = new mysqli("localhost","root","","uyeler") or die("Bağlantı Başarısız");
$db -> set_charset("utf8");

class islemler{
public static function listele($veri){
        $s="select * from kisisel";
        $tumveri=$veri->prepare($s);
        $tumveri->execute();
        $sonuc=$tumveri->get_result();
 
        if($sonuc->num_rows==0):
         echo '<tr class="table-danger">
         <td colspan="8">
         <p class="text-danger">Kayıtlı Üye Yok</p>
         </td> 
         </tr>';
        else:
         while($satir=$sonuc->fetch_assoc()):
           echo '<tr>
           <td>'.$satir["id"].'</td>
           <td>'.$satir["ad"].'</td>
           <td>'.$satir["soyad"].'</td>
           <td>'.$satir["tc"].'</td>
           <td>'.$satir["meslek"].'</td>
           <td>'.$satir["aidat"].'</td>
           <td>'.islemler::yetki($satir["yetki"]).'</td>
           <td style="text-align:center;"><a href="index.php?islem=guncelle&id='.$satir["id"].'" class="btn btn-info" >Güncelle</a>
           <a href="index.php?islem=sil&id='.$satir["id"].'" class="btn btn-danger" >Sil</a>
           
           </td>
         </tr>';
         endwhile;
         $veri->close();
        endif;

    }
public static function yetki($veri){
        $sondurum;
        if($veri==1):
            return $sondurum='<p class="text-danger">Normal Üye</p>';
            elseif($veri==2):
                return $sondurum='<p class="text-warning">Özel Üye</p>';
                elseif($veri==3):
                    return $sondurum='<p class="text-success">VİP Üye</p>';
        
        endif;

    }
public static function sil($verim1,$verim2){
        if($verim1!=""):
            $sil="delete from kisisel where id=$verim1";
            $ok=$verim2->prepare($sil);
            $ok->execute();
            $sonuc=$ok->get_result();

            if(!$sonuc):
                echo '<div class="alert alert-success">Kayıt Başarıyla SİLİNDİ<br>Yükleniyor</div>';
                header("refresh:2;url=index.php");                        
            else:
                echo '<div class="alert alert-danger">HATA VAR<br>Yükleniyor</div>';
                header("refresh:2;url=index.php");                                   
            endif;
        else:
            echo '<div class="alert alert-danger">HATA VAR<br>Yükleniyor</div>';
            header("refresh:2;url=index.php"); 
        endif;

    }
    
public static function eklemeform(){
 ?>        

 <form action="index.php?islem=ekleson" method="POST">
 <table class="table  table-bordered " style="text-align:center">
   
    <thead>
      <tr>
        <th colspan="12">YENI ÜYE KAYDET</th>      
      </tr>
    </thead>
    
    <tbody>
    <tr>
    <th colspan="4"></th>
    <th colspan="4">Ad</th>
    <th colspan="4" style="text-align:left;"><input name="ad" type="text" /></th>
    </tr>
    
    <tr>
    <th colspan="4"></th>
    <th colspan="4">Soyad</th>
    <th colspan="4" style="text-align:left;"><input name="soyad" type="text" /></th>
    </tr>
    
    <tr>
    <th colspan="4"></th>
    <th colspan="4">Tc</th>
    <th colspan="4" style="text-align:left;"><input name="tc" type="text" /></th>
    </tr>
    
    <tr>
    <th colspan="4"></th>
    <th colspan="4">Meslek</th>
    <th colspan="4" style="text-align:left;"><input name="meslek" type="text" /></th>
    </tr>
    
    <tr>
    <th colspan="4"></th>
    <th colspan="4">Aidat</th>
    <th colspan="4" style="text-align:left;"><input name="aidat" type="text" /></th>
    </tr>
    
    <tr>
    <th colspan="4"></th>
    <th colspan="4">Yetki</th>
    <th colspan="4" style="text-align:left;">
    <select name="yetki">
    <option value="1">Normal</option>
    <option value="2">Özel</option>
    <option value="3">Vip</option>
    </select></th>
    </tr>
    
     <tr>
    <th colspan="12"><input type="submit" name="fbuton" class="btn btn-success" value="EKLE"></th>

    </tr>
    
    </tbody>
    
    
 </table>
 </form>

<?php
 } 
public static function ekle($veri){
     $butonum=$_POST["fbuton"];
     if($butonum):
        $ad=htmlspecialchars($_POST["ad"]);
        $soyad=htmlspecialchars($_POST["soyad"]);
        $tc=htmlspecialchars($_POST["tc"]);
        $meslek=htmlspecialchars($_POST["meslek"]);
        $aidat=htmlspecialchars($_POST["aidat"]);
        $yetki=htmlspecialchars($_POST["yetki"]);
     $sql="INSERT INTO kisisel(ad,soyad,tc,meslek,aidat,yetki) VALUES('$ad','$soyad',$tc,'$meslek',$aidat,$yetki)";       

     $ekle=$veri->prepare($sql);
     $ekle->execute();
      $son=$ekle->get_result();
        if(!$son):
            echo '<div class="alert alert-success">KAYIT Başarılı<br>Yükleniyor</div>';
            header("refresh:2;url=index.php");
        else:
            echo '<div class="alert alert-danger">Kayıt HATALI<br>Yükleniyor</div>';
            header("refresh:2;url=index.php");


        endif;
     else:
        echo '<div class="alert alert-danger">HATA VAR<br>Yükleniyor</div>';
        header("refresh:2;url=index.php");




        
     endif;
     $veri->close();

 }
public static function guncelle($gundb){
    @$id=$_GET["id"];
    $liste="select * from kisisel where id=$id";
    $guncelle=$gundb->prepare($liste);
    $guncelle->execute();
    $sonuc=$guncelle->get_result();
    $result=$sonuc->fetch_assoc();
    ?>        
    <form action="index.php?islem=guncelleson" method="POST">
    <table class="table  table-bordered " style="text-align:center">
       <thead>
         <tr>
           <th colspan="12">ÜYE GEÜNCELLEME</th>      
         </tr>
       </thead>
       <tbody>
       <tr>
       <th colspan="4"></th>
       <th colspan="4">Ad</th>
       <th colspan="4" style="text-align:left;"><input name="ad" type="text" value="<?php echo $result["ad"]; ?>" /></th>
       </tr>
       
       <tr>
       <th colspan="4"></th>
       <th colspan="4">Soyad</th>
       <th colspan="4" style="text-align:left;"><input name="soyad" type="text" value="<?php echo $result["soyad"]; ?>"/></th>
       </tr>
       
       <tr>
       <th colspan="4"></th>
       <th colspan="4">Tc</th>
       <th colspan="4" style="text-align:left;"><input name="tc" type="text" value="<?php echo $result["tc"]; ?>" /></th>
       </tr>
       
       <tr>
       <th colspan="4"></th>
       <th colspan="4">Meslek</th>
       <th colspan="4" style="text-align:left;"><input name="meslek" type="text" value="<?php echo $result["meslek"]; ?>" /></th>
       </tr>
       
       <tr>
       <th colspan="4"></th>
       <th colspan="4">Aidat</th>
       <th colspan="4" style="text-align:left;"><input name="aidat" type="text" value="<?php echo $result["aidat"]; ?>"/></th>
       </tr>

       <tr>
       <th colspan="4"></th>
       <th colspan="4">Yetki</th>
       <th colspan="4" style="text-align:left;">
       <select name="yetki">
           <?php

           if($result["yetki"]==1):
            echo '<option value="1" selected="selected">Normal</option>
            <option value="2">Özel</option>
            <option value="3">Vip</option>';
            elseif($result["yetki"]==2):
                echo '<option value="1">Normal</option>
                <option value="2" selected="selected">Özel</option>
                <option value="3">Vip</option>';
                elseif($result["yetki"]==3):
                    echo '<option value="1">Normal</option>
                    <option value="2">Özel</option>
                    <option value="3" selected="selected">Vip</option>';
           endif;                                
           ?>
       </select></th>
       </tr>
        <tr>
       <th colspan="12">
       <input type="hidden" name="uyeid" value="<?php echo $result["id"]; ?>"/>
       <input type="submit" name="fbuton" class="btn btn-success" value="GÜNCELLE"></th>
       </tr>  
       </tbody>    
    </table>
    </form>
<?php
}
public static function guncelleson($veri){
    $butonum=$_POST["fbuton"];
    if($butonum):
       $id=$_POST["uyeid"];
       $ad=htmlspecialchars($_POST["ad"]);
       $soyad=htmlspecialchars($_POST["soyad"]);
       $tc=htmlspecialchars($_POST["tc"]);
       $meslek=htmlspecialchars($_POST["meslek"]);
       $aidat=htmlspecialchars($_POST["aidat"]);
       $yetki=htmlspecialchars($_POST["yetki"]);
    $sql="UPDATE kisisel set ad='$ad' , soyad='$soyad' , tc=$tc , meslek='$meslek' , aidat=$aidat , yetki=$yetki where id=$id";

    $ekle=$veri->prepare($sql);
    $ekle->execute();
     $son=$ekle->get_result();
       if(!$son):
           echo '<div class="alert alert-success">KAYIT GÜNCELLENDİ<br>Yükleniyor</div>';
           header("refresh:2;url=index.php");
       else:
           echo '<div class="alert alert-danger">Kayıt HATALI<br>Yükleniyor</div>';
           header("refresh:2;url=index.php");


       endif;
    else:
       echo '<div class="alert alert-danger">HATA VAR<br>Yükleniyor</div>';
       header("refresh:2;url=index.php");




       
    endif;
    $veri->close();

}
public static function ara(){
    ?>
    
    <form action="index.php?islem=aramasonuc" method="POST">
  
  Aranacak Kriter <select name="kriter">
  <option value="ad">AD</option>
  <option value="soyad">SOYAD</option>
  <option value="tc">TC</option>
  <option value="meslek">MESLEK</option>
  <option value="aidat">AİDAT</option>
  <option value="yetki">YETKİ</option>
  </select>
  
  <input type="text" name="ara" placeholder="Aranacak Veri"/>
  <input type="submit" name="buton" value="ARA"/>

  </form>
    
   <?php 
    
}   
    
public static function aramasonuc($dbveri){
 ?>

 <div class="container">
  <h2><a href="index.php">Anasyfaya Dön</a>ARAMA SONUÇLAR</h2>
  
    
  <table class="table  table-bordered table-hover" style="text-align:center">
  <thead>
        <th colspan="8"><?php islemler::ara(); ?></th>
      </tr>
    </thead>

    <thead>
      <tr class="table-light">
        <th>Üye id</th>
        <th>Ad</th>
        <th>Soyad</th>
        <th>Tc</th>
        <th>Meslek</th>
        <th>Aidat</th>
        <th>Üye Tipi</th>
        <th>İşlemler<a href="index.php?islem=ekle" class="btn btn-success">EKLE</a></th>
      </tr>
    </thead>
    <tbody>   
 <?php

 $kriter=htmlspecialchars($_POST["kriter"]);
 $veri=htmlspecialchars($_POST["ara"]);
 $buton=htmlspecialchars($_POST["buton"]);

 if($buton):
    if($kriter=="ad" || $kriter=="soyad" || $kriter=="meslek"):
        $ara="select * from kisisel where $kriter LIKE '%$veri%'";
        $sonuc=$dbveri->prepare($ara);
        $sonuc->execute();
        $b=$sonuc->get_result();
            if($b->num_rows!=0):
                while($satir=$b->fetch_assoc()):
                    echo '<tr>
                    <td>'.$satir["id"].'</td>
                    <td>'.$satir["ad"].'</td>
                    <td>'.$satir["soyad"].'</td>
                    <td>'.$satir["tc"].'</td>
                    <td>'.$satir["meslek"].'</td>
                    <td>'.$satir["aidat"].'</td>
                    <td>'.islemler::yetki($satir["yetki"]).'</td>
                    <td style="text-align:center;"><a href="index.php?islem=guncelle&id='.$satir["id"].'" class="btn btn-info" >Güncelle</a>
                    <a href="index.php?islem=sil&id='.$satir["id"].'" class="btn btn-danger" >Sil</a>
                    
                    </td>
                  </tr>';
                  endwhile;
                else:
                    echo '<div class="alert alert-danger">ARAMAYA GÖRE KAYIT YOK<br>Yükleniyor</div>';
                    header("refresh:2;url=index.php"); 
            endif;
        else: //diğer kalan kriterler

        $ara="select * from kisisel where $kriter LIKE '$veri'";
        $sonuc=$dbveri->prepare($ara);
        $sonuc->execute();
        $b=$sonuc->get_result();
            if($b->num_rows!=0):
                while($satir=$b->fetch_assoc()):
                    echo '<tr>
                    <td>'.$satir["id"].'</td>
                    <td>'.$satir["ad"].'</td>
                    <td>'.$satir["soyad"].'</td>
                    <td>'.$satir["tc"].'</td>
                    <td>'.$satir["meslek"].'</td>
                    <td>'.$satir["aidat"].'</td>
                    <td>'.islemler::yetki($satir["yetki"]).'</td>
                    <td style="text-align:center;"><a href="index.php?islem=guncelle&id='.$satir["id"].'" class="btn btn-info" >Güncelle</a>
                    <a href="index.php?islem=sil&id='.$satir["id"].'" class="btn btn-danger" >Sil</a>
                    
                    </td>
                  </tr>';
                  endwhile;
                else:
                    echo '<div class="alert alert-danger">ARAMAYA GÖRE KAYIT YOK<br>Yükleniyor</div>';
                    header("refresh:2;url=index.php"); 
            endif;
    endif;
 endif;


 



 ?>
    </tbody> 
  </table>
 </div>





<?php
}
public static function satirsayisi($a){
    $s="select * from kisisel";
    $tumveri=$a->prepare($s);
    $tumveri->execute();
    $sonuc=$tumveri->get_result();

    echo '<p class="text-success">Toplam Kayıtlı Üye Sayısı: <strong>'.$sonuc->num_rows.'</strong></p>';

 }
}
?>