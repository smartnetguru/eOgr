﻿<?php  
/*
eOgr - elearning project

Developer Site: http://yunus.sourceforge.net

Support:		http://www.ohloh.net/p/eogr

This project is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 3 of the License, or any later version. See the GNU
Lesser General Public License for more details.
*/
	ob_start();
    session_start (); 
    $_SESSION ['ready'] = TRUE; 
  require("conf.php");  		
  $time = getmicrotime();
  checkLoginLang(true,true,"lessonsEdit.php");	   
  $seciliTema=temaBilgisi();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="tarik bagriyanik">
<link href="theme/<?php echo $seciliTema?>/bootstrap-theme.css" rel="stylesheet">
<link href="theme/docs.min.css" rel="stylesheet">
<link href="theme/ie10-viewport-bug-workaround.css" rel="stylesheet">
<link href="theme/justified-nav.css" rel="stylesheet">
<script src="lib/bs_js/ie-emulation-modes-warning.js"></script>
<title>eOgr -<?php echo $metin[62]?></title>
<link rel="icon" href="img/favicon.ico">
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="alternate" type="application/rss+xml" title="eOgr RSS" href="rss.php" />
<meta http-equiv="cache-control" content="no-cache"/>
<meta http-equiv="pragma" content="no-cache"/>
<meta http-equiv="Expires" content="-1"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta name="keywords" content="elearning, cms, lms, learning management, education, eogrenme" />
<meta name="description" content="eOgr - Open source online education, elearning project" />
<link rel="alternate" type="application/rss+xml" title="eOgr RSS" href="rss.php" />
<link href="theme/feedback.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="lib/script.js"></script>
<script src="lib/bs_js/jquery-2.2.0.js" type="text/javascript"></script>
<script type="text/javascript" src="lib/facebox/facebox.js"></script>
<link href="lib/facebox/facebox.css" rel="stylesheet" type="text/css" />
<link href="theme/stilGenel.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
		jQuery(document).ready(function($) {
		  $('a[rel*=facebox]').facebox({
			
		  }) 
		})
	</script>
<link href="lib/tlogin/style.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="lib/jquery.cookie.js"></script>
<link rel="stylesheet" href="lib/as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
<script language="JavaScript" type="text/javascript" src="lib/fade.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
		$("#soruEkleme").hide();
		$("#soruEklemeHead").click(function(){
			$(this).next("#soruEkleme").slideToggle(200);
		});
      }) 
</script>
<script language="JavaScript" type="text/javascript">
<!--
/*
delWithCon:
onay ile silme
*/
function delWithCon(deletepage_url,field_value,messagetext) { 
  if (confirm(messagetext)==1){
    location.href = eval('\"'+deletepage_url+'&id='+field_value+'&delCon=1\"');
  }
}
//-->
</script>
</head>
<body>
<?php require("menu.php");?>
<div class="container">
  <div class="col-lg-12">
    <div class="Post-inner">
      <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[62]?> </span> </h2>
      <div class="PostContent">
        <?php  
	$currentPage = $_SERVER["PHP_SELF"];	

	if ($tur<=-1 || $tur>2) { 
	  sessionDestroy();
	  die ("<font id='hata'> ".$metin[404]."</font><br/>".$metin[402]);
	 }else
	 if ($tur=="0") {
	  @header("Location: error.php?error=10");	
	  die($metin[448]);
	 } 
?>
        <?php
$seciliSekme =(isset( $_GET["tab"]))? $_GET["tab"]:"";

function temizleCubuk($gelen){
	 $gelen = str_replace("|", "¦", temizle($gelen));
	 return $gelen;	
}

if ($seciliSekme=="") $seciliSekme=3; //varsayılan konudur

if(isset($_GET["islem"]) && in_array($_GET["islem"] ,array("S","E","G")) && in_array($seciliSekme ,array("0","1","2","3","4","5")))
 {
	 if($seciliSekme=="0") $tabloAdi="eo_1okul"; 	else
	 if($seciliSekme=="1") $tabloAdi="eo_2sinif"; 	else
	 if($seciliSekme=="2") $tabloAdi="eo_3ders"; 	else
	 if($seciliSekme=="3") $tabloAdi="eo_4konu"; 	else 	 
	 if($seciliSekme=="4") $tabloAdi="eo_5sayfa";   else	 
	 if($seciliSekme=="5") $tabloAdi="eo_livelesson";  	 
	 
	 if(isset($_GET["id"])) $seciliKayit=temizle($_GET["id"]); else $seciliKayit=-1;
	 if(isset($_POST["id"])) $seciliKayit= temizle($_POST["id"]);
	 if (!is_numeric($seciliKayit))	$seciliKayit=-1;
	 
	if($seciliSekme=="0")  
	   $islemi = "okul"; 
	elseif($seciliSekme=="1")  
	   $islemi = "sinif";
	elseif($seciliSekme=="2")  
	   $islemi = "ders";
	elseif($seciliSekme=="3")  
	   $islemi = "konu";
	elseif($seciliSekme=="4")  
	   $islemi = "sayfa";
	elseif($seciliSekme=="5")  
	   $islemi = "canliders";
	
	if($_GET["islem"]=="S") 
	   $islemi .= ", Delete";
	elseif($_GET["islem"]=="G") 
	   $islemi .= ", Update";
	elseif ($_GET["islem"]=="E") 
	   $islemi .= ", Insert";
	
 	 trackUser($currentFile,$islemi,$adi);	
	 
	 $sql="";
	 switch($_GET["islem"]){
		  case "S":   
		  		$sql="Delete From $tabloAdi where id=$seciliKayit";
	            $result = mysqli_query($yol, $sql);
				if($result) 
				   echo "<font id='tamam'>$metin[501]</font>";
				   else
				   echo "<font id='hata'><?php echo $metin[102] ?> i&#351;lemi tamamlanamad&#305;! ".mysqli_error()."</font>";
		  		break;
		  case "G": 
				 if($seciliSekme=="0") {
						$okulAdi=temizle($_POST["okulAdi"]);
						if (!empty($okulAdi))
							$sql="Update eo_1okul set okulAdi='$okulAdi' where id=$seciliKayit";
					 }else
				 if($seciliSekme=="1") {
				        $sinifAdi=temizle($_POST["sinifAdi"]);
				        $okulID=temizle($_POST["okulAdlari"]);
						if (!empty($okulID) && !empty($sinifAdi))
   							$sql="Update eo_2sinif set sinifAdi='$sinifAdi',okulID='$okulID' where id=$seciliKayit";
					 }else
				 if($seciliSekme=="2") {
				        $dersAdi=temizle($_POST["dersAdi"]);
				        $sinifID=temizle($_POST["sinifAdlari"]);
						if (!empty($sinifID) && !empty($dersAdi))
   							$sql="Update eo_3ders set dersAdi='$dersAdi',sinifID='$sinifID' where id=$seciliKayit";
					 }else
				 if($seciliSekme=="3") {
				        $konuAdi=temizleCubuk($_POST["konuAdi"]);
				        $dersID=temizleCubuk($_POST["dersAdlari"]);
						if(empty($_POST["bitisTarihi"]))
						  $bitisTarihi="";
						 else
				          $bitisTarihi=tarihYap(temizle($_POST["bitisTarihi"])); 
				        $oncekiKonuID	=temizleCubuk((isset($_POST["oncekiKonuID"]))?$_POST["oncekiKonuID"]:"");
				        $calismaSuresiDakika=temizleCubuk((isset($_POST["calismaSuresiDakika"]))?$_POST["calismaSuresiDakika"]:"");
				        $calismaHakSayisi=temizleCubuk((isset($_POST["calismaHakSayisi"]))?$_POST["calismaHakSayisi"]:"");
				        $konuyuKilitle	=temizleCubuk((isset($_POST["konuyuKilitle"]))?$_POST["konuyuKilitle"]:"");
				        $sadeceKayitlilarGorebilir=temizleCubuk((isset($_POST["sadeceKayitlilarGorebilir"]))?$_POST["sadeceKayitlilarGorebilir"]:"");
				        $sinifaDahilKullaniciGorebilir=temizleCubuk((isset($_POST["sinifaDahilKullaniciGorebilir"]))?$_POST["sinifaDahilKullaniciGorebilir"]:"");
						
						if (!empty($dersID) && !empty($konuAdi))
   							$sql="Update eo_4konu set konuAdi='$konuAdi', dersID='$dersID', bitisTarihi='$bitisTarihi', oncekiKonuID='$oncekiKonuID', calismaSuresiDakika='$calismaSuresiDakika', calismaHakSayisi='$calismaHakSayisi', konuyuKilitle='$konuyuKilitle', sadeceKayitlilarGorebilir='$sadeceKayitlilarGorebilir', sinifaDahilKullaniciGorebilir='$sinifaDahilKullaniciGorebilir'  where id=$seciliKayit";
							
					 }else
				 if($seciliSekme=="4") {
				        $anaMetin	= trim(str_replace("'", "`", $_POST["anaMetin"])); //temizle PROBLEM!
				        $anaMetin	= temizleWordHTML(trim(str_replace("|", "¦", $anaMetin))); //temizle PROBLEM!
						$anaMetin	= temizleOzel($anaMetin);
					    $datem		= date("Y-n-j H:i:s");
						$userID 	= getUserID2($adi);
				        $cevap		= temizleCubuk($_POST["cevap"]);
				        $secenek1	= temizleCubuk($_POST["secenek1"]);
				        $secenek2	= temizleCubuk($_POST["secenek2"]);
				        $secenek3	= temizleCubuk($_POST["secenek3"]);
				        $secenek4	= temizleCubuk($_POST["secenek4"]);
				        $secenek5	= temizleCubuk($_POST["secenek5"]);
				        $secenek6	= temizleCubuk($_POST["secenek6"]);
				        $slideGecisSuresi	=temizleCubuk($_POST["slideGecisSuresi"]);
				        $cevapSuresi		=temizleCubuk($_POST["cevapSuresi"]);
				        $konuID		=temizleCubuk($_POST["konuID"]);
						if (!empty($anaMetin) && !empty($konuID))
   							$sql="Update eo_5sayfa set 
									anaMetin='$anaMetin', cevap = '$cevap',
									secenek1='$secenek1', secenek2 = '$secenek2',
									secenek3='$secenek3', secenek4 = '$secenek4',
									secenek5='$secenek5', secenek6 = '$secenek6',
									konuID = '$konuID', 
									eklenmeTarihi='$datem', ekleyenID='$userID',
 								    slideGecisSuresi='$slideGecisSuresi', cevapSuresi='$cevapSuresi'
									where id=$seciliKayit";
					 }else
				 if($seciliSekme=="5") {
				        $dersID		= temizleCubuk($_POST["dersAdlari"]);
				        $userID		= temizleCubuk($_POST["kullaniciAdlari"]);
				        $sure		= temizleCubuk($_POST["dersSuresi"]);
				        $etkinlikT	= date("Y-m-d H:i",strtotime(temizleCubuk($_POST["tarihEtkinlik"])));
				        $notlar		= temizleCubuk($_POST["notlar"]);

						if (!empty($dersID) && !empty($userID) && !empty($sure) && !empty($etkinlikT))
   							$sql="Update eo_livelesson set 
									dersID='$dersID', userID = '$userID',
									length='$sure', dateWhen = '$etkinlikT',
									yontem='$notlar' 								    
									where id=$seciliKayit";
				 }

	            $result = mysqli_query($yol, $sql);
				if($result) 
				   echo "<font id='tamam'>$metin[536]</font>";
				   else
				   echo "<font id='hata'>G&uuml;ncelleme i&#351;lemi tamamlanamad&#305;! ".mysqli_error()."</font>";
		  		break;
		  case "E": 
				 if($seciliSekme=="0") {
				        $okulAdi=temizle($_POST["okulAdi"]);
						if (!empty($okulAdi))	
						$sql="Insert into eo_1okul (okulAdi) values ('$okulAdi')";
					 }else
				 if($seciliSekme=="1") {
				        $sinifAdi=temizle($_POST["sinifAdi"]);
				        $okulID=temizle($_POST["okulAdlari"]);
						if (!empty($okulID) && !empty($sinifAdi))
						   $sql="Insert into eo_2sinif (sinifAdi, okulID) values ('$sinifAdi','$okulID')";
					 }else
				 if($seciliSekme=="2") {
				        $dersAdi=temizle($_POST["dersAdi"]);
				        $sinifID=temizle($_POST["sinifAdlari"]);
						if (!empty($sinifID) && !empty($dersAdi))
						   $sql="Insert into eo_3ders (dersAdi, sinifID) values ('$dersAdi','$sinifID')";
					 }else
				 if($seciliSekme=="3") {
				        $konuAdi		=temizleCubuk($_POST["konuAdi"]);
				        $dersID			=temizleCubuk($_POST["dersAdlari"]);
						if(empty($_POST["bitisTarihi"]))
						  $bitisTarihi="";
						 else
				          $bitisTarihi=tarihYap(temizleCubuk($_POST["bitisTarihi"])); 
				        $oncekiKonuID	=temizleCubuk((isset($_POST["oncekiKonuID"]))?$_POST["oncekiKonuID"]:"");
				        $calismaSuresiDakika=temizleCubuk((isset($_POST["calismaSuresiDakika"]))?$_POST["calismaSuresiDakika"]:"");
				        $calismaHakSayisi=temizleCubuk((isset($_POST["calismaHakSayisi"]))?$_POST["calismaHakSayisi"]:"");
				        $konuyuKilitle	=temizleCubuk((isset($_POST["konuyuKilitle"]))?$_POST["konuyuKilitle"]:"");
				        $sadeceKayitlilarGorebilir=temizleCubuk((isset($_POST["sadeceKayitlilarGorebilir"]))?$_POST["sadeceKayitlilarGorebilir"]:"");
				        $sinifaDahilKullaniciGorebilir=temizleCubuk((isset($_POST["sinifaDahilKullaniciGorebilir"]))?$_POST["sinifaDahilKullaniciGorebilir"]:"");

						if (!empty($dersID) && !empty($konuAdi))
						   $sql="Insert into eo_4konu (konuAdi, dersID, bitisTarihi, oncekiKonuID, konuyuKilitle, calismaHakSayisi, calismaSuresiDakika, sadeceKayitlilarGorebilir, sinifaDahilKullaniciGorebilir) values ('$konuAdi', '$dersID', '$bitisTarihi', '$oncekiKonuID', '$konuyuKilitle', '$calismaHakSayisi', '$calismaSuresiDakika', '$sadeceKayitlilarGorebilir', '$sinifaDahilKullaniciGorebilir')";
					 }else
				 if($seciliSekme=="4") {
					    $datem	=	date("Y-n-j H:i:s");
						$userID =  getUserID2($adi);
						$toplamSayfaSay = totalGet (4);
				        $cevap		=temizleCubuk($_POST["cevap"]);
				        $secenek1	=temizleCubuk($_POST["secenek1"]);
				        $secenek2	=temizleCubuk($_POST["secenek2"]);
				        $secenek3	=temizleCubuk($_POST["secenek3"]);
				        $secenek4	=temizleCubuk($_POST["secenek4"]);
				        $secenek5	=temizleCubuk($_POST["secenek5"]);
				        $secenek6	=temizleCubuk($_POST["secenek6"]);
				        $slideGecisSuresi	=temizleCubuk($_POST["slideGecisSuresi"]);
				        $cevapSuresi		=temizleCubuk($_POST["cevapSuresi"]);
						$konuID		=temizleCubuk($_SESSION["seciliKonu"]);
						
				        $anaMetin   = trim(str_replace("'", "`", $_POST["anaMetin"])); //temizle PROBLEM!						
				        $anaMetin	= temizleWordHTML(trim(str_replace("|", "¦", $anaMetin))); //temizle PROBLEM!
						$anaMetin	= temizleOzel($anaMetin);
						if (!empty($anaMetin) && !empty($konuID))
						   $sql="Insert into eo_5sayfa 
						   (anaMetin, konuID, eklenmeTarihi, ekleyenID, sayfaSirasi, cevap, secenek1,secenek2,secenek3,secenek4,secenek5,secenek6,slideGecisSuresi,cevapSuresi)
						   	values ('$anaMetin', '".$konuID."', '$datem', '$userID', '$toplamSayfaSay','$cevap'
									,'$secenek1','$secenek2','$secenek3'
									,'$secenek4','$secenek5','$secenek6'
									,'$slideGecisSuresi','$cevapSuresi'							  
									)";
					 }else
				 if($seciliSekme=="5") {
				        $dersID		= temizleCubuk($_POST["dersAdlari"]);
				        $userID		= temizleCubuk($_POST["kullaniciAdlari"]);
				        $sure		= temizleCubuk($_POST["dersSuresi"]);
				        $etkinlikT	= date("Y-m-d H:i",strtotime(temizleCubuk($_POST["tarihEtkinlik"])));
				        $notlar		= temizleCubuk($_POST["notlar"]);
						if (!empty($dersID) && !empty($userID) && !empty($sure) && !empty($etkinlikT))
   							$sql="INSERT INTO eo_livelesson 
									(dersID, userID, length, dateWhen, yontem) 								    
									VALUES
									('$dersID', '$userID', '$sure', '$etkinlikT','$notlar')";
					 } 	 
				if(!empty($sql))	
						$result = mysqli_query($yol, $sql);
				   else
						$result = false;
				if($result) 
				   echo "<font id='tamam'>$metin[537]</font>";
				   else
				   echo "<font id='hata'>Ekleme i&#351;lemi tamamlanamad&#305;! ".mysqli_error($yol)."</font>";
		  		break;
		  default:
		       echo "<font id='hata'>İ&#351;lem t&uuml;r&uuml; belirsiz!</font>";
	 }
 }
 
 if(isset($_GET["secOgr"]) && $_GET["secOgr"]=="1")
  {
			 $ogre = (isset($_GET["ogrenciler1"]))?$_GET["ogrenciler1"]:array();
			 $seciliSinif = temizle($_GET["id"]);
			 for ($idx = 0; $idx < count($ogre) ; $idx++){
				$sqlsecim = "select * from eo_sinifogre where sinifID=$seciliSinif and userID=".temizle($ogre[$idx]);
				$resultsecim = mysqli_query($yol,$sqlsecim);
				if($resultsecim) 
				 if (mysqli_num_rows($resultsecim)>0)
				  continue;
				  else{
					$sqlsecimK = "insert into eo_sinifogre (sinifID,userID) values($seciliSinif, ".temizle($ogre[$idx]).")";
					$resultsecimK = mysqli_query($yol,$sqlsecimK); 
				  }								  
			 }
  }
 if(isset($_GET["secOgr"]) && $_GET["secOgr"]=="1")
  {
			 $ogre = (isset($_GET["ogrenciler2"]))?$_GET["ogrenciler2"]:array();
			 $seciliSinif = temizle($_GET["id"]);
			 for ($idx = 0; $idx < count($ogre) ; $idx++){
					$sqlsecimK = "delete from eo_sinifogre where sinifID=$seciliSinif and userID=".temizle($ogre[$idx]);
					$resultsecimK = mysqli_query($yol,$sqlsecimK); 
			 }
  }
