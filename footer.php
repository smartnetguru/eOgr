<?php
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
	@session_start();

	$adi	=@temizle(substr($_SESSION["usern"],0,15));
	
$seceneklerimiz = explode("-",ayarGetir("ayar5char"));
$kullaniciSecen = explode("-",ayarGetir3($adi));

?>
<div class="Footer-text" style="font-size:smaller;text-align:center;">
  <form method="get" action="" name="themeSelect">
    <?php
	$currentFile = $_SERVER["PHP_SELF"];
    $parts = Explode('/', $currentFile);
    $currentFile = $parts[count($parts) - 1];
?>
    <script type="text/javascript">
if (document.getElementById("hata")!=null) fadeUp(document.getElementById("hata"),255,0,0,150,0,0);
if (document.getElementById("uyari")!=null) fadeUp(document.getElementById("uyari"),0,0,255,0,0,150);
if (document.getElementById("tamam")!=null) fadeUp(document.getElementById("tamam"),0,255,0,0,150,0);  
  </script>
    <?php
if($seceneklerimiz[1]=="1" and $kullaniciSecen[1]=="1" and $currentFile!="help.php") {
?>
    <label for="theme"><?php echo $metin[154]?> : </label>
    <select name="theme" id="theme" onchange="document.themeSelect.submit();">
      <?php	
	$themeArray=glob('theme/*', GLOB_ONLYDIR);
	$i=0;
	foreach($themeArray as $thme){
?>
      <option value="<?php $temaGel = explode("/",$thme);
	  echo $temaGel[1];?>" <?php if (!(!empty($_COOKIE['theme']) && strcmp($temaGel[1], temizle($_COOKIE['theme'])))) {echo "selected=\"selected\"";} ?>>
      <?php 	  
	  echo $temaGel[1];
	  ?>
      </option>
      <?php
	  $i++;
	}
?>
    </select>
    <?php	
}

if($seceneklerimiz[2]=="1" and $kullaniciSecen[2]=="1" and $currentFile!="help.php") {
?>
    <span id="dilSecimi"><a href='index.php?lng=EN&amp;oldPath=<?php echo $currentFile?>' ><img src='img/turkish.png' border='0' alt='Dil' style='vertical-align: middle;'/></a>&nbsp; <a href='index.php?lng=TR&amp;oldPath=<?php echo $currentFile?>'> <img src='img/english.png' border='0' alt='Language' style='vertical-align: middle;'/></a></span>
    <?php
}
					
if($seceneklerimiz[3]=="1" and $kullaniciSecen[3]=="1") 
echo ("&nbsp;".$metin[155]." : ".round(getmicrotime() - $time,3)."s");

		$humanRelativeDate2 = new HumanRelativeDate();
		$insansi = $humanRelativeDate2->getTextForSQLDate(date("Y-m-d H:i:s", filemtime($currentFile)));

if($seceneklerimiz[4]=="1" and $kullaniciSecen[4]=="1") 
echo ("&nbsp;|&nbsp;".$metin[217]." ".$insansi);

?>
    <strong> <?php echo $metin[68]?> :</strong> <?php echo ayarGetir("versiyon")?>
    <?php 
if($seceneklerimiz[0]=="1" and $kullaniciSecen[0]=="1") {
?>
    <span class="rss-tag-icon"><a href="rss.php" title="RSS"><img src="img/rssIcon.png" border="0" style="vertical-align:middle"/></a></span>
    <?php
}?>
  </form>
</div>