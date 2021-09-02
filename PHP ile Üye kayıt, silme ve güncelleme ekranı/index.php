<?php require_once("dahili.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ÜYELER</title>
</head>
<body>
  
<?php
  
  @$islem=$_GET["islem"];
  @$id=$_GET["id"];
  
  switch($islem):
    case "sil": 
?>
  <table class="table  table-bordered table-hover" style="text-align:center">
    <thead>
      <tr class="table-light">
        <th colspan="8">
          <?php
          islemler::sil($id,$db);
          ?>
        </th>
      </tr>
    </thead>
    </table>

<?php
      break;
      case "ekle":
        islemler::eklemeform();
        break;
        case "ekleson":
          islemler::ekle($db);
          break;
          case "guncelle":
            islemler::guncelle($db);
            break;
            case "guncelleson":
              islemler::guncelleson($db);
              break;
              case "aramasonuc":
                islemler::aramasonuc($db);
                break;
                default:
?>

<div class="container">
  <h2>ÜYELER</h2><?php islemler::satirsayisi($db); ?>
  
    
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
       islemler::listele($db);
?>
    </tbody> 
  </table>
</div>
<?php
endswitch;
?>
</body>
</html>