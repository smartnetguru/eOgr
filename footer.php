<?php
/*
eOgr - elearning project

Developer Site: http://yunus.sourceforge.net
Demo Site:		http://yunus.sourceforge.net/eogr
Source Track:	http://eogr.googlecode.com 
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

if($seceneklerimiz[0]=="1" and $kullaniciSecen[0]=="1") {
?>

<a href="rss.php" class="rss-tag-icon" title="RSS"></a>
<?php
}
?>
<div class="Footer-text" style="font-size:smaller;">
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
if($seceneklerimiz[1]=="1" and $kullaniciSecen[1]=="1") {
?>
    <label for="theme"><?php echo $metin[154]?> : </label>
    <select name="theme" id="theme" onchange="document.themeSelect.submit();">
      <?php	
	$themeArray=glob('theme/*', GLOB_ONLYDIR);
	$i=0;
	foreach($themeArray as $thme){
?>
      <option value="<?php $temaGel = explode("/",$thme);
	  echo $temaGel[1];?>" <?php if (!(strcmp($temaGel[1], temizle($_COOKIE['theme'])))) {echo "selected=\"selected\"";} ?>>
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

if($seceneklerimiz[2]=="1" and $kullaniciSecen[2]=="1") {
?>
<script type="text/javascript">
<!--
var timeout         = 500;
var closetimer		= 0;
var ddmenuitem      = 0;

// open hidden layer
function mopen(id){	
	// cancel close timer
	mcancelclosetime();

	// close old layer
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';

	// get new layer and show it
	ddmenuitem = document.getElementById(id);
	ddmenuitem.style.visibility = 'visible';

}
// close showed layer
function mclose(){
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
}

// go close timer
function mclosetime(){
	closetimer = window.setTimeout(mclose, timeout);
}

// cancel close timer
function mcancelclosetime(){
	if(closetimer)	{
		window.clearTimeout(closetimer);
		closetimer = null;
	}
}

// close layer when click-out
document.onclick = mclose; 
// -->
</script>
    <img src='<?php 
	if($taraDili=="TR")
	  echo "img/turkish.png";
	  else
	  echo "img/english.png";
	?>' border='0' alt='Dil Language' 
    style='vertical-align: middle;' 
    title='Dil se&ccedil;iniz Choose a language'
    onmouseover="mopen('dilSecimi');" 
    onmouseout="mclosetime();" />
    <div id="dilSecimi"   onmouseover="mcancelclosetime()" onmouseout="mclosetime()"> <a href='index.php?lng=EN&amp;oldPath=<?php echo $currentFile?>' ><img src='img/turkish.png' border='0' alt='Dil' style='vertical-align: middle;'/></a>&nbsp; <a href='index.php?lng=TR&amp;oldPath=<?php echo $currentFile?>'> <img src='img/english.png' border='0' alt='Language' style='vertical-align: middle;'/></a> </div>
    <?php
}
					
if($seceneklerimiz[3]=="1" and $kullaniciSecen[3]=="1") 
echo ("&nbsp;".$metin[155]." ".round(getmicrotime() - $time,3)."s");

		$humanRelativeDate2 = new HumanRelativeDate();
		$insansi = $humanRelativeDate2->getTextForSQLDate(date("Y-m-d H:i:s", filemtime($currentFile)));

if($seceneklerimiz[4]=="1" and $kullaniciSecen[4]=="1") 
echo ("&nbsp;|&nbsp;<font size='-3'>".$metin[217]." ".$insansi."</font>");

?>
    <strong> <?php echo $metin[68]?> :</strong> <?php echo ayarGetir("versiyon")?>
  </form>
</div>
<?php
 mysql_close($yol);
 mysql_close($yol1);
?>