?>
        <ol >
          <li class="LinkYan<?php echo ($seciliSekme=="0")?"Aktif":"";?>"><a href="lessonsEdit.php?tab=0" title="<?php echo $metin[352];?>"><img src="img/bullet.png" border="0" style="vertical-align: text-bottom;" alt="<?php echo $metin[352];?>" /> <?php echo $metin[296];?></a></li>
          <li class="LinkYan<?php echo ($seciliSekme=="1")?"Aktif":"";?>"><a href="lessonsEdit.php?tab=1" title="<?php echo $metin[353];?>"><img src="img/bullet.png" border="0" style="vertical-align: text-bottom;" alt="edit" /> <?php echo $metin[297];?></a></li>
          <li class="LinkYan<?php echo ($seciliSekme=="2")?"Aktif":"";?>"><a href="lessonsEdit.php?tab=2" title="<?php echo $metin[354];?>"><img src="img/bullet.png" border="0" style="vertical-align: text-bottom;" alt="edit" /> <?php echo $metin[298];?></a></li>
          <li class="LinkYan<?php echo ($seciliSekme=="3" or $seciliSekme=="4")?"Aktif":"";?>"><a href="lessonsEdit.php?tab=3"  title="<?php echo $metin[355];?>"><img src="img/bullet.png" border="0" style="vertical-align: text-bottom;" alt="edit"/> <?php echo $metin[299];?></a></li>
          <li class="LinkYan<?php echo ($seciliSekme=="5" or $seciliSekme=="5")?"Aktif":"";?>"><a href="lessonsEdit.php?tab=5"  title="<?php echo $metin[52];?>"><img src="img/bullet.png" border="0" style="vertical-align: text-bottom;" alt="edit"/> <?php echo $metin[52];?></a></li>
        </ol>
        <div style="clear:both"></div>
        <?php
 if(!isset($_POST["blokSayi"]))
	 {
		 if(!isset($_SESSION["blokSayi"]))
   			$blokBuyuklugu= ayarGetir("sayfaBlokSayisi");
		 else
		   $blokBuyuklugu=temizle($_SESSION["blokSayi"]); 
	 }
   else 
   {
   $blokBuyuklugu=temizle($_POST["blokSayi"]);
   $_SESSION["blokSayi"]=$blokBuyuklugu;
   }


if(!isset($_GET["upd"])) $_GET["upd"]="";
if(!isset($_GET["sirAlan"])) $_GET["sirAlan"]="";
if(!isset($_GET["siraYap"])) $_GET["siraYap"]="";
if(!isset($_SESSION["siraYonu3"])) $_SESSION["siraYonu3"]="";
if(!isset($_SESSION["siraYonu4"])) $_SESSION["siraYonu4"]="";
if(!isset($_SESSION["siraYonu5"])) $_SESSION["siraYonu5"]="";
if(!isset($_SESSION["siraYonu6"])) $_SESSION["siraYonu6"]="";
   
if($seciliSekme=="0") {
?>
        <div id="TabbedPanelsContent"> 
          <!-- *********************************************************OKUL ba&#351;lad&#305; **********************************************************************-->
          <?php
   if($_GET["upd"]!=1 || $seciliSekme!="0") {

	   $sirAlan=temizle($_GET["sirAlan"]);
	   if($sirAlan=="") $sirAlan="id";
	   
	   $siraYap=temizle($_GET["siraYap"]);
	   
		$siraYonu="asc";
		if (empty($_SESSION["siraYonu3"])) {  
				$_SESSION["siraYonu3"]=$siraYonu;
			} else {
				if ($_GET['siraYap']=="OK"){
					$siraYonu=($_SESSION["siraYonu4"]=="desc")?"asc":"desc";
					$_SESSION["siraYonu4"]=$siraYonu;
					}
					else
					$siraYonu=(isset($_SESSION["siraYonu4"]))?$_SESSION["siraYonu4"]:"";
			}
			
		if ($sirAlan != "" && in_array($sirAlan, array("id","okulAdi")))
			   $filtr=" order by $sirAlan $siraYonu";
		   else {
			  $sirAlan="id" ;
			   $filtr=" order by id";
		   }
		   
	$sayfaNo = 0;
	if (isset($_GET['sayfaNo'])) {
	  $sayfaNo = $_GET['sayfaNo'];
	}
	$startRow1 = $sayfaNo * $blokBuyuklugu;

?>
          <table border="0" cellpadding="3" cellspacing="0" align="center">
            <tr>
              <th width="60" nowrap="nowrap"><?php if ($sirAlan=="id") {?>
                <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="id")?"desc":"asc"?>.png" alt="S&#305;ralama Y&ouml;n&uuml;" border="0" style="vertical-align: middle;"/>
                <?php } ?>
                <a href="lessonsEdit.php?sirAlan=id&amp;tab=0&amp;siraYap=OK"><?php echo $metin[26]?></a></th>
              <th width="295" nowrap="nowrap"><?php if ($sirAlan=="okulAdi") {?>
                <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="okulAdi")?"desc":"asc"?>.png" alt="S&#305;ralama Y&ouml;n&uuml;" border="0" style="vertical-align: middle;"/>
                <?php } ?>
                <a href="lessonsEdit.php?sirAlan=okulAdi&amp;tab=0&amp;siraYap=OK"><?php echo $metin[359]?></a></th>
            </tr>
            <?php 
			$limitleme = sprintf("LIMIT %d, %d", $startRow1, $blokBuyuklugu);				 
		    $sql = "SELECT * FROM eo_1okul $filtr $limitleme";

			$result = mysqli_query($yol, $sql);			
			if($result){
			$kayitSayisi = mysqli_num_rows(mysqli_query($yol,"select * from eo_1okul"));			
			$sayfaSayisi = ceil($kayitSayisi/$blokBuyuklugu)-1;
			}
			
            $i = 0; $satirRenk=0;
            while ($i < @mysqli_num_rows($result))
            {
 
				$satirRenk++;
				if ($satirRenk & 1) { 
					$row_color = "#CCC"; 
				} else { 
					$row_color = "#ddd"; 
				}
  ?>
            <tr>
              <td align="right" <?php echo "style=\"background-color: $row_color;\""?>><?php echo mysqli_result($result, $i, "id")?></td>
              <td <?php echo "style=\"background-color: $row_color;\""?>><?php echo mysqli_result($result, $i, "okulAdi")?></td>
              <td width="60" align="center" valign="middle"><a href="<?php echo $currentPage;?>?tab=0&amp;id=<?php echo mysqli_result($result, $i, "id");?>&amp;upd=1" title="<?php echo $metin[103]?>"><img src="img/edit.png" alt="<?php echo $metin[103]?>" width="16" height="16" border="0" style="vertical-align: middle;" /></a>&nbsp;|&nbsp;<a href="#" onclick="javascript:delWithCon('<?php echo $currentPage;?>?tab=0&amp;islem=S',<?php echo mysqli_result($result, $i, "id")?>,'<?php echo $metin[420] ?>');" title="<?php echo $metin[102] ?>"><img src="img/cross.png" alt="<?php echo $metin[102] ?>" width="16" height="16" border="0" style="vertical-align: middle;" /></a></td>
            </tr>
            <?php
  				 $i++;
			}
  ?>
          </table>
          <?php
	if($kayitSayisi>$blokBuyuklugu){
?>
          <table width="100" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
            <tr>
              <td align="center"><a href="<?php printf("lessonsEdit.php?sayfaNo=%d&amp;tab=0&amp;sirAlan=$sirAlan", 0); ?>"><img src="img/page-first.gif" border="0"  alt="first"/></a></td>
              <td align="center"><a href="<?php printf("lessonsEdit.php?sayfaNo=%d&amp;tab=0&amp;sirAlan=$sirAlan", max(0, $sayfaNo - 1)); ?>"><img src="img/page-prev.gif" border="0" alt="prev" /></a></td>
              <td align="center"><a href="<?php printf("lessonsEdit.php?sayfaNo=%d&amp;tab=0&amp;sirAlan=$sirAlan", min($sayfaSayisi, $sayfaNo + 1)); ?>"> <img src="img/page-next.gif" border="0" alt="next" /></a></td>
              <td align="center"><a href="<?php printf("lessonsEdit.php?sayfaNo=%d&amp;tab=0&amp;sirAlan=$sirAlan", $sayfaSayisi); ?>"><img src="img/page-last.gif" border="0"  alt="last"/></a></td>
            </tr>
            <tr>
              <td colspan="4" align="center"><?php echo min($startRow1 + $blokBuyuklugu, $kayitSayisi) ?> / <?php echo $kayitSayisi ?></td>
            </tr>
          </table>
          <form action="lessonsEdit.php?tab=0" method="post" name="sayfalamaAdeti" id="sayfalamaAdeti">
            <?php echo $metin[110];?> : &nbsp;
            <select name="blokSayi">
              <option value="5" <?php echo ($blokBuyuklugu=="5")?"selected=\"selected\"":""?>>5</option>
              <option value="10" <?php echo ($blokBuyuklugu=="10")?"selected=\"selected\"":""?>>10</option>
              <option value="15" <?php echo ($blokBuyuklugu=="15")?"selected=\"selected\"":""?>>15</option>
              <option value="20" <?php echo ($blokBuyuklugu=="20")?"selected=\"selected\"":""?>>20</option>
            </select>
            &nbsp;
            <input name="Tamam" type="submit" value="<?php echo $metin[30]?>" />
          </form>
          <?php
   }
?>
          <br />
          <form action="lessonsEdit.php?tab=0&amp;islem=E" method="post" name="okulEkle" id="okulEkle">
            <table width="530" border="0" cellspacing="0" cellpadding="3" align="center">
              <tr>
                <th colspan="2"><?php echo $metin[365]?></th>
              </tr>
              <tr>
                <td width="87" align="right"><label for="okulAdi"><?php echo $metin[359]?> : </label></td>
                <td width="293"><span id="okulAdi2">
                  <input name="okulAdi" type="text" id="okulAdi" size="32" maxlength="50" />
                  <span class="textfieldRequiredMsg">&nbsp;</span><span class="textfieldMaxCharsMsg"><br/>
                  <tt><?php echo $metin[357]?></tt></span></span></td>
              </tr>
              <tr>
                <td colspan="2" align="center" class="tabloAlt"><label>
                    <input type="submit" name="gonder9" id="gonder9" value="<?php echo $metin[360]?>" />
                  </label></td>
              </tr>
            </table>
          </form>
          <?php		}else		//update mode
      {

		if(isset($_GET["id"])) $seciliKayit=temizle($_GET["id"]); else $seciliKayit=-1;
		if (!is_numeric($seciliKayit))	$seciliKayit=-1;
	 
		  $sql2= "select id,okulAdi from eo_1okul where id=$seciliKayit";
		  $result2 = mysqli_query($yol, $sql2);
?>
          <form action="lessonsEdit.php?tab=0&amp;islem=G" method="post" name="okulGuncelle" id="okulGuncelle">
            <table width="530" border="0" cellspacing="0" cellpadding="3" align="center">
              <tr>
                <th colspan="2"><?php echo $metin[370]?> (<?php echo $seciliKayit?> <?php echo $metin[356]?>)</th>
              </tr>
              <tr>
                <td width="87" align="right"><label for="okulAdi"><?php echo $metin[359]?> : </label></td>
                <td width="293"><span id="okulAdii">
                  <input name="okulAdi" type="text" id="okulAdi" size="32" maxlength="50" value="<?php echo mysqli_result($result2, 0, "okulAdi")?>" />
                  <span class="textfieldRequiredMsg">&nbsp;</span><span class="textfieldMaxCharsMsg"><br/>
                  <tt><?php echo $metin[357]?></tt></span></span></td>
              </tr>
              <tr>
                <td colspan="2" align="center" class="tabloAlt"><label>
                    <input name="id" type="hidden" value="<?php echo mysqli_result($result2, 0, "id")?>" />
                    <input type="submit" name="gonder2" id="gonder2" value="<?php echo $metin[361]?>" />
                    &nbsp;
                    <input type="button" name="gonderme" id="gonderme"  onclick="location.href = &quot;lessonsEdit.php?tab=0&quot;;" value="<?php echo $metin[28]?>" />
                  </label></td>
              </tr>
            </table>
          </form>
          <?php		  
	  }
