<?php
if(!isset($_GET["error"]))
 $_GET["error"]="";
if(!in_array($_GET["error"],array("5","6"))) {
	require("conf.php");
	checkLoginLang(false,true,"error.php");
	$seceneklerimiz = explode("-",ayarGetir("ayar5char"));
}else
	header("Location: install.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
<title>eOgr -<?php echo $metin[489]?></title>
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="stylesheet" href="theme/stilGenel.css" type="text/css" media="all" />
<script language="javascript" type="text/javascript" src="lib/fade.js"></script>
<style type="text/css">
* {
	font-family:Verdana, Geneva, sans-serif;
}
</style>
</head>
<body>
<?php 
	if(isset($_SESSION["usern"]))
		$adi = RemoveXSS($_SESSION["usern"]);
	if(isset($_POST["reopenPwd"]))
		if($_POST["reopenPwd"]==$_siteUnlockPwd and 
			!empty($_siteUnlockPwd) and 
			!empty($_POST["reopenPwd"])){
			if(siteAc()) {  
				trackUser($currentFile,"success,SiteUnlock",$adi);
				die("<br/>$metin[531]<p>$metin[402]</p>");
			}
		}
?>
<TABLE align="center" width="100%" height="100%" style="background-color:#C00">
  <tr>
    <td height="100%" valign="middle" ><table align="center">
        <tr>
          <td><h2 align="center">eOgr - <?php echo $metin[489]?></h2>
            <p style="margin-top:50px;"> <font color="#FF0000" > <?php echo $metin[402]?> </font> </p>
            <?php
	 switch ($_GET["error"]){
		 case "1":
		  echo "<font id='hata'> $metin[400]</font>"; //not login
		  break;
		 case "2":
		  echo "<font id='hata'> $metin[403]</font>"; //empty username
		  break;
		 case "3":
		  echo "<font id='hata'> $metin[295]</font>"; //source error
		  break;
		 case "4":
		  echo "<font id='hata'> $metin[401]</font>"; //flood
		  break;		 
		 case "7":			//bad login
		  echo "<font id='hata'> ".$metin[404]."</font><br/>".$metin[402];
		  break;		  
 		 case "8":			//file name error
		  echo "<font id='hata'>$metin[449]</font>";
		  break;	
 		 case "9":			//not allowed for students/teachers
		  echo "<font id='hata'>$metin[447]</font>";
		  break;	
 		 case "10":			//not allowed for students
		  echo "<font id='hata'>$metin[448]</font>";
		  break;	
 		 case "11":			//site is closed 
		  echo "<font id='hata'>$metin[527]</font>";
		  break;	
 		 case "12":			//not allowed for all
		  echo "<font id='hata'>$metin[548]</font>";
		  break;	
		 default:			//file not found
		  echo "<font id='hata'>$metin[468]</font>";		  	  
	}
?>
            <p style="font-size:10px;">
              <?php
 echo "<strong>$metin[491] :</strong> ".RemoveXSS($_SERVER['REMOTE_ADDR'])."<br/>";  
// echo "<strong>$metin[492] :</strong> ".RemoveXSS($_SERVER['HTTP_REFERER'])."<br/>"; 
 echo "<strong>$metin[129] :</strong> ".date("d-m-Y H:i:s")."<br/>"; 
 
 if($_GET["error"]!=11 and !empty($_SESSION["usern"]) and !empty($_SESSION["userp"])){
?>
            </p>
            <h5> <?php echo $metin[490]?> </h5>
            <?php
	 }

 if($seceneklerimiz[15]=="1" and $_GET["error"]==11){
?>
            <p>
            
            <form action="error.php?error=11" method="post" name="reopen">
              <label>Enter Password :
                <input name="reopenPwd" type="password" size="30" maxlength="30" />
              </label>
            </form>
            </p>
            <?php
 }
?></td>
        </tr>
      </table></td>
  </tr>
</table>
<script type="text/javascript" language="javascript">
if (document.getElementById("hata")!=null) fadeUp(document.getElementById("hata"),255,0,0,150,0,0);
</script>
</body>
</html>
<!--
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
-->