?>
        </div>
        <!-- ************************************OKUL bitti SINIF ba&#351;lad&#305; ************************************-->
        <?php
		} else
	 if($seciliSekme=="1") 	{	
?>
        <div id="TabbedPanelsContent">
          <?php
   if($_GET["upd"]!=1 || $seciliSekme!="1") {

	   $sirAlan=temizle($_GET["sirAlan"]);
	   if($sirAlan=="") $sirAlan="okulAdi";
	   
	   $siraYap=temizle($_GET["siraYap"]);
	   
		$siraYonu="asc";
		if (empty($_SESSION["siraYonu5"])) {  
				$_SESSION["siraYonu5"]=$siraYonu;
			} else {
				if ($_GET['siraYap']=="OK"){
					$siraYonu=($_SESSION["siraYonu6"]=="desc")?"asc":"desc";
					$_SESSION["siraYonu6"]=$siraYonu;
					}
					else
					$siraYonu=(isset($_SESSION["siraYonu6"]))?$_SESSION["siraYonu6"]:"";
			}
			
		if ($sirAlan != "" && in_array($sirAlan, array("id","sinifAdi","okulAdi")))
			   $filtr=" order by $sirAlan $siraYonu";
		   else {
			   $sirAlan="okulAdi";
			   $filtr=" order by okulAdi";
		   }
		   
	$sayfaNo = 0;
	if (isset($_GET['sayfaNo'])) {
	  $sayfaNo = $_GET['sayfaNo'];
	}
	$startRow1 = $sayfaNo * $blokBuyuklugu;

?>
          <table border="0" cellpadding="3" cellspacing="0" align="center">
            <tr>
              <th width="60" nowrap="nowrap"><?php if ($sirAlan=="id") {?>
                <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="id")?"desc":"asc"?>.png" alt="S&#305;ralama Y&ouml;n&uuml;" border="0" style="vertical-align: middle;"/>
                <?php } ?>
                <a href="lessonsEdit.php?sirAlan=id&amp;tab=1&amp;siraYap=OK"><?php echo $metin[26]?></a></th>
              <th width="148" nowrap="nowrap"><?php if ($sirAlan=="sinifAdi") {?>
                <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="sinifAdi")?"desc":"asc"?>.png" alt="S&#305;ralama Y&ouml;n&uuml;" border="0" style="vertical-align: middle;"/>
                <?php } ?>
                <a href="lessonsEdit.php?sirAlan=sinifAdi&amp;tab=1&amp;siraYap=OK"><?php echo $metin[362] ?></a></th>
              <th width="304" nowrap="nowrap"><?php if ($sirAlan=="okulAdi") {?>
                <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="okulAdi")?"desc":"asc"?>.png" alt="S&#305;ralama Y&ouml;n&uuml;" border="0" style="vertical-align: middle;"/>
                <?php } ?>
                <a href="lessonsEdit.php?sirAlan=okulAdi&amp;tab=1&amp;siraYap=OK"><?php echo $metin[359]?></a></th>
            </tr>
            <?php
			$limitleme = sprintf("LIMIT %d, %d", $startRow1, $blokBuyuklugu);				 
            $sql = "SELECT eo_2sinif.id, eo_2sinif.sinifAdi, eo_1okul.okulAdi as okulAdi FROM eo_2sinif left outer join eo_1okul on eo_2sinif.okulID=eo_1okul.id  $filtr  $limitleme";
			
			$result = mysqli_query($yol, $sql);			
			if($result){
			$kayitSayisi = mysqli_num_rows(mysqli_query($yol,"select * from eo_2sinif"));			
			$sayfaSayisi = ceil($kayitSayisi/$blokBuyuklugu)-1;
			}
			
            $i = 0; $satirRenk=0;
            while ($i < @mysqli_num_rows($result))
            {
 
    	$satirRenk++;
        if ($satirRenk & 1) { 
            $row_color = "#CCC"; 
        } else { 
            $row_color = "#ddd"; 
        }
  
  ?>
            <tr>
              <td align="right"  <?php echo "style=\"background-color: $row_color;\""?>><?php echo mysqli_result($result, $i, "id")?></td>
              <td  <?php echo "style=\"background-color: $row_color;\""?>><?php echo mysqli_result($result, $i, "sinifAdi")?></td>
              <td <?php echo "style=\"background-color: $row_color;\""?>><?php echo (mysqli_result($result, $i, "okulAdi")==""?"<font class=bosVeri title='Kay&#305;t yok veya bir hata meydana geldi!'>###</font>":mysqli_result($result, $i, "okulAdi"))?></td>
              <td width="60" align="center" valign="middle"><a href="<?php echo $currentPage;?>?tab=1&amp;id=<?php echo mysqli_result($result, $i, "id");?>&amp;upd=1" title="<?php echo $metin[103]?>"><img src="img/edit.png" alt="<?php echo $metin[103]?>" width="16" height="16" border="0" style="vertical-align: middle;" /></a>&nbsp;|&nbsp;<a href="#" onclick="javascript:delWithCon('<?php echo $currentPage;?>?tab=1&amp;islem=S',<?php echo mysqli_result($result, $i, "id")?>,'<?php echo $metin[420] ?>');" title="<?php echo $metin[102] ?>"><img src="img/cross.png" alt="<?php echo $metin[102] ?>" width="16" height="16" border="0" style="vertical-align: middle;" /></a></td>
            </tr>
            <?php
  				 $i++;
			}
  ?>
          </table>
          <?php
	if($kayitSayisi>$blokBuyuklugu){
?>
          <table width="100" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
            <tr>
              <td align="center"><a href="<?php printf("lessonsEdit.php?sayfaNo=%d&amp;tab=1&amp;sirAlan=$sirAlan", 0); ?>"><img src="img/page-first.gif" border="0"  alt="first"/></a></td>
              <td align="center"><a href="<?php printf("lessonsEdit.php?sayfaNo=%d&amp;tab=1&amp;sirAlan=$sirAlan", max(0, $sayfaNo - 1)); ?>"><img src="img/page-prev.gif" border="0"  alt="prev"/></a></td>
              <td align="center"><a href="<?php printf("lessonsEdit.php?sayfaNo=%d&amp;tab=1&amp;sirAlan=$sirAlan", min($sayfaSayisi, $sayfaNo + 1)); ?>"> <img src="img/page-next.gif" border="0" alt="next" /></a></td>
              <td align="center"><a href="<?php printf("lessonsEdit.php?sayfaNo=%d&amp;tab=1&amp;sirAlan=$sirAlan", $sayfaSayisi); ?>"><img src="img/page-last.gif" border="0"  alt="last"/></a></td>
            </tr>
            <tr>
              <td colspan="4" align="center"><?php echo min($startRow1 + $blokBuyuklugu, $kayitSayisi) ?> / <?php echo $kayitSayisi ?></td>
            </tr>
          </table>
          <form action="lessonsEdit.php?tab=1" method="post" name="sayfalamaAdeti" id="sayfalamaAdeti">
            <?php echo $metin[110];?> : &nbsp;
            <select name="blokSayi">
              <option value="5" <?php echo ($blokBuyuklugu=="5")?"selected=\"selected\"":""?>>5</option>
              <option value="10" <?php echo ($blokBuyuklugu=="10")?"selected=\"selected\"":""?>>10</option>
              <option value="15" <?php echo ($blokBuyuklugu=="15")?"selected=\"selected\"":""?>>15</option>
              <option value="20" <?php echo ($blokBuyuklugu=="20")?"selected=\"selected\"":""?>>20</option>
            </select>
            &nbsp;
            <input name="Tamam" type="submit" value="<?php echo $metin[30]?>" />
          </form>
          <?php
   }
?>
          <br />
          <form action="lessonsEdit.php?tab=1&amp;islem=E" method="post" name="sinifEkle" id="sinifEkle">
            <table width="530" border="0" cellspacing="0" cellpadding="3" align="center">
              <tr>
                <th colspan="2"><?php echo $metin[366]?></th>
              </tr>
              <tr>
                <td width="87" align="right"><label for="sinifAdi"><?php echo $metin[362] ?> : </label></td>
                <td width="293"><span id="sinifAdii">
                  <input name="sinifAdi" type="text" id="sinifAdi" size="32" maxlength="50" />
                  <span class="textfieldRequiredMsg">&nbsp;</span><span class="textfieldMaxCharsMsg"><br/>
                  <tt><?php echo $metin[357]?></tt></span></span></td>
              </tr>
              <tr>
                <td align="right"><label for="okulAdlari"><?php echo $metin[359]?> : </label></td>
                <td><div>
                    <select name="okulAdlari" id="okulAdlari">
                      <option value=""><?php echo $metin[106] ?></option>
                      <?php
	   $sqlOkul = "select id, okulAdi from eo_1okul order by okulAdi" ;
	   $resultOkul = mysqli_query($yol,$sqlOkul);
            $i = 0;
            while ($i < @mysqli_num_rows($resultOkul))
            {
	?>
                      <option value="<?php echo mysqli_result($resultOkul, $i, "id")?>"> <?php echo mysqli_result($resultOkul, $i, "okulAdi")?> </option>
                      <?php			
	 			$i++;
			}
     ?>
                    </select>
                  </div></td>
              </tr>
              <tr>
                <td colspan="2" align="center" class="tabloAlt"><label>
                    <input type="submit" name="gonder3" id="gonder3" value="<?php echo $metin[360]?>" />
                  </label></td>
              </tr>
            </table>
          </form>
          <?php		}else		//update mode
    {

		if(isset($_GET["id"])) $seciliKayit=temizle($_GET["id"]); else $seciliKayit=-1;
	 
		  $sql2= "select id,sinifAdi, okulID from eo_2sinif where id=$seciliKayit";
		  $result2 = mysqli_query($yol, $sql2);
?>
          <form action="lessonsEdit.php?tab=1&amp;islem=G" method="post" name="sinifGuncelle" id="sinifGuncelle">
            <table width="530" border="0" cellspacing="0" cellpadding="3" align="center">
              <tr>
                <th colspan="2"><?php echo $metin[371]?> (<?php echo $seciliKayit?> <?php echo $metin[356]?>)</th>
              </tr>
              <tr>
                <td width="87" align="right"><label for="sinifAdi"><?php echo $metin[362] ?> : </label></td>
                <td width="293"><span id="sinifAdi2">
                  <input name="sinifAdi" type="text" id="sinifAdi" size="32" maxlength="50" value="<?php echo mysqli_result($result2, 0, "sinifAdi")?>" />
                  <span class="textfieldRequiredMsg">&nbsp;</span><span class="textfieldMaxCharsMsg"><br/>
                  <tt><?php echo $metin[357]?></tt></span></span></td>
              </tr>
              <tr>
                <td align="right"><label for="okulAdlari"><?php echo $metin[359]?> : </label></td>
                <td><div>
                    <select name="okulAdlari" id="okulAdlari">
                      <option value=""><?php echo $metin[106] ?></option>
                      <?php
	   $sqlOkul = "select id, okulAdi from eo_1okul order by okulAdi" ;
	   $resultOkul = mysqli_query($yol,$sqlOkul);
            $i = 0;
            while ($i < @mysqli_num_rows($resultOkul))
            {
	?>
                      <option value="<?php echo mysqli_result($resultOkul, $i, "id")?>"
      <?php if (mysqli_result($resultOkul, $i, "id")==mysqli_result($result2, 0, "okulID")) echo "selected=\"selected\"";?>
      > <?php echo mysqli_result($resultOkul, $i, "okulAdi")?> </option>
                      <?php			
	 			$i++;
			}
     ?>
                    </select>
                  </div></td>
              </tr>
              <tr>
                <td colspan="2" align="center" class="tabloAlt"><label>
                    <input name="id" type="hidden" value="<?php echo mysqli_result($result2, 0, "id")?>" />
                    <input type="submit" name="gonder4" id="gonder4" value="<?php echo $metin[361]?>" />
                    &nbsp;
                    <input type="button" name="gonderme" id="gonderme"  onclick="location.href = &quot;lessonsEdit.php?tab=1&quot;;" value="<?php echo $metin[28]?>" />
                  </label></td>
              </tr>
            </table>
          </form>
          <br />
          <div >
            <form action="lessonsEdit.php" name="ogrenciSec" method="get">
              <input type="hidden" name="tab" value="1" />
              <input type="hidden" name="id" value="<?php echo $seciliKayit?>" />
              <input type="hidden" name="upd" value="1" />
              <input type="hidden" name="secOgr" value="1" />
              <table align="center" cellpadding="3" cellspacing="0">
                <tr>
                  <th colspan="3"><?php echo $metin[375]?> :</th>
                </tr>
                <tr>
                  <td width="200" align="center" style="background-color:#FFC"><strong><?php echo $metin[376]?></strong></td>
                  <td width="30" style="background-color:#FFC">&nbsp;</td>
                  <td width="200" align="center" style="background-color:#FFC"><strong><?php echo $metin[377]?></strong></td>
                </tr>
                <tr>
                  <td align="center"><select name="ogrenciler1[]" multiple="multiple" size="15" style="width:150px;">
                      <?php
							   $sqlOgr1 = "SELECT distinct eo_users.id, eo_users.userName
											FROM eo_users
											LEFT OUTER JOIN eo_sinifogre ON eo_sinifogre.userID = eo_users.id
											WHERE eo_users.userType = 0
											AND eo_users.id NOT
											IN (											
											SELECT userID
											FROM eo_sinifogre
											WHERE sinifID = $seciliKayit 
											)
											ORDER BY eo_users.userName
											" ;
							   $resultOgr1 = mysqli_query($yol,$sqlOgr1);
									$i = 0;
									
									if(@mysqli_num_rows($resultOgr1)==0) echo "<option value=''>-</option>";
									
									while ($i < @mysqli_num_rows($resultOgr1))
									{
													
                            ?>
                      <option value="<?php echo mysqli_result($resultOgr1, $i, "id")?>"> <?php echo mysqli_result($resultOgr1, $i, "userName")?> </option>
                      <?php
									$i++;
									}
							?>
                    </select></td>
                  <td align="center" valign="middle" style="background-color:#FFC"><input type="submit" name="TamamOgr" value="<?php echo $metin[30]?>" /></td>
                  <td align="center" ><select name="ogrenciler2[]" multiple="multiple" size="15" style="width:150px;background-color:#FCF;">
                      <?php
							   $sqlOgr2 = "select eo_users.id, eo_users.userName 
										   from eo_users 
										   inner join eo_sinifogre
										   on eo_users.id = eo_sinifogre.userID
										   where eo_sinifogre.sinifID= ".$seciliKayit." 
										   order by eo_users.userName" ;
							   $resultOgr2 = mysqli_query($yol,$sqlOgr2);
									$i = 0;
									
									if(@mysqli_num_rows($resultOgr2)==0) echo "<option value=''>-</option>";
									
									while ($i < @mysqli_num_rows($resultOgr2))
									{
													
                            ?>
                      <option value="<?php echo mysqli_result($resultOgr2, $i, "id")?>"> <?php echo mysqli_result($resultOgr2, $i, "userName")?> </option>
                      <?php
									$i++;
									}
							?>
                    </select></td>
                </tr>
              </table>
            </form>
            <?php echo $metin[378]?> </div>
          <?php		  
	  }
?>
        </div>
        <!-- ***********************************SINIF bitti DERS ba&#351;lad&#305;*****************************************-->
        <?php
		} else
	 if($seciliSekme=="2") 	{	
?>
        <div id="TabbedPanelsContent">
          <?php
   if($_GET["upd"]!=1 || $seciliSekme!="2") {

	   $sirAlan=temizle($_GET["sirAlan"]);
	   if($sirAlan=="") $sirAlan="sinifAdi";
	   
	   $siraYap=temizle($_GET["siraYap"]);

	   $filtreleme2=temizle((isset($_POST["filtreleme2"]))?$_POST["filtreleme2"]:"");
	   if(isset($_POST["filtreleme2"]) and empty($_POST["filtreleme2"]))
	     $filtreleme2 = "_";
		 
	   if($filtreleme2!="") 
	     $_SESSION["filtreleme2"]=$filtreleme2;
		 else
		 $filtreleme2=temizle((isset($_SESSION["filtreleme2"]))?$_SESSION["filtreleme2"]:"");
		 
		if($filtreleme2!="") 
		  $araFilter = " dersAdi like '%$filtreleme2%' ";
		  else
		  $araFilter = " 1=1 ";
	   
		$siraYonu="asc";
		if (empty($_SESSION["siraYonu5"])) {  
				$_SESSION["siraYonu5"]=$siraYonu;
			} else {
				if ($_GET['siraYap']=="OK"){
					$siraYonu=($_SESSION["siraYonu6"]=="desc")?"asc":"desc";
					$_SESSION["siraYonu6"]=$siraYonu;
					}
					else
					$siraYonu=(isset($_SESSION["siraYonu6"]))?$_SESSION["siraYonu6"]:"";
			}
			
		if ($sirAlan != "" && in_array($sirAlan, array("id","dersAdi","sinifAdi")))
			   $filtr=" $araFilter order by $sirAlan $siraYonu";
		   else {
			   $sirAlan="sinifAdi";
			   $filtr=" $araFilter order by sinifAdi";
		   }
		   
	$sayfaNo = 0;
	if (isset($_GET['sayfaNo'])) {
	  $sayfaNo = $_GET['sayfaNo'];
	}
	$startRow1 = $sayfaNo * $blokBuyuklugu;

?>
          <table border="0" cellpadding="3" cellspacing="0" align="center">
            <tr>
              <th width="60" nowrap="nowrap"><?php if ($sirAlan=="id") {?>
                <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="id")?"desc":"asc"?>.png" alt="S&#305;ralama Y&ouml;n&uuml;" border="0" style="vertical-align: middle;"/>
                <?php } ?>
                <a href="lessonsEdit.php?sirAlan=id&amp;tab=2&amp;siraYap=OK"><?php echo $metin[26]?></a></th>
              <th width="172" nowrap="nowrap"><?php if ($sirAlan=="dersAdi") {?>
                <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="dersAdi")?"desc":"asc"?>.png" alt="S&#305;ralama Y&ouml;n&uuml;" border="0" style="vertical-align: middle;"/>
                <?php } ?>
                <a href="lessonsEdit.php?sirAlan=dersAdi&amp;tab=2&amp;siraYap=OK"><?php echo $metin[363] ?></a></th>
              <th width="308" nowrap="nowrap"><?php if ($sirAlan=="sinifAdi") {?>
                <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="sinifAdi")?"desc":"asc"?>.png" alt="S&#305;ralama Y&ouml;n&uuml;" border="0" style="vertical-align: middle;"/>
                <?php } ?>
                <a href="lessonsEdit.php?sirAlan=sinifAdi&amp;tab=2&amp;siraYap=OK"><?php echo $metin[362] ?> (<?php echo $metin[296] ?>)</a></th>
            </tr>
            <?php
			$limitleme = sprintf("LIMIT %d, %d", $startRow1, $blokBuyuklugu);				 
     		$sql = "SELECT eo_3ders.id, eo_3ders.dersAdi, eo_2sinif.sinifAdi as sinifAdi, eo_1okul.okulAdi as okulAdi FROM eo_3ders left outer join eo_2sinif on eo_3ders.sinifID=eo_2sinif.id left outer join eo_1okul on eo_1okul.id=eo_2sinif.okulID where $filtr $limitleme";
			
			$result = mysqli_query($yol, $sql);		
			if($result){
			$kayitSayisi = mysqli_num_rows(mysqli_query($yol,"select * from eo_3ders where $araFilter"));			
			$sayfaSayisi = ceil($kayitSayisi/$blokBuyuklugu)-1;
			}else{
				$kayitSayisi = 0;$sayfaSayisi = 0;
			}
			
	if (@mysqli_num_rows($result)==0)
	 {
		 echo "<tr><td colspan='3'><font id='hata'>Kay&#305;t yok veya arama sonu&ccedil;suz kald&#305;!</font></td></tr>";
	 }
	 else {
            $i = 0; $satirRenk=0;
            while ($i < @mysqli_num_rows($result))
            {
 
    	$satirRenk++;
        if ($satirRenk & 1) { 
            $row_color = "#CCC"; 
        } else { 
            $row_color = "#ddd"; 
        }
  
  ?>
            <tr>
              <td align="right"  <?php echo "style=\"background-color: $row_color;\""?>><?php echo mysqli_result($result, $i, "id")?></td>
              <td nowrap="nowrap" <?php echo "style=\"background-color: $row_color;\""?>><?php echo mysqli_result($result, $i, "dersAdi")?></td>
              <td <?php echo "style=\"background-color: $row_color;\""?>><?php echo (mysqli_result($result, $i, "sinifAdi")==""?"<font class=bosVeri title='Kay&#305;t yok veya bir hata meydana geldi!'>###</font>":mysqli_result($result, $i, "sinifAdi"))?> ( <?php echo (mysqli_result($result, $i, "okulAdi")==""?"<font class=bosVeri title='Kay&#305;t yok veya bir hata meydana geldi!'>###</font>":mysqli_result($result, $i, "okulAdi"))?> )</td>
              <td width="60" align="center" valign="middle"><a href="<?php echo $currentPage;?>?tab=2&amp;id=<?php echo mysqli_result($result, $i, "id");?>&amp;upd=1" title="<?php echo $metin[103]?>"><img src="img/edit.png" alt="<?php echo $metin[103]?>" width="16" height="16" border="0" style="vertical-align: middle;" /></a>&nbsp;|&nbsp;<a href="#" onclick="javascript:delWithCon('<?php echo $currentPage;?>?tab=2&amp;islem=S',<?php echo mysqli_result($result, $i, "id")?>,'<?php echo $metin[420] ?>');" title="<?php echo $metin[102] ?>"><img src="img/cross.png" alt="<?php echo $metin[102] ?>" width="16" height="16" border="0" style="vertical-align: middle;" /></a></td>
            </tr>
            <?php
  				 $i++;
			}
	 }
  ?>
          </table>
          <?php
	if($kayitSayisi>$blokBuyuklugu){
?>
          <table  width="100" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
            <tr>
              <td align="center"><a href="<?php printf("lessonsEdit.php?sayfaNo=%d&amp;tab=2&amp;sirAlan=$sirAlan", 0); ?>"><img src="img/page-first.gif" border="0" alt="first" /></a></td>
              <td align="center"><a href="<?php printf("lessonsEdit.php?sayfaNo=%d&amp;tab=2&amp;sirAlan=$sirAlan", max(0, $sayfaNo - 1)); ?>"><img src="img/page-prev.gif" border="0" alt="prev" /></a></td>
              <td align="center"><a href="<?php printf("lessonsEdit.php?sayfaNo=%d&amp;tab=2&amp;sirAlan=$sirAlan", min($sayfaSayisi, $sayfaNo + 1)); ?>"> <img src="img/page-next.gif" border="0"  alt="next"/></a></td>
              <td align="center"><a href="<?php printf("lessonsEdit.php?sayfaNo=%d&amp;tab=2&amp;sirAlan=$sirAlan", $sayfaSayisi); ?>"><img src="img/page-last.gif" border="0"  alt="last"/></a></td>
            </tr>
            <tr>
              <td colspan="4" align="center"><?php echo min($startRow1 + $blokBuyuklugu, $kayitSayisi) ?> / <?php echo $kayitSayisi ?></td>
            </tr>
          </table>
          <form action="lessonsEdit.php?tab=2" method="post" name="sayfalamaAdeti" id="sayfalamaAdeti">
            <?php echo $metin[110];?> : &nbsp;
            <select name="blokSayi">
              <option value="5" <?php echo ($blokBuyuklugu=="5")?"selected=\"selected\"":""?>>5</option>
              <option value="10" <?php echo ($blokBuyuklugu=="10")?"selected=\"selected\"":""?>>10</option>
              <option value="15" <?php echo ($blokBuyuklugu=="15")?"selected=\"selected\"":""?>>15</option>
              <option value="20" <?php echo ($blokBuyuklugu=="20")?"selected=\"selected\"":""?>>20</option>
            </select>
            &nbsp;
            <input name="Tamam" type="submit" value="<?php echo $metin[30]?>" />
          </form>
          <?php
   }
?>
          <br />
          <form action="lessonsEdit.php?tab=2" method="post" name="araFiltrele2" id="araFiltrele2">
            <?php echo $metin[29] ?> :
            <input type="text" maxlength="50" size="32" name="filtreleme2" value="<?php echo ($filtreleme2!="_")?$filtreleme2:""?>" title="<?php echo $metin[358] ?>" />
            <input name="ara" type="image" id="ara" src="img/view.png" alt="Ara"  style="vertical-align: middle;"/>
          </form>
          <br />
          <form action="lessonsEdit.php?tab=2&amp;islem=E" method="post" name="dersEkle" id="dersEkle">
            <table width="530" border="0" cellspacing="0" cellpadding="3" align="center">
              <tr>
                <th colspan="2"><?php echo $metin[367]?></th>
              </tr>
              <tr>
                <td width="87" align="right"><label for="dersAdi"><?php echo $metin[363] ?> : </label></td>
                <td width="293"><span id="dersAdii">
                  <input name="dersAdi" type="text" id="dersAdi" size="32" maxlength="50" />
                  <span class="textfieldRequiredMsg">&nbsp;</span><span class="textfieldMaxCharsMsg"><br/>
                  <tt><?php echo $metin[357]?></tt></span></span></td>
              </tr>
              <tr>
                <td align="right"><label for="sinifAdlari"><?php echo $metin[362] ?> : </label></td>
                <td><div>
                    <select name="sinifAdlari" id="sinifAdlari">
                      <option value=""><?php echo $metin[106] ?></option>
                      <?php
	   $sqlSinif1 = "select eo_2sinif.id as kimlik, sinifAdi, eo_1okul.okulAdi as okulAdi from eo_2sinif left outer join eo_1okul on eo_1okul.id=eo_2sinif.okulID order by sinifAdi " ;
	   $resultSinif1 = mysqli_query($yol,$sqlSinif1);
            $i = 0;
            while ($i < @mysqli_num_rows($resultSinif1))
            {
	?>
                      <option value="<?php echo mysqli_result($resultSinif1, $i, "kimlik")?>"> <?php echo (mysqli_result($resultSinif1, $i, "sinifAdi")==""?"###":mysqli_result($resultSinif1, $i, "sinifAdi"))?> ( <?php echo (mysqli_result($resultSinif1, $i, "okulAdi")==""?"###":mysqli_result($resultSinif1, $i, "okulAdi"))?> ) </option>
                      <?php			
	 			$i++;
			}
     ?>
                    </select>
                  </div></td>
              </tr>
              <tr>
                <td colspan="2" align="center" class="tabloAlt"><label>
                    <input type="submit" name="gonder5" id="gonder5" value="<?php echo $metin[360]?>" />
                  </label></td>
              </tr>
            </table>
          </form>
          <?php		}else		//update mode
        {

		if(isset($_GET["id"])) $seciliKayit=temizle($_GET["id"]); else $seciliKayit=-1;
	 	if (!is_numeric($seciliKayit))	$seciliKayit=-1;
	 
		  $sql2= "select id,dersAdi, sinifID from eo_3ders where id=$seciliKayit";
		  $result2 = mysqli_query($yol, $sql2);
?>
          <form action="lessonsEdit.php?tab=2&amp;islem=G" method="post" name="dersGuncelle" id="dersGuncelle">
            <table width="530" border="0" cellspacing="0" cellpadding="3" align="center">
              <tr>
                <th colspan="2"><?php echo $metin[372]?> (<?php echo $seciliKayit?> <?php echo $metin[356]?>)</th>
              </tr>
              <tr>
                <td width="87" align="right"><label for="dersAdi"><?php echo $metin[363] ?> : </label></td>
                <td width="293"><span id="dersAdi2">
                  <input name="dersAdi" type="text" id="dersAdi" size="32" maxlength="50" value="<?php echo mysqli_result($result2, 0, "dersAdi")?>" />
                  <span class="textfieldRequiredMsg">&nbsp;</span><span class="textfieldMaxCharsMsg"><br/>
                  <tt><?php echo $metin[357]?></tt></span></span></td>
              </tr>
              <tr>
                <td align="right"><label for="sinifAdlari"><?php echo $metin[362] ?> : </label></td>
                <td><div>
                    <select name="sinifAdlari" id="sinifAdlari">
                      <option value=""><?php echo $metin[106] ?></option>
                      <?php
	   $sqlSinif = "select eo_2sinif.id as kimlik, sinifAdi, eo_1okul.okulAdi as okulAdi from eo_2sinif left outer join eo_1okul on eo_1okul.id=eo_2sinif.okulID order by sinifAdi " ;
	   $resultSinif = mysqli_query($yol,$sqlSinif);
            $i = 0;
            while ($i < @mysqli_num_rows($resultSinif))
            {
	?>
                      <option value="<?php echo mysqli_result($resultSinif, $i, "kimlik")?>"
      <?php if (mysqli_result($resultSinif, $i, "kimlik")==mysqli_result($result2, 0, "sinifID")) echo "selected=\"selected\"";?>
      > <?php echo (mysqli_result($resultSinif, $i, "sinifAdi")==""?"###":mysqli_result($resultSinif, $i, "sinifAdi"))?> ( <?php echo (mysqli_result($resultSinif, $i, "okulAdi")==""?"###":mysqli_result($resultSinif, $i, "okulAdi"))?> ) </option>
                      <?php			
	 			$i++;
			}
     ?>
                    </select>
                  </div></td>
              </tr>
              <tr>
                <td colspan="2" align="center" class="tabloAlt"><label>
                    <input name="id" type="hidden" value="<?php echo mysqli_result($result2, 0, "id")?>" />
                    <input type="submit" name="gonder6" id="gonder6" value="<?php echo $metin[361]?>" />
                    &nbsp;
                    <input type="button" name="gonderme" id="gonderme"  onclick="location.href = &quot;lessonsEdit.php?tab=2&quot;;" value="<?php echo $metin[28]?>" />
                  </label></td>
              </tr>
            </table>
          </form>
          <?php		  
	  }
?>
        </div>
        <!-- ***********************DERS bitti KONU basladi*********************-->
        <?php
		} else
	 if($seciliSekme=="3") 	{	
?>
        <div id="TabbedPanelsContent">
          <?php
   if($_GET["upd"]!=1 || $seciliSekme!="3") {

	   $sirAlan=temizle($_GET["sirAlan"]);
	   if($sirAlan=="") $sirAlan="dersAdi";
	   
	   $siraYap=temizle($_GET["siraYap"]);
	   
	   $filtreleme=temizle((isset($_POST["filtreleme"]))?$_POST["filtreleme"]:"");
	   if(isset($_POST["filtreleme"]) and empty($_POST["filtreleme"]))
	   		$filtreleme = "_";

	   if(!empty($_POST["konuKimGel"]) and $_POST["konuKimGel"]=="1" and !empty($_POST["konuTumu"])) 
		  	$_SESSION["konuKimGel"]=0;
		if(!empty($_POST["konuKimGel"]) and $_POST["konuKimGel"]=="1" and !empty($_POST["konuBenim"])) 
		  	$_SESSION["konuKimGel"]=1;

	   if(empty($_SESSION["konuKimGel"]))
	      $_SESSION["konuKimGel"]=0;
	   
	   if($filtreleme!="") 
	     $_SESSION["filtreleme"]=$filtreleme;
		 else{
		 	if(!isset($_POST["filtreleme"]))
		 		$filtreleme=temizle((isset($_SESSION["filtreleme"]))?$_SESSION["filtreleme"]:"");
			else if(empty($_POST["filtreleme"]))	
			    $_SESSION["filtreleme"]="";
		 }
		 
		if($filtreleme!="") 
		  $araFilter = " konuAdi like '%$filtreleme%' ";
		  else
		  $araFilter = " 1=1 ";
	   
		$siraYonu="asc";
		if (empty($_SESSION["siraYonu5"])) {  
				$_SESSION["siraYonu5"]=$siraYonu;
			} else {
				if ($_GET['siraYap']=="OK"){
					$siraYonu=($_SESSION["siraYonu6"]=="desc")?"asc":"desc";
					$_SESSION["siraYonu6"]=$siraYonu;
					}
					else
					$siraYonu=$_SESSION["siraYonu6"];
			}
			
		if ($sirAlan != "" && in_array($sirAlan, array("id","konuAdi","dersAdi")))
			   $filtr=" $araFilter group by eo_4konu.id order by $sirAlan $siraYonu";
		   else {
			   $sirAlan="dersAdi";
			   $filtr=" $araFilter group by eo_4konu.id order by dersAdi";
		   }
		   
	$sayfaNo = 0;
	if (isset($_GET['sayfaNo'])) {
	  $sayfaNo = $_GET['sayfaNo'];
	}
	$startRow1 = $sayfaNo * $blokBuyuklugu;

?>
          <table border="0" cellpadding="3" cellspacing="0" align="center">
            <tr>
              <th width="60" nowrap="nowrap"><?php if ($sirAlan=="id") {?>
                <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="id")?"desc":"asc"?>.png" alt="S&#305;ralama Y&ouml;n&uuml;" border="0" style="vertical-align: middle;"/>
                <?php } ?>
                <a href="lessonsEdit.php?sirAlan=id&amp;tab=3&amp;siraYap=OK"><?php echo $metin[26]?></a></th>
              <th width="220" nowrap="nowrap"><?php if ($sirAlan=="konuAdi") {?>
                <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="konuAdi")?"desc":"asc"?>.png" alt="S&#305;ralama Y&ouml;n&uuml;" border="0" style="vertical-align: middle;"/>
                <?php } ?>
                <a href="lessonsEdit.php?sirAlan=konuAdi&amp;tab=3&amp;siraYap=OK"><?php echo $metin[364] ?> (<?php echo $metin[329] ?>)</a></th>
              <th nowrap="nowrap"><?php if ($sirAlan=="dersAdi") {?>
                <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="dersAdi")?"desc":"asc"?>.png" alt="S&#305;ralama Y&ouml;n&uuml;" border="0" style="vertical-align: middle;"/>
                <?php } ?>
                <a href="lessonsEdit.php?sirAlan=dersAdi&amp;tab=3&amp;siraYap=OK"><?php echo $metin[363] ?> (<?php echo $metin[297] ?>)</a></th>
            </tr>
            <?php
					  
		  	if($_SESSION["konuKimGel"]==1) 
			  $kimKonu = "left outer join eo_users on eo_5sayfa.ekleyenID=eo_users.id
			where (eo_users.id='".getUserID2($adi)."' or eo_5sayfa.konuID is NULL) and $filtr ";
			 else
			  $kimKonu = " where $filtr "; 
		
			$limitleme = sprintf("LIMIT %d, %d", $startRow1, $blokBuyuklugu);				 
     		$sql = "SELECT eo_4konu.id, eo_4konu.konuAdi, eo_4konu.konuyuKilitle,
					 eo_4konu.sadeceKayitlilarGorebilir, eo_4konu.calismaSuresiDakika, 
					 count(eo_5sayfa.id) as sayfasi, eo_3ders.dersAdi as dersAdi, 
					 eo_2sinif.sinifAdi as sinifAdi, eo_1okul.okulAdi as okulAdi 
			FROM eo_4konu 
	 		left outer join eo_5sayfa on eo_4konu.id=eo_5sayfa.konuID 
	 		left outer join eo_3ders on eo_4konu.dersID=eo_3ders.id 
			left outer join eo_2sinif on eo_2sinif.id=eo_3ders.sinifID 
			left outer join eo_1okul on eo_1okul.id=eo_2sinif.okulID 
			$kimKonu $limitleme";
//echo $sql;
			$result = mysqli_query($yol, $sql);
			if($result){
		  	if($_SESSION["konuKimGel"]==1) 
				$kayitSayisi = mysqli_num_rows(mysqli_query($yol,
						"select DISTINCT eo_4konu.konuAdi from eo_4konu 
	 					left outer join eo_5sayfa on eo_4konu.id=eo_5sayfa.konuID 
						left outer join eo_users on eo_5sayfa.ekleyenID=eo_users.id						
						where $araFilter and (eo_users.id='".getUserID2($adi)."' or eo_users.id is NULL)"));			
			 else
   				$kayitSayisi = mysqli_num_rows(mysqli_query($yol,"select * from eo_4konu where $araFilter "));			
			$sayfaSayisi = ceil($kayitSayisi/$blokBuyuklugu)-1;
			}
			
	if (@mysqli_num_rows($result)==0)
	 {
		 echo "<tr><td colspan='3'><font id='hata'>Kay&#305;t yok veya arama sonu&ccedil;suz kald&#305;!</font></td></tr>";
	 }
	 else {
            $i = 0; $satirRenk=0;
            while ($i < @mysqli_num_rows($result))
            {
 
				$sqlSayfa 	= "select count(*) as toplam from eo_5sayfa where konuID = '".
						@mysqli_result($result,$i,"id")."'";
				$sayfaSayisi2 = mysqli_query($yol,$sqlSayfa);
				$s_sayisi = mysqli_result($sayfaSayisi2,0,"toplam");													    	
				
		$satirRenk++;
        if ($satirRenk & 1) { 
            $row_color = "#CCC"; 
        } else { 
            $row_color = "#ddd"; 
        }
  
  ?>
            <tr>
              <td align="right" nowrap="nowrap"  
		  <?php echo "style=\"background-color: $row_color;\""?>><?php echo mysqli_result($result, $i, "id")?></td>
              <td nowrap="nowrap" title="<?php echo $metin[397]?>" onmouseover	="javascript:this.style.backgroundColor='#FFFF55';" 
          onmouseout	="javascript:this.style.backgroundColor='<?php echo $row_color?>';" <?php echo "style=\"background-color: $row_color;\""?>><a href="lessonsEdit.php?tab=4&amp;seciliKonu=<?php echo mysqli_result($result, $i, "id")?>"><?php echo mysqli_result($result, $i, "konuAdi")?> (<?php echo mysqli_result($result, $i, "sayfasi")?>)</a> <?php echo (mysqli_result($result,$i,"konuyuKilitle")?"<img src='img/lock.png' border=\"0\" style=\"vertical-align: middle;\" alt=\"".$metin[179]."\" title=\"".$metin[179]."\" />":"")?> <?php echo (mysqli_result($result,$i,"sadeceKayitlilarGorebilir")?"<img src='img/user_manager.gif' border=\"0\" style=\"vertical-align: middle;\" alt=\"".$metin[181]."\" title=\"".$metin[181]."\" />":"")?> <?php echo (mysqli_result($result,$i,"calismaSuresiDakika")?"<img src='img/history.png' border=\"0\" style=\"vertical-align: middle;\" alt=\"".$metin[169]."\" title=\"".$metin[169]."\" />":"")?>
                <?php 
						  if($s_sayisi==0) 
						     echo "<img src='img/empty.png' border=\"0\" style=\"vertical-align: middle;\" alt=\"".$metin[209]."\" title=\"".$metin[209]."\" />";
						  ?>
                <a href="dersBilgisi.php?ders=<?php echo mysqli_result($result, $i, "id")?>" rel="facebox"> <img src="img/info.png" border="0" style="vertical-align:middle" alt="<?php echo $metin[301]?>" /></a></td>
              <td nowrap="nowrap" <?php echo "style=\"background-color: $row_color;\""?>><?php echo (mysqli_result($result, $i, "dersAdi")==""?"<font class=bosVeri title='Kay&#305;t yok veya bir hata meydana geldi!'>###</font>":mysqli_result($result, $i, "dersAdi"))?> ( <?php echo (mysqli_result($result, $i, "sinifAdi")==""?"<font class=bosVeri title='Kay&#305;t yok veya bir hata meydana geldi!'>###</font>":mysqli_result($result, $i, "sinifAdi"))?> )</td>
              <td width="60" align="center" valign="middle" nowrap="nowrap"><a href="<?php echo $currentPage;?>?tab=3&amp;id=<?php echo mysqli_result($result, $i, "id");?>&amp;upd=1" title="<?php echo $metin[103]?>"><img src="img/edit.png" alt="<?php echo $metin[103]?>" width="16" height="16" border="0" style="vertical-align: middle;" /></a>&nbsp;|&nbsp;<a href="#" onclick="javascript:delWithCon('<?php echo $currentPage;?>?tab=3&amp;islem=S',<?php echo mysqli_result($result, $i, "id")?>,'<?php echo $metin[420] ?>');" title="<?php echo $metin[102] ?>"><img src="img/cross.png" alt="<?php echo $metin[102] ?>" width="16" height="16" border="0" style="vertical-align: middle;" /></a></td>
            </tr>
            <?php
  				 $i++;
			}
	 }
  ?>
          </table>
          <?php
	if($kayitSayisi>$blokBuyuklugu){
?>
          <table  width="100" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
            <tr>
              <td align="center"><a href="<?php printf("lessonsEdit.php?sayfaNo=%d&amp;tab=3&amp;sirAlan=$sirAlan", 0); ?>"><img src="img/page-first.gif" border="0" alt="first" /></a></td>
              <td align="center"><a href="<?php printf("lessonsEdit.php?sayfaNo=%d&amp;tab=3&amp;sirAlan=$sirAlan", max(0, $sayfaNo - 1)); ?>"><img src="img/page-prev.gif" border="0"  alt="prev"/></a></td>
              <td align="center"><a href="<?php printf("lessonsEdit.php?sayfaNo=%d&amp;tab=3&amp;sirAlan=$sirAlan", min($sayfaSayisi, $sayfaNo + 1)); ?>"> <img src="img/page-next.gif" border="0" alt="next" /></a></td>
              <td align="center"><a href="<?php printf("lessonsEdit.php?sayfaNo=%d&amp;tab=3&amp;sirAlan=$sirAlan", $sayfaSayisi); ?>"><img src="img/page-last.gif" border="0"  alt="last"/></a></td>
            </tr>
            <tr>
              <td colspan="4" align="center"><?php echo min($startRow1 + $blokBuyuklugu, $kayitSayisi) ?> / <?php echo $kayitSayisi ?></td>
            </tr>
          </table>
          <form action="lessonsEdit.php?tab=3" method="post" name="sayfalamaAdeti" id="sayfalamaAdeti">
            <?php echo $metin[110];?> :
            <select name="blokSayi">
              <option value="5" <?php echo ($blokBuyuklugu=="5")?"selected=\"selected\"":""?>>5</option>
              <option value="10" <?php echo ($blokBuyuklugu=="10")?"selected=\"selected\"":""?>>10</option>
              <option value="15" <?php echo ($blokBuyuklugu=="15")?"selected=\"selected\"":""?>>15</option>
              <option value="20" <?php echo ($blokBuyuklugu=="20")?"selected=\"selected\"":""?>>20</option>
            </select>
            &nbsp;
            <input name="Tamam" type="submit" value="<?php echo $metin[30]?>" />
          </form>
          <?php
   }
?>
          <br />
          <form action="lessonsEdit.php" method="post" name="konuKim" id="konuKim">
            <input type="hidden" name="konuKimGel" value="1" />
            <input type="submit" value="<?php echo $metin[483];?>" name="konuTumu" id="konuTumu" 
                      <?php if($_SESSION["konuKimGel"]==0){ ?>style="border:inset 2px #ccc;"<?php } ?> />
            &nbsp;
            <input type="submit" value="<?php echo $metin[484];?>" name="konuBenim" id="konuBenim"
                      <?php if($_SESSION["konuKimGel"]==1){ ?>style="border:inset 2px #ccc;"<?php } ?>  />
            <?php
                      echo $metin[616];?>
          </form>
          <br/>
          <form action="lessonsEdit.php?tab=3" method="post" name="araFiltrele" id="araFiltrele">
            <?php echo $metin[29] ?> :
            <input type="text" maxlength="50" size="32" name="filtreleme" value="<?php echo ($filtreleme!="_")?$filtreleme:""?>" title="<?php echo $metin[358] ?>" />
            <input name="ara" type="image" id="ara" src="img/view.png" alt="Ara"  style="vertical-align: middle;"/>
          </form>
          <br />
          <form action="lessonsEdit.php?tab=3&amp;islem=E" method="post" name="konular" id="konular">
            <table border="0" cellspacing="0" cellpadding="3" align="center">
              <tr>
                <th colspan="2"><?php echo $metin[368]?></th>
              </tr>
              <tr>
                <td width="87" align="right"><label for="konuAdi"><?php echo $metin[364] ?> : </label></td>
                <td width="293"><span id="konuAdii">
                  <input name="konuAdi" type="text" id="konuAdi" size="32" maxlength="50" />
                  <span class="textfieldRequiredMsg">&nbsp;</span><span class="textfieldMaxCharsMsg"><br/>
                  <tt><?php echo $metin[357]?></tt></span></span></td>
              </tr>
              <tr>
                <td align="right"><label for="dersAdlari"><?php echo $metin[363] ?> : </label></td>
                <td><div>
                    <select name="dersAdlari" id="dersAdlari">
                      <option value=""><?php echo $metin[106] ?></option>
                      <?php
	   $sqlDers = "SELECT eo_3ders.id AS kimlik, dersAdi, eo_2sinif.sinifAdi AS sinifAdi, eo_1okul.okulAdi AS okulAdi FROM eo_3ders".
	              " left outer JOIN eo_2sinif ON eo_2sinif.id=eo_3ders.sinifID " .
	              " left outer JOIN eo_1okul ON eo_1okul.id=eo_2sinif.okulID ORDER BY dersAdi" ;
	   $resultDers = mysqli_query($yol,$sqlDers);
            $i = 0;
            while ($i < @mysqli_num_rows($resultDers))
            {
	?>
                      <option value="<?php echo mysqli_result($resultDers, $i, "kimlik")?>"> <?php echo (mysqli_result($resultDers, $i, "dersAdi")==""?"###":mysqli_result($resultDers, $i, "dersAdi"))?> ( <?php echo (mysqli_result($resultDers, $i, "okulAdi")==""?"###":mysqli_result($resultDers, $i, "okulAdi"))?> - <?php echo (mysqli_result($resultDers, $i, "sinifAdi")==""?"###":mysqli_result($resultDers, $i, "sinifAdi"))?> )</option>
                      <?php			
	 			$i++;
			}
     ?>
                    </select>
                  </div></td>
              </tr>
              <tr>
                <td colspan="2"><tt><?php echo $metin[379] ?></tt></td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap"><label for="oncekiKonuID"><?php echo $metin[380] ?> : </label></td>
                <td ><select name="oncekiKonuID" id="oncekiKonuID">
                    <option value=""><?php echo $metin[106] ?></option>
                    <?php
	   $sqlDers = "SELECT eo_4konu.id AS kimlik, konuAdi FROM eo_4konu".
	              " ORDER BY konuAdi" ;
	   $resultDers = mysqli_query($yol,$sqlDers);
            $i = 0;
            while ($i < @mysqli_num_rows($resultDers))
            {
	?>
                    <option value="<?php echo mysqli_result($resultDers, $i, "kimlik");?>"> <?php echo mysqli_result($resultDers, $i, "konuAdi")?> </option>
                    <?php			
	 			$i++;
			}
     ?>
                  </select></td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap"><label for="bitisTarihi"><?php echo $metin[381] ?> : </label></td>
                <td ><input name="bitisTarihi" type="text" id="bitisTarihi" size="32" maxlength="50" />
                  <br />
                  <tt><?php echo $metin[546]?></tt></td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap"><label for="konuyuKilitle"><?php echo "<img src='img/lock.png' border=\"0\" style=\"vertical-align: middle;\" alt='".$metin[179]."' title='".$metin[179]."' />";?> <?php echo $metin[382] ?> : </label></td>
                <td ><span id="konuyuKilitlesi">
                  <input name="konuyuKilitle" type="checkbox" id="konuyuKilitle" value="1" />
                  </span></td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap" valign="top"><label for="sadeceKayitlilarGorebilir"><?php echo "<img src='img/user_manager.gif' border=\"0\" style=\"vertical-align: middle;\" alt='".$metin[181]."' title='".$metin[181]."' />";?> <?php echo $metin[383] ?> : </label></td>
                <td ><input name="sadeceKayitlilarGorebilir" type="checkbox" id="sadeceKayitlilarGorebilir" value="1" onclick="chekDisable();" />
                  <br/>
                  <tt><?php echo $metin[384] ?></tt>
                  <table>
                    <tr>
                      <td align="right" nowrap="nowrap"><label for="calismaSuresiDakika"><?php echo "<img src='img/history.png' border=\"0\" style=\"vertical-align: middle;\" alt='".$metin[169]."' title='".$metin[169]."' />";?> <?php echo $metin[385] ?> : </label></td>
                      <td ><input name="calismaSuresiDakika" type="text" id="calismaSuresiDakika" size="10" maxlength="50" value="0"  /></td>
                    </tr>
                    <tr>
                      <td align="right" nowrap="nowrap"><label for="calismaHakSayisi"><?php echo $metin[386] ?> : </label></td>
                      <td ><input name="calismaHakSayisi" type="text" id="calismaHakSayisi" size="10" maxlength="50" value="0"  /></td>
                    </tr>
                    <tr>
                      <td align="right" nowrap="nowrap"><label for="sinifaDahilKullaniciGorebilir"><?php echo $metin[387] ?> : </label></td>
                      <td ><input name="sinifaDahilKullaniciGorebilir" type="checkbox" id="sinifaDahilKullaniciGorebilir" value="1"  /></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td colspan="2" align="center" class="tabloAlt"><label>
                    <input type="submit" name="gonder7" id="gonder7" value="<?php echo $metin[360]?>" />
                  </label></td>
              </tr>
            </table>
          </form>
          <?php		}else		//update mode
        {

		if(isset($_GET["id"])) $seciliKayit=temizle($_GET["id"]); else $seciliKayit=-1;
	 
		  $sql2= "select * from eo_4konu where id=$seciliKayit";
		  $result2 = mysqli_query($yol, $sql2);
		  
			if ($seciliKayit!="") {
   				echo "<h2>$metin[299] : <font style='font-variant: small-caps;color: #0a0;'>".mysqli_result($result2, 0, "konuAdi")."</font></h2><br/>";
				printf($metin[388],$seciliKayit,$seciliKayit);
			}
		  
?>
          <form action="lessonsEdit.php?tab=3&amp;islem=G" method="post" name="konular" id="konular">
            <table border="0" cellspacing="0" cellpadding="3" align="center">
              <tr>
                <th colspan="2"><?php echo $metin[373]?> (<?php echo $seciliKayit?> <?php echo $metin[356]?>)</th>
              </tr>
              <tr>
                <td width="87" align="right"><label for="konuAdi"><?php echo $metin[364] ?> : </label></td>
                <td width="293"><span id="konuAdi2">
                  <input name="konuAdi" type="text" id="konuAdi" size="32" maxlength="50" value="<?php echo mysqli_result($result2, 0, "konuAdi")?>" />
                  <span class="textfieldRequiredMsg">&nbsp;</span><span class="textfieldMaxCharsMsg"><br/>
                  <tt><?php echo $metin[357]?></tt></span></span></td>
              </tr>
              <tr>
                <td align="right"><label for="dersAdlari"><?php echo $metin[363] ?> : </label></td>
                <td><select name="dersAdlari" id="dersAdlari">
                    <option value=""><?php echo $metin[106] ?></option>
                    <?php
	   $sqlDers = "SELECT eo_3ders.id AS kimlik, dersAdi, eo_2sinif.sinifAdi AS sinifAdi, eo_1okul.okulAdi AS okulAdi FROM eo_3ders".
	              " left outer JOIN eo_2sinif ON eo_2sinif.id=eo_3ders.sinifID " .
	              " left outer JOIN eo_1okul ON eo_1okul.id=eo_2sinif.okulID ORDER BY dersAdi" ;
	   $resultDers = mysqli_query($yol,$sqlDers);
            $i = 0;
            while ($i < @mysqli_num_rows($resultDers))
            {
	?>
                    <option value="<?php echo mysqli_result($resultDers, $i, "kimlik")?>"
      <?php if (mysqli_result($resultDers, $i, "kimlik")==mysqli_result($result2, 0, "dersID")) echo "selected=\"selected\"";?>
      > <?php echo (mysqli_result($resultDers, $i, "dersAdi")==""?"###":mysqli_result($resultDers, $i, "dersAdi"))?> ( <?php echo (mysqli_result($resultDers, $i, "okulAdi")==""?"###":mysqli_result($resultDers, $i, "okulAdi"))?> - <?php echo (mysqli_result($resultDers, $i, "sinifAdi")==""?"###":mysqli_result($resultDers, $i, "sinifAdi"))?> )</option>
                    <?php			
	 			$i++;
			}
     ?>
                  </select></td>
              </tr>
              <tr>
                <td colspan="2"><tt><?php echo $metin[379] ?></tt></td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap"><label for="oncekiKonuID"><?php echo $metin[380] ?> : </label></td>
                <td ><select name="oncekiKonuID" id="oncekiKonuID">
                    <option value=""><?php echo $metin[106] ?></option>
                    <?php
	   $sqlDers = "SELECT eo_4konu.id AS kimlik, konuAdi FROM eo_4konu".
	              " ORDER BY konuAdi" ;
	   $resultDers = mysqli_query($yol,$sqlDers);
            $i = 0;
            while ($i < @mysqli_num_rows($resultDers))
            { 
			  if(mysqli_result($resultDers, $i, "kimlik") != mysqli_result($result2, 0, "id") ) {
	?>
                    <option value="<?php echo mysqli_result($resultDers, $i, "kimlik"); ?>" <?php if (mysqli_result($resultDers, $i, "kimlik")==mysqli_result($result2, 0, "oncekiKonuID")) echo "selected=\"selected\"";?>><?php echo mysqli_result($resultDers, $i, "konuAdi")?></option>
                    <?php			
			  }
	 			$i++;
			}
     ?>
                  </select></td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap"><label for="bitisTarihi"><?php echo $metin[381] ?> : </label></td>
                <td ><input name="bitisTarihi" type="text" id="bitisTarihi" size="32" maxlength="50" value="<?php echo (mysqli_result($result2, 0, "bitisTarihi")=="0000-00-00")?"":tarihOku(mysqli_result($result2, 0, "bitisTarihi"))?>" />
                  <br />
                  <tt><?php echo $metin[546]?></tt></td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap"><label for="konuyuKilitle"><?php echo "<img src='img/lock.png' border=\"0\" style=\"vertical-align: middle;\" alt='".$metin[179]."' title='".$metin[179]."' />";?> <?php echo $metin[382] ?> : </label></td>
                <td ><span id="konuyuKilitlesi">
                  <input name="konuyuKilitle" type="checkbox" id="konuyuKilitle" value="1"
              <?php echo (mysqli_result($result2, 0, "konuyuKilitle")!="0") ? "checked=\"checked\"" : ""?> />
                  </span></td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap" valign="top"><label for="sadeceKayitlilarGorebilir"><?php echo "<img src='img/user_manager.gif' border=\"0\" style=\"vertical-align: middle;\" alt='".$metin[181]."' title='".$metin[181]."' />";?> <?php echo $metin[383] ?> : </label></td>
                <td ><input name="sadeceKayitlilarGorebilir" type="checkbox" id="sadeceKayitlilarGorebilir" value="1" 
              <?php echo (mysqli_result($result2, 0, "sadeceKayitlilarGorebilir")!="0") ? "checked=\"checked\"" : ""?> onclick="chekDisable();"/>
                  <br />
                  <tt><?php echo $metin[384] ?></tt>
                  <table>
                    <tr>
                      <td align="right" nowrap="nowrap"><label for="calismaSuresiDakika"><?php echo "<img src='img/history.png' border=\"0\" style=\"vertical-align: middle;\" alt='".$metin[169]."' title='".$metin[169]."' />";?> <?php echo $metin[385] ?> : </label></td>
                      <td ><input name="calismaSuresiDakika" type="text" id="calismaSuresiDakika" size="10" maxlength="50" value="<?php echo mysqli_result($result2, 0, "calismaSuresiDakika")?>"   /></td>
                    </tr>
                    <tr>
                      <td align="right" nowrap="nowrap"><label for="calismaHakSayisi"><?php echo $metin[386] ?> : </label></td>
                      <td ><input name="calismaHakSayisi" type="text" id="calismaHakSayisi" size="10" maxlength="50" value="<?php echo mysqli_result($result2, 0, "calismaHakSayisi")?>"  /></td>
                    </tr>
                    <tr>
                      <td align="right" nowrap="nowrap"><label for="sinifaDahilKullaniciGorebilir"><?php echo $metin[387] ?> : </label></td>
                      <td ><input name="sinifaDahilKullaniciGorebilir" type="checkbox" id="sinifaDahilKullaniciGorebilir" value="1" <?php echo (mysqli_result($result2, 0, "sinifaDahilKullaniciGorebilir")!="0") ? "checked=\"checked\"" : ""?>   /></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td colspan="2" align="center" class="tabloAlt"><label>
                    <input name="id" type="hidden" value="<?php echo mysqli_result($result2, 0, "id")?>" />
                    <input type="submit" name="gonder8" id="gonder8" value="<?php echo $metin[361]?>" />
                    &nbsp;
                    <input type="button" name="gonderme" id="gonderme"  onclick="location.href = &quot;lessonsEdit.php?tab=3&quot;;" value="<?php echo $metin[28]?>" />
                  </label></td>
              </tr>
            </table>
          </form>
          <?php		  
	  }
?>
        </div>
        <?php
	 }else
	 if($seciliSekme=="4" )
	 {
?>
        <div id="TabbedPanelsContent"> 
          <!-- *************************************SAYFA ba&#351;lad&#305; *************************************************-->
          <?php
	   $seciliKonu = temizle((isset($_GET["seciliKonu"]))?$_GET["seciliKonu"]:"");
	   if(empty($seciliKonu)) 
	      $seciliKonu= temizle($_SESSION["seciliKonu"]);
		 else
		  $_SESSION["seciliKonu"]=$seciliKonu;	
		  
   if($_GET["upd"]!=1) {

	   
	   $sirAlan=temizle($_GET["sirAlan"]);
	   if($sirAlan=="") $sirAlan="id";
	   
	   $siraYap=temizle($_GET["siraYap"]);
	   
		$siraYonu="asc";
		if (empty($_SESSION["siraYonu3"])) {  
				$_SESSION["siraYonu3"]=$siraYonu;
			} else {
				if ($_GET['siraYap']=="OK"){
					$siraYonu=($_SESSION["siraYonu4"]=="desc")?"asc":"desc";
					$_SESSION["siraYonu4"]=$siraYonu;
					}
					else
					$siraYonu=$_SESSION["siraYonu4"];
			}
			
			  $sirAlan="id" ;
			   $filtr=" order by id";
		   
	$sayfaNo = 0;
	if (isset($_GET['sayfaNo'])) {
	  $sayfaNo = $_GET['sayfaNo'];
	}
	$startRow1 = $sayfaNo * $blokBuyuklugu;
	
			$limitleme = sprintf("LIMIT %d, %d", $startRow1, $blokBuyuklugu);				 
		    $sql = "SELECT * FROM eo_5sayfa where (eo_5sayfa.konuID=$seciliKonu) $filtr $limitleme ";

			$result = mysqli_query($yol, $sql);
				if($result) {
				$kayitSayisi = mysqli_num_rows(mysqli_query($yol,"select * from eo_5sayfa where konuID=$seciliKonu"));			
				$sayfaSayisi = ceil($kayitSayisi/$blokBuyuklugu)-1;
				}
			if (getKonuAdi($seciliKonu)!="") {
   				echo "<h2>$metin[299] : <font style='font-variant: small-caps;color: #0a0;'>".getKonuAdi($seciliKonu)."</font></h2><br/>";
				printf($metin[389],$seciliKonu,$seciliKonu);
			}

?>
          <table border="0" cellpadding="3" cellspacing="0" align="center">
            <tr>
              <th width="60" nowrap="nowrap" ><?php if ($sirAlan=="id") {?>
                <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="id")?"desc":"asc"?>.png" alt="S&#305;ralama Y&ouml;n&uuml;" border="0" style="vertical-align: middle;"/>
                <?php } ?>
                <?php echo $metin[26]?></th>
              <th width="445" nowrap="nowrap"><?php echo $metin[390]?></th>
            </tr>
            <?php 			
	if (@mysqli_num_rows($result)==0)
	 {
		 echo "<tr><td colspan='3'><font id='hata'>Bu konuda &#351;imdilik hi&ccedil;bir sayfa bulunmuyor!</font></td></tr>";
	 }
	 else {
            $i = 0; $satirRenk=0;
            while ($i < @mysqli_num_rows($result))
            {
 
    	$satirRenk++;
        if ($satirRenk & 1) { 
            $row_color = "#CCC"; 
        } else { 
            $row_color = "#ddd"; 
        }
  
  ?>
            <tr>
              <td align="right"   <?php echo "style=\"background-color: $row_color;\""?>><?php echo mysqli_result($result, $i, "id")?></td>
              <td  <?php echo "style=\"background-color: $row_color;\""?>><?php echo (strlen(strip_tags(html_entity_decode(mysqli_result($result, $i, "anaMetin"))))>50)?substr(strip_tags(html_entity_decode(mysqli_result($result, $i, "anaMetin"))),0,50)."...":strip_tags(html_entity_decode(mysqli_result($result, $i, "anaMetin")));?></td>
              <td width="60" align="center" valign="middle" ><a href="<?php echo $currentPage;?>?tab=4&amp;id=<?php echo mysqli_result($result, $i, "id");?>&amp;upd=1" title="<?php echo $metin[103]?>"><img src="img/edit.png" alt="<?php echo $metin[103]?>" width="16" height="16" border="0" style="vertical-align: middle;" /></a>&nbsp;|&nbsp;<a href="#" onclick="javascript:delWithCon('<?php echo $currentPage;?>?tab=4&amp;islem=S',<?php echo mysqli_result($result, $i, "id")?>,'<?php echo $metin[420] ?>');" title="<?php echo $metin[102] ?>"><img src="img/cross.png" alt="<?php echo $metin[102] ?>" width="16" height="16" border="0" style="vertical-align: middle;" /></a></td>
            </tr>
            <?php
  				 $i++;
			}
	 }
  ?>
          </table>
          <?php
	if($kayitSayisi>$blokBuyuklugu){
?>
          <table  width="100" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
            <tr>
              <td align="center"><a href="<?php printf("lessonsEdit.php?sayfaNo=%d&amp;tab=4&amp;sirAlan=$sirAlan", 0); ?>"><img src="img/page-first.gif" border="0"  alt="first"/></a></td>
              <td align="center"><a href="<?php printf("lessonsEdit.php?sayfaNo=%d&amp;tab=4&amp;sirAlan=$sirAlan", max(0, $sayfaNo - 1)); ?>"><img src="img/page-prev.gif" border="0"  alt="prev"/></a></td>
              <td align="center"><a href="<?php printf("lessonsEdit.php?sayfaNo=%d&amp;tab=4&amp;sirAlan=$sirAlan", min($sayfaSayisi, $sayfaNo + 1)); ?>"> <img src="img/page-next.gif" border="0" alt="next" /></a></td>
              <td align="center"><a href="<?php printf("lessonsEdit.php?sayfaNo=%d&amp;tab=4&amp;sirAlan=$sirAlan", $sayfaSayisi); ?>"><img src="img/page-last.gif" border="0"  alt="last"/></a></td>
            </tr>
            <tr>
              <td colspan="4" align="center"><?php echo min($startRow1 + $blokBuyuklugu, $kayitSayisi) ?> / <?php echo $kayitSayisi ?></td>
            </tr>
          </table>
          <form action="lessonsEdit.php?tab=4" method="post" name="sayfalamaAdeti" id="sayfalamaAdeti">
            <?php echo $metin[110];?> : &nbsp;
            <select name="blokSayi">
              <option value="5" <?php echo ($blokBuyuklugu=="5")?"selected=\"selected\"":""?>>5</option>
              <option value="10" <?php echo ($blokBuyuklugu=="10")?"selected=\"selected\"":""?>>10</option>
              <option value="15" <?php echo ($blokBuyuklugu=="15")?"selected=\"selected\"":""?>>15</option>
              <option value="20" <?php echo ($blokBuyuklugu=="20")?"selected=\"selected\"":""?>>20</option>
            </select>
            &nbsp;
            <input name="Tamam" type="submit" value="<?php echo $metin[30]?>" />
          </form>
          <?php
   }
?>
          <p>&nbsp;</p>
          <form action="lessonsEdit.php?tab=4&amp;islem=E" method="post" name="sayfaForm" id="sayfaForm">
            <table border="0" cellspacing="0" cellpadding="3" align="center">
              <tr>
                <th colspan="2"><?php echo $metin[369]?></th>
              </tr>
              <tr>
                <td colspan="2" align="center" class="tabloAlt"><label>
                    <input type="submit" name="gonder9" id="gonder9" value="<?php echo $metin[360]?>" />
                  </label>
                  &nbsp;
                  <input type="button" name="gonderme" id="gonderme"  onclick="location.href = &quot;lessonsEdit.php?tab=3&quot;;" value="<?php echo $metin[28]?>" /></td>
              </tr>
              <tr>
                <td width="100" align="right"><label for="anaMetin"><?php echo $metin[390]?> : </label></td>
                <td  style="background-color:#FFF;"><textarea name="anaMetin" cols="90" rows="10" id="anaMetin"></textarea></td>
              </tr>
            </table>
            <h4 id='soruEklemeHead' style="cursor:pointer;"><img src="img/page-next.gif" alt='next' border='0' style="vertical-align: middle;"/><?php echo $metin[683]?></h4>
            <div id="soruEkleme">
            <table border="0" cellspacing="0" cellpadding="3" align="center">
              <tr>
                <td width="100" align="right"><label for="cevap"><?php echo $metin[391]?> : </label></td>
                <td  style="background-color:#FFF;"><input type="text" name="cevap" id="cevap" size="50" maxlength="50" value=""/>
                  <br />
                  <?php echo $metin[393]?></td>
              </tr>
              <tr>
                <td width="100" align="right"><label for="secenek1"><?php echo $metin[392]?> A : </label></td>
                <td  style="background-color:#FFF;"><textarea name="secenek1" cols="60" rows="3" id="secenek1"></textarea></td>
              </tr>
              <tr>
                <td width="100" align="right"><label for="secenek2"><?php echo $metin[392]?> B : </label></td>
                <td  style="background-color:#FFF;"><textarea name="secenek2" cols="60" rows="3" id="secenek2"></textarea></td>
              </tr>
              <tr>
                <td width="100" align="right"><label for="secenek3"><?php echo $metin[392]?> C : </label></td>
                <td  style="background-color:#FFF;"><textarea name="secenek3" cols="60" rows="3" id="secenek3"></textarea></td>
              </tr>
              <tr>
                <td width="100" align="right"><label for="secenek4"><?php echo $metin[392]?> D : </label></td>
                <td  style="background-color:#FFF;"><textarea name="secenek4" cols="60" rows="3" id="secenek4"></textarea></td>
              </tr>
              <tr>
                <td width="100" align="right"><label for="secenek5"><?php echo $metin[392]?> E : </label></td>
                <td  style="background-color:#FFF;"><textarea name="secenek5" cols="60" rows="3" id="secenek5"></textarea></td>
              </tr>
              <tr>
                <td width="100" align="right"><label for="secenek6"><?php echo $metin[392]?> F : </label></td>
                <td  style="background-color:#FFF;"><textarea name="secenek6" cols="60" rows="3" id="secenek6"></textarea></td>
              </tr>
              <tr>
                <td> Cevap Süresi: </td>
                <td  style="background-color:#FFF;"><input type="text" name="cevapSuresi" id="cevapSuresi" size="15" maxlength="30" value="60"/>
                  <?php echo $metin[172]?></td>
              </tr>
              <tr>
                <td> Sunum Geçiş Süresi: </td>
                <td  style="background-color:#FFF;"><input type="text" name="slideGecisSuresi" id="slideGecisSuresi" size="15" maxlength="30" value="0"/>
                  <?php echo $metin[172]?></td>
              </tr>
              <tr>
                <td colspan="2" ><p><?php echo $metin[394]?> </p></td>
              </tr>
              <tr>
                <td colspan="2" align="center" class="tabloAlt"><label>
                    <input type="submit" name="gonder39" id="gonder39" value="<?php echo $metin[360]?>" />
                  </label>
                  &nbsp;
                  <input type="button" name="gonderme2" id="gonderme2"  onclick="location.href = &quot;lessonsEdit.php?tab=3&quot;;" value="<?php echo $metin[28]?>" /></td>
              </tr>
                </div>
              
            </table>
          </form>
          <script language="JavaScript" type="text/javascript" src="lib/nicEdit.js"></script> 
          <script type="text/javascript">
bkLib.onDomLoaded(function() {
//new nicEditor({fullPanel  :  true},{uploadURI : 'lib/nicEdit.php'}).panelInstance('anaMetin');
	new nicEditor({buttonList : ['fontSize'     , 'fontFamily'     , 'fontFormat' ,'bold'    , 'italic'    , 'underline'    , 'left'    , 'center'    , 'right'    , 'justify'    , 'ol'    , 'ul'    , 'subscript'    , 'superscript'    , 'strikethrough'    , 'removeformat'    , 'indent'    , 'outdent'    , 'hr'         ,  'image' , 'forecolor'   , 'link' ,     , 'unlink' ,'upload'   , 'xhtml']}).panelInstance('anaMetin');
});
</script>
          <?php		}else		//update mode
      {
		if(isset($_GET["id"])) $seciliKayit=temizle($_GET["id"]); else $seciliKayit=-1;
	 	if (!is_numeric($seciliKayit))	$seciliKayit=-1;
	 
		  $sql2= "select * from eo_5sayfa where id=$seciliKayit";
		  $result2 = mysqli_query($yol, $sql2);
?>
          <form name="sayfaForm" action="lessonsEdit.php?tab=4&amp;islem=G" method="post" id="sayfaForm">
            <table border="0" cellspacing="0" cellpadding="3" align="center">
              <tr>
                <th colspan="2"><?php echo $metin[374]?> (<?php echo $seciliKayit?> <?php echo $metin[356]?>)</th>
              </tr>
              <tr>
                <td colspan="2" align="center" class="tabloAlt"><label>
                    <input name="id" type="hidden" value="<?php echo mysqli_result($result2, 0, "id")?>" />
                    <input type="submit" name="gonder2" id="gonder2" value="<?php echo $metin[361]?>" />
                    &nbsp;
                    <input type="button" name="gonderme" id="gonderme"  onclick="location.href = &quot;lessonsEdit.php?tab=4&quot;;" value="<?php echo $metin[28]?>" />
                  </label></td>
              </tr>
              <tr>
                <td width="100" align="right"><label for="konuID"><?php echo $metin[299]?> : </label></td>
                <td  style="background-color:#FFF;"><select name="konuID" id="konuID">
                    <option value=""><?php echo $metin[106] ?></option>
                    <?php
	   $sqlDers = "SELECT eo_4konu.id AS kimlik, konuAdi FROM eo_4konu".
	              " ORDER BY konuAdi" ;
	   $resultDers = mysqli_query($yol,$sqlDers);
            $i = 0;
            while ($i < @mysqli_num_rows($resultDers))
            {
	?>
                    <option value="<?php echo mysqli_result($resultDers, $i, "kimlik"); ?>" <?php if (mysqli_result($resultDers, $i, "kimlik")==mysqli_result($result2, 0, "konuID")) echo "selected=\"selected\"";?>><?php echo mysqli_result($resultDers, $i, "konuAdi")?></option>
                    <?php			
	 			$i++;
			}
     ?>
                  </select></td>
              </tr>
              <tr>
                <td width="87" align="right"><label for="anaMetin"><?php echo $metin[390]?> : </label></td>
                <td style="background-color:#FFF;" ><textarea name="anaMetin" cols="90" rows="10" id="anaMetin"><?php echo ( mysqli_result($result2, 0, "anaMetin"))?>
              </textarea></td>
              </tr>
            </table>
            <h4 id='soruEklemeHead' style="cursor:pointer;"><img src="img/page-next.gif" alt='next' border='0' style="vertical-align: middle;"/>Soru Olarak Düzenle</h4>
            <div id="soruEkleme">
            <table border="0" cellspacing="0" cellpadding="3" align="center">
              <tr>
                <td width="87" align="right"><label for="cevap"><?php echo $metin[391]?> : </label></td>
                <td  style="background-color:#FFF;"><input type="text" name="cevap" id="cevap" size="50" maxlength="50" value="<?php echo mysqli_result($result2, 0, "cevap");?>"/>
                  <br />
                  <?php echo $metin[393]?></td>
              </tr>
              <tr>
                <td width="87" align="right"><label for="secenek1"><?php echo $metin[392]?> A : </label></td>
                <td  style="background-color:#FFF;"><textarea name="secenek1" cols="60" rows="3" id="secenek1"><?php echo mysqli_result($result2, 0, "secenek1");?></textarea></td>
              </tr>
              <tr>
                <td width="87" align="right"><label for="secenek2"><?php echo $metin[392]?> B : </label></td>
                <td  style="background-color:#FFF;"><textarea name="secenek2" cols="60" rows="3" id="secenek2"><?php echo mysqli_result($result2, 0, "secenek2");?></textarea></td>
              </tr>
              <tr>
                <td width="87" align="right"><label for="secenek3"><?php echo $metin[392]?> C : </label></td>
                <td  style="background-color:#FFF;"><textarea name="secenek3" cols="60" rows="3" id="secenek3"><?php echo mysqli_result($result2, 0, "secenek3");?></textarea></td>
              </tr>
              <tr>
                <td width="87" align="right"><label for="secenek4"><?php echo $metin[392]?> D : </label></td>
                <td  style="background-color:#FFF;"><textarea name="secenek4" cols="60" rows="3" id="secenek4"><?php echo mysqli_result($result2, 0, "secenek4");?></textarea></td>
              </tr>
              <tr>
                <td width="87" align="right"><label for="secenek5"><?php echo $metin[392]?> E : </label></td>
                <td  style="background-color:#FFF;"><textarea name="secenek5" cols="60" rows="3" id="secenek5"><?php echo mysqli_result($result2, 0, "secenek5");?></textarea></td>
              </tr>
              <tr>
                <td width="87" align="right"><label for="secenek6"><?php echo $metin[392]?> F : </label></td>
                <td  style="background-color:#FFF;"><textarea name="secenek6" cols="60" rows="3" id="secenek6"><?php echo mysqli_result($result2, 0, "secenek6");?></textarea></td>
              </tr>
              <tr>
                <td> Cevap Süresi: </td>
                <td  style="background-color:#FFF;"><input type="text" name="cevapSuresi" id="cevapSuresi" size="15" maxlength="30" value="<?php echo mysqli_result($result2, 0, "cevapSuresi");?>"/>
                  <?php echo $metin[172]?></td>
              </tr>
              <tr>
                <td> Sunum Geçiş Süresi: </td>
                <td  style="background-color:#FFF;"><input type="text" name="slideGecisSuresi" id="slideGecisSuresi" size="15" maxlength="30" value="<?php echo mysqli_result($result2, 0, "slideGecisSuresi");?>"/>
                  <?php echo $metin[172]?></td>
              </tr>
              <tr>
                <td colspan="2" ><p><?php echo $metin[394]?></p></td>
              </tr>
              <tr>
                <td colspan="2" align="center" class="tabloAlt"><label>
                    <input name="id" type="hidden" value="<?php echo mysqli_result($result2, 0, "id")?>" />
                    <input type="submit" name="gonder22" id="gonder22" value="<?php echo $metin[361]?>" />
                    &nbsp;
                    <input type="button" name="gonderme2" id="gonderme2"  onclick="location.href = &quot;lessonsEdit.php?tab=4&quot;;" value="<?php echo $metin[28]?>" />
                  </label></td>
              </tr>
            </table>
          </form>
          <script language="JavaScript" type="text/javascript" src="lib/nicEdit.js"></script> 
          <script type="text/javascript">
bkLib.onDomLoaded(function() {
	new nicEditor({buttonList : ['fontSize'     , 'fontFamily'     , 'fontFormat' ,'bold'    , 'italic'    , 'underline'    , 'left'    , 'center'    , 'right'    , 'justify'    , 'ol'    , 'ul'    , 'subscript'    , 'superscript'    , 'strikethrough'    , 'removeformat'    , 'indent'    , 'outdent'    , 'hr'         ,  'image' , 'forecolor'   , 'link' ,     , 'unlink' ,'upload'   , 'xhtml']}).panelInstance('anaMetin');
});
</script>
          <?php		  
	  }
?>
        </div>
		<?php
	if ($seciliSekme==4 && $seciliKonu>0){
?>
<div class="Post-body"> 
    <h2 class="PostHeaderIcon-wrapper"> <a name="sayfaSiralamasi"></a><?php echo $metin[395]?> </h2>
    <div class="PostContent"><?php echo $metin[396]?><br />
      <br />
      <div id="contentLeft">
        <?php
 		    $sql = "SELECT * FROM eo_5sayfa where (eo_5sayfa.konuID=$seciliKonu) order by sayfaSirasi ";
			$result = mysqli_query($yol, $sql);			
			
			$_SESSION["konuID"]=$seciliKonu;
			
	if (@mysqli_num_rows($result)==0)
	 {
		 echo "<font id='uyari'>Bu konuda &#351;imdilik hi&ccedil;bir sayfa bulunmuyor!</font>";
	 }
	 else {
            $i = 0; 
			echo "<ul id='list_to_sort' style=\"cursor:pointer;display: block;text-align:left;width: 80%;background-color: #ddd;color: #00b;\">";
            while ($i < @mysqli_num_rows($result))
            {
				$siralanacak = substr(strip_tags(mysqli_result($result, $i, "anaMetin")),0,100);
				echo "<li id='recordsArray_".(mysqli_result($result, $i, "id"))."'><font face='Courier New'>[".mysqli_result($result, $i, "id")."] ".$siralanacak."</font></li>";
				$i++;
			}
			echo "</ul>";

?>
        <?php			
	 }
 
?>
        <script language="JavaScript" type="text/javascript" src="lib/jquery-ui-1.10.2.custom.min.js"></script> 
        <script language="JavaScript" type="text/javascript" src="lib/jquery.timers-1.1.2.js"></script> 
        <script type="text/javascript">
$(document).ready(function(){ 

	$(function() {
		$("#contentLeft ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize") + '&'+'action=updateRecordsListings';
			$.post("setPageOrder.php", order, function(theResponse){
				$("#contentRight").html(theResponse);
			});
		}
		});
	});

});
</script> 
      </div>
    </div>
</div>	
    <?php
	}
?>
        <!-- ***********************************SAYFA bitti CANLI DERS ba&#351;lad&#305;**************-->
        <?php
		} else
	 if($seciliSekme=="5") 	{	
?>
        <div id="TabbedPanelsContent">
          <?php
   if($_GET["upd"]!=1) {

	   $sirAlan=temizle($_GET["sirAlan"]);
	   if($sirAlan=="") $sirAlan="dateWhen";
	   
	   $siraYap=temizle($_GET["siraYap"]);

	   $filtreleme2=temizle((isset($_POST["filtreleme2"]))?$_POST["filtreleme2"]:"");
	   if(isset($_POST["filtreleme2"]) and empty($_POST["filtreleme2"]))
	     $filtreleme2 = "_";
		 
	   if($filtreleme2!="") 
	     $_SESSION["filtreleme2"]=$filtreleme2;
		 else
		 $filtreleme2=temizle((isset($_SESSION["filtreleme2"]))?$_SESSION["filtreleme2"]:"");
		 
		if($filtreleme2!="") 
		  $araFilter = " dersAdi like '%$filtreleme2%' ";
		  else
		  $araFilter = " 1=1 ";
	   
		$siraYonu="ASC";
		if (empty($_SESSION["siraYonu5"])) {  
				$_SESSION["siraYonu5"]=$siraYonu;
			} else {
				if ($_GET['siraYap']=="OK"){
					$siraYonu=($_SESSION["siraYonu6"]=="desc")?"asc":"desc";
					$_SESSION["siraYonu6"]=$siraYonu;
					}
					else
					$siraYonu=(isset($_SESSION["siraYonu6"]))?$_SESSION["siraYonu6"]:"";
			}
			
		if ($sirAlan != "" && in_array($sirAlan, array("id","dersAdi","userAdi","dateWhen")))
			   $filtr=" $araFilter order by $sirAlan $siraYonu";
		   else {
			   $sirAlan="sinifAdi";
			   $filtr=" $araFilter order by dateWhen";
		   }
		   
	$sayfaNo = 0;
	if (isset($_GET['sayfaNo'])) {
	  $sayfaNo = $_GET['sayfaNo'];
	}
	$startRow1 = $sayfaNo * $blokBuyuklugu;

?>
          <table border="0" cellpadding="3" cellspacing="0" align="center">
            <tr>
              <th width="60" nowrap="nowrap"><?php if ($sirAlan=="id") {?>
                <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="id")?"desc":"asc"?>.png" alt="S&#305;ralama Y&ouml;n&uuml;" border="0" style="vertical-align: middle;"/>
                <?php } ?>
                <a href="lessonsEdit.php?sirAlan=id&amp;tab=5&amp;siraYap=OK"><?php echo $metin[26]?></a></th>
              <th nowrap="nowrap"><?php if ($sirAlan=="dersAdi") {?>
                <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="dersAdi")?"desc":"asc"?>.png" alt="S&#305;ralama Y&ouml;n&uuml;" border="0" style="vertical-align: middle;"/>
                <?php } ?>
                <a href="lessonsEdit.php?sirAlan=dersAdi&amp;tab=5&amp;siraYap=OK"><?php echo $metin[363] ?></a></th>
              <th  nowrap="nowrap"><?php if ($sirAlan=="userAdi") {?>
                <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="userAdi")?"desc":"asc"?>.png" alt="S&#305;ralama Y&ouml;n&uuml;" border="0" style="vertical-align: middle;"/>
                <?php } ?>
                <a href="lessonsEdit.php?sirAlan=userAdi&amp;tab=5&amp;siraYap=OK"><?php echo $metin[17] ?></a></th>
              <th  nowrap="nowrap"><?php if ($sirAlan=="dateWhen") {?>
                <img src="img/<?php echo ($siraYonu=="desc" && $sirAlan=="dateWhen")?"desc":"asc"?>.png" alt="S&#305;ralama Y&ouml;n&uuml;" border="0" style="vertical-align: middle;"/>
                <?php } ?>
                <a href="lessonsEdit.php?sirAlan=dateWhen&amp;tab=5&amp;siraYap=OK"><?php echo $metin[129] ?></a></th>
            </tr>
            <?php
			$limitleme = sprintf("LIMIT %d, %d", $startRow1, $blokBuyuklugu);				 
     		$sql = "SELECT eo_livelesson.id as id, eo_users.id as userID, eo_3ders.dersAdi as dersAdi, eo_users.userName as userAdi, dateWhen 
			FROM eo_livelesson 
			left outer join eo_3ders on eo_3ders.id=eo_livelesson.dersID
			left outer join eo_users on eo_users.id=eo_livelesson.userID 
			where $filtr $limitleme";

			$result = mysqli_query($yol, $sql);		
			if($result){
				$caDerSor = mysqli_query($yol, 
						"SELECT eo_livelesson.id as id, eo_3ders.dersAdi as dersAdi
						FROM eo_livelesson 
						left outer join eo_3ders on eo_3ders.id=eo_livelesson.dersID
						left outer join eo_users on eo_users.id=eo_livelesson.userID 
						where $araFilter");				
				$kayitSayisi = mysqli_num_rows($caDerSor);			
				$sayfaSayisi = ceil($kayitSayisi/$blokBuyuklugu)-1;
			}else{
				$kayitSayisi = 0;$sayfaSayisi = 0;
			}
			
	if (@mysqli_num_rows($result)==0)
	 {
		 echo "<tr><td colspan='4'><font id='hata'>Kay&#305;t yok veya arama sonu&ccedil;suz kald&#305;!</font></td></tr>";
	 }
	 else {
            $i = 0; $satirRenk=0;
            while ($i < @mysqli_num_rows($result))
            {
 
    	$satirRenk++;
        if ($satirRenk & 1) { 
            $row_color = "#CCC"; 
        } else { 
            $row_color = "#ddd"; 
        }
  
  ?>
            <tr>
              <td align="right"  <?php echo "style=\"background-color: $row_color;\""?>><?php echo mysqli_result($result, $i, "id")?></td>
              <td nowrap="nowrap" <?php echo "style=\"background-color: $row_color;\""?>><?php echo mysqli_result($result, $i, "dersAdi")?></td>
              <td <?php echo "style=\"background-color: $row_color;\""?>><a href="profil.php?kim=<?php echo mysqli_result($result, $i, "userID")?>" rel="facebox"><?php echo (mysqli_result($result, $i, "userAdi")==""?"<font class=bosVeri title='Kay&#305;t yok veya bir hata meydana geldi!'>###</font>":mysqli_result($result, $i, "userAdi"))?></a></td>
              <td <?php echo "style=\"background-color: $row_color;\""?>><?php echo date("d-m-Y H:i",strtotime(mysqli_result($result, $i, "dateWhen")))?></td>
              <td width="60" align="center" valign="middle"><a href="<?php echo $currentPage;?>?tab=5&amp;id=<?php echo mysqli_result($result, $i, "id");?>&amp;upd=1" title="<?php echo $metin[103]?>"><img src="img/edit.png" alt="<?php echo $metin[103]?>" width="16" height="16" border="0" style="vertical-align: middle;" /></a>&nbsp;|&nbsp;<a href="#" onclick="javascript:delWithCon('<?php echo $currentPage;?>?tab=5&amp;islem=S',<?php echo mysqli_result($result, $i, "id")?>,'<?php echo $metin[420] ?>');" title="<?php echo $metin[102] ?>"><img src="img/cross.png" alt="<?php echo $metin[102] ?>" width="16" height="16" border="0" style="vertical-align: middle;" /></a></td>
            </tr>
            <?php
  				 $i++;
			}
	 }
  ?>
          </table>
          <?php
	if($kayitSayisi>$blokBuyuklugu){
?>
          <table  width="100" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
            <tr>
              <td align="center"><a href="<?php printf("lessonsEdit.php?sayfaNo=%d&amp;tab=5&amp;sirAlan=$sirAlan", 0); ?>"><img src="img/page-first.gif" border="0" alt="first" /></a></td>
              <td align="center"><a href="<?php printf("lessonsEdit.php?sayfaNo=%d&amp;tab=5&amp;sirAlan=$sirAlan", max(0, $sayfaNo - 1)); ?>"><img src="img/page-prev.gif" border="0" alt="prev" /></a></td>
              <td align="center"><a href="<?php printf("lessonsEdit.php?sayfaNo=%d&amp;tab=5&amp;sirAlan=$sirAlan", min($sayfaSayisi, $sayfaNo + 1)); ?>"> <img src="img/page-next.gif" border="0"  alt="next"/></a></td>
              <td align="center"><a href="<?php printf("lessonsEdit.php?sayfaNo=%d&amp;tab=5&amp;sirAlan=$sirAlan", $sayfaSayisi); ?>"><img src="img/page-last.gif" border="0"  alt="last"/></a></td>
            </tr>
            <tr>
              <td colspan="4" align="center"><?php echo min($startRow1 + $blokBuyuklugu, $kayitSayisi) ?> / <?php echo $kayitSayisi ?></td>
            </tr>
          </table>
          <form action="lessonsEdit.php?tab=5" method="post" name="sayfalamaAdeti" id="sayfalamaAdeti">
            <?php echo $metin[110];?> : &nbsp;
            <select name="blokSayi">
              <option value="5" <?php echo ($blokBuyuklugu=="5")?"selected=\"selected\"":""?>>5</option>
              <option value="10" <?php echo ($blokBuyuklugu=="10")?"selected=\"selected\"":""?>>10</option>
              <option value="15" <?php echo ($blokBuyuklugu=="15")?"selected=\"selected\"":""?>>15</option>
              <option value="20" <?php echo ($blokBuyuklugu=="20")?"selected=\"selected\"":""?>>20</option>
            </select>
            &nbsp;
            <input name="Tamam" type="submit" value="<?php echo $metin[30]?>" />
          </form>
          <?php
   }
?>
          <br />
          <form action="lessonsEdit.php?tab=5" method="post" name="araFiltrele2" id="araFiltrele2">
            <?php echo $metin[29] ?> :
            <input type="text" maxlength="50" size="32" name="filtreleme2" value="<?php echo ($filtreleme2!="_")?$filtreleme2:""?>" title="<?php echo $metin[358] ?>" />
            <input name="ara" type="image" id="ara" src="img/view.png" alt="Ara"  style="vertical-align: middle;"/>
          </form>
          <br />
          <form action="lessonsEdit.php?tab=5&amp;islem=E" method="post" name="canlidersEkle" id="canlidersEkle">
            <table width="530" border="0" cellspacing="0" cellpadding="3" align="center">
              <tr>
                <th colspan="2"><?php echo "$metin[52] $metin[360]"?></th>
              </tr>
              <tr>
                <td align="right"><label for="dersAdlari"><?php echo $metin[363] ?> : </label></td>
                <td><div>
                    <select name="dersAdlari" id="dersAdlari">
                      <option value=""><?php echo $metin[106] ?></option>
                      <?php
	   $sqlSinif1 = "select id,dersAdi from eo_3ders order by dersAdi " ;
	   $resultSinif1 = mysqli_query($yol, $sqlSinif1);
            $i = 0;
            while ($i < @mysqli_num_rows($resultSinif1))
            {
	?>
                      <option value="<?php echo mysqli_result($resultSinif1, $i, "id")?>"> <?php echo (mysqli_result($resultSinif1, $i, "dersAdi"))?></option>
                      <?php			
	 			$i++;
			}
     ?>
                    </select>
                  </div></td>
              </tr>
              <tr>
                <td align="right"><label for="kullaniciAdlari"><?php echo $metin[17]; ?> : </label></td>
                <td><div>
                    <select name="kullaniciAdlari" id="kullaniciAdlari">
                      <option value=""><?php echo $metin[106] ?></option>
                      <?php
	   $sqlSinif1 = "select id, userName from eo_users where userType in ('1','2') order by userName " ;
	   $resultSinif1 = mysqli_query($yol,$sqlSinif1);
	   
            $i = 0;
            while ($i < @mysqli_num_rows($resultSinif1))
            {
	?>
                      <option value="<?php echo mysqli_result($resultSinif1, $i, "id")?>" <?php echo (mysqli_result($resultSinif1, $i, "id")==getUserID($_SESSION["usern"],$_SESSION["userp"]))?"selected='selected'":""?>> <?php echo mysqli_result($resultSinif1, $i, "userName")?> </option>
                      <?php			
	 			$i++;
			}
     ?>
                    </select>
                  </div></td>
              </tr>
              <tr>
                <td width="87" align="right"><label for="dersSuresi"><?php echo $metin[668] ?> : </label></td>
                <td width="293"><input name="dersSuresi" type="text" id="dersSuresi" size="32" maxlength="50" value="40"/></td>
              </tr>
              <tr>
                <td width="87" align="right"><label for="tarihEtkinlik"><?php echo $metin[669] ?> : </label></td>
                <td width="293"><span id="tarihEtkinliki">
                  <input name="tarihEtkinlik" type="text" id="tarihEtkinlik" size="32" maxlength="50" value="<?php echo date("d-m-Y H:i");?>" />
                  <span class="textfieldRequiredMsg">&nbsp;</span><span class="textfieldMaxCharsMsg"><br/>
                  <tt><?php echo $metin[671]?></tt></span></span></td>
              </tr>
              <tr>
                <td width="87" align="right"><label for="notlar"><?php echo $metin[670] ?> : </label></td>
                <td width="293"><span id="notlari">
                  <input name="notlar" type="text" id="notlar" size="32" maxlength="100" />
                  <span class="textfieldRequiredMsg">&nbsp;</span><span class="textfieldMaxCharsMsg"><br/>
                  <tt><?php echo $metin[120]?></tt></span></span></td>
              </tr>
              <tr>
                <td colspan="2" align="center" class="tabloAlt"><label>
                    <input type="submit" name="gonder6" id="gonder6" value="<?php echo $metin[360]?>" />
                  </label></td>
              </tr>
            </table>
          </form>
          <?php		}else		//update mode
        {

		if(isset($_GET["id"])) $seciliKayit=temizle($_GET["id"]); else $seciliKayit=-1;
	 	if (!is_numeric($seciliKayit))	$seciliKayit=-1;
	 
		  $sql2= "select * from eo_livelesson where id=$seciliKayit";
		  $result2 = mysqli_query($yol, $sql2);
?>
          <form action="lessonsEdit.php?tab=5&amp;islem=G" method="post" name="dersGuncelle" id="dersGuncelle">
            <table width="530" border="0" cellspacing="0" cellpadding="3" align="center">
              <tr>
                <th colspan="2"><?php echo "$metin[672] ($seciliKayit $metin[356])"?></th>
              </tr>
              <tr>
                <td align="right"><label for="dersAdlari"><?php echo $metin[363] ?> : </label></td>
                <td><div>
                    <select name="dersAdlari" id="dersAdlari">
                      <option value=""><?php echo $metin[106] ?></option>
                      <?php
	   $sqlSinif1 = "select id,dersAdi from eo_3ders order by dersAdi " ;
	   $resultSinif1 = mysqli_query($yol,$sqlSinif1);
            $i = 0;
            while ($i < @mysqli_num_rows($resultSinif1))
            {
	?>
                      <option value="<?php echo mysqli_result($resultSinif1, $i, "id")?>" <?php echo (mysqli_result($resultSinif1, $i, "id")==mysqli_result($result2, 0, "dersID"))?"selected='selected'":"";?> > <?php echo (mysqli_result($resultSinif1, $i, "dersAdi"))?></option>
                      <?php			
	 			$i++;
			}
     ?>
                    </select>
                  </div></td>
              </tr>
              <tr>
                <td align="right"><label for="kullaniciAdlari"><?php echo $metin[17]; ?> : </label></td>
                <td><div>
                    <select name="kullaniciAdlari" id="kullaniciAdlari">
                      <option value=""><?php echo $metin[106] ?></option>
                      <?php
	   $sqlSinif1 = "select id, userName from eo_users where userType in ('1','2') order by userName " ;
	   $resultSinif1 = mysqli_query($yol,$sqlSinif1);
	   
            $i = 0;
            while ($i < @mysqli_num_rows($resultSinif1))
            {
	?>
                      <option value="<?php echo mysqli_result($resultSinif1, $i, "id")?>" <?php echo (mysqli_result($resultSinif1, $i, "id")==mysqli_result($result2, 0, "userID"))?"selected='selected'":""?>> <?php echo mysqli_result($resultSinif1, $i, "userName")?> </option>
                      <?php			
	 			$i++;
			}
     ?>
                    </select>
                  </div></td>
              </tr>
              <tr>
                <td width="87" align="right"><label for="dersSuresi"><?php echo $metin[668] ?> : </label></td>
                <td width="293"><input name="dersSuresi" type="text" id="dersSuresi" size="32" maxlength="50" value="<?php echo mysqli_result($result2, 0, "length")?>" /></td>
              </tr>
              <tr>
                <td width="87" align="right"><label for="tarihEtkinlik"><?php echo $metin[669] ?> : </label></td>
                <td width="293"><span id="tarihEtkinliki">
                  <input name="tarihEtkinlik" type="text" id="tarihEtkinlik" size="32" maxlength="50" value="<?php echo date("d-m-Y H:i",strtotime(mysqli_result($result2, 0, "dateWhen")))?>"  />
                  <span class="textfieldRequiredMsg">&nbsp;</span><span class="textfieldMaxCharsMsg"><br/>
                  <tt><?php echo $metin[671]?></tt></span></span></td>
              </tr>
              <tr>
                <td width="87" align="right"><label for="notlar"><?php echo $metin[670] ?> : </label></td>
                <td width="293"><span id="notlari">
                  <input name="notlar" type="text" id="notlar" size="32" maxlength="100" value="<?php echo mysqli_result($result2, 0, "yontem")?>"  />
                  <span class="textfieldRequiredMsg">&nbsp;</span><span class="textfieldMaxCharsMsg"><br/>
                  <tt><?php echo $metin[120]?></tt></span></span></td>
              </tr>
              <tr>
                <td colspan="2" align="center" class="tabloAlt"><label>
                    <input name="id" type="hidden" value="<?php echo mysqli_result($result2, 0, "id")?>" />
                    <input type="submit" name="gonder22" id="gonder22" value="<?php echo $metin[361]?>" />
                    &nbsp;
                    <input type="button" name="gonderme2" id="gonderme2"  onclick="location.href = &quot;lessonsEdit.php?tab=5&quot;;" value="<?php echo $metin[28]?>" />
                  </label></td>
              </tr>
            </table>
          </form>
          <?php	
		}
	  }else 
	 echo "<font id='uyari'>Düzenlenecek i&#351;lemi <?php echo $metin[106] ?>.<br/> Sayfa düzenlemek i&ccedil;in &ouml;nce bir konu (kimlik s&uuml;tununa t&#305;klatarak) <?php echo $metin[106] ?>. </font> ";
?>
        </div>
        
        <!-- ************************************************hepsi bitti!********************************--> 
      </div>
      <div class="cleared"></div>
    </div>
  </div>
</div>

  <footer class="footer">
    <div class="Footer-inner">
      <?php  require "footer.php";?>
    </div>
  </footer>
</div>
<script src="lib/bs_js/bootstrap.js"></script> 
<script src="lib/bs_js/ie10-viewport-bug-workaround.js"></script> 
<script type="text/javascript">
<!--
/*
chekDisable:
kayıtlı kullanıcı ayarları seçimi
*/
function chekDisable(){
	if (document.getElementById("sinifaDahilKullaniciGorebilir")==null) exit();
	var disable;
	disable = document.getElementById("sadeceKayitlilarGorebilir").checked;
	if(disable==true){
	   if (document.getElementById("calismaSuresiDakika")!=null) document.konular.calismaSuresiDakika.disabled = false;
	   if (document.getElementById("calismaHakSayisi")!=null) document.konular.calismaHakSayisi.disabled = false;
	   if (document.getElementById("sinifaDahilKullaniciGorebilir")!=null) document.getElementById("sinifaDahilKullaniciGorebilir").disabled = false;
	}else{
	   if (document.getElementById("calismaSuresiDakika")!=null) document.konular.calismaSuresiDakika.disabled = true;
	   if (document.getElementById("calismaHakSayisi")!=null) document.konular.calismaHakSayisi.disabled = true;
	   if (document.getElementById("sinifaDahilKullaniciGorebilir")!=null) document.getElementById("sinifaDahilKullaniciGorebilir").disabled = true;
	}
}

if (document.getElementById("anaMetin")!=null) document.sayfaForm.anaMetin.focus();
if (document.getElementById("sadeceKayitlilarGorebilir")!=null) {
	 chekDisable();
}
 fix_flash();
//-->
</script>
</body>
</html>
<?php
 mysqli_close($yol);
 mysqli_close($yol1);
?>