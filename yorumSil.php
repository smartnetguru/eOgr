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
header("Content-Type: text/html; charset=iso-8859-9"); 

     $taraDili=(isset($_COOKIE["lng"]))?$_COOKIE["lng"]:"";    
   if(!($taraDili=="TR" || $taraDili=="EN")) $taraDili="EN";
      if ($taraDili=="TR")
        require("lib/tr.php"); 
      elseif ($taraDili=="EN")  
        require("lib/en.php"); 
      else 
        require("lib/en.php");         

require 'database.php';
require "conf.php"; 
if (!check_source()) die ("<font id='hata'>$metin[295]</font>");
/*
baglan2:
veritaban� ba�lant�s�
*/
function baglan2()
{
	global  $_host;
	global  $_username;
	global  $_password;
    return 	@mysql_connect($_host, $_username, $_password);
}

if(!baglan2())   
 die("<font id='hata'> L&#252;ften, 'veritaban&#305;' <a href=install.php>kurulumunu (installation)</a> yap&#305;n&#305;z!</font>");
 
$yol1 = baglan2();

	if (!@mysql_select_db($_db, $yol1))
	{
		die("<font id='hata'> 
		  Veritaban&#305; <a href=install.php>ayarlar&#305;n&#305;z&#305;</a> yapmad&#305;n&#305;z!<br/>
		  You need to go to <a href=install.php>installing page</a>!<br/>
			 </font>");
	}
/*
temizle2:
xss temizleme
*/
function temizle2($metin)
{
    $metin = str_replace("&", "", $metin);
    $metin = str_replace("#", "", $metin);
    $metin = str_replace("%", "", $metin);
    $metin = str_replace("\n", "", $metin);
    $metin = str_replace("\r", "", $metin);
    $metin = str_replace("'", "`", $metin);
    //$metin = str_replace('"', '�', $metin);
    $metin = str_replace("\\", "|", $metin);
    $metin = str_replace("<", "�", $metin);
    $metin = str_replace(">", "�", $metin);
    $metin = iconv( "UTF-8", "ISO-8859-9",trim(htmlentities($metin)));
    return $metin;
}
/*
getUserIDcomment:
kullan�c�n�n kendi kimlikleri
*/
function getUserIDcomment($usernam, $passwor)
{
	global $yol1;
	
	$usernam = substr(temizle2($usernam),0,15);
    $sql1 = "SELECT id, userName, userPassword FROM eo_users where userName='".temizle2($usernam)."' AND userPassword='".temizle2($passwor)."' limit 0,1"; 	

    $result1 = mysql_query($sql1, $yol1); 

    if ($result1 && mysql_numrows($result1) == 1)
    {
       return (mysql_result($result1, 0, "id"));
    }else {
	   return ("");
	}
}
/*
yorumSil:
belli bir yorumun silinmesi
*/
function yorumSil($yorumID){
	global $yol1;						
		
	$sql2 = "delete from eo_comments where id='$yorumID'"; 

	$result2 = mysql_query($sql2, $yol1); 
	return $result2;
}

if (isset($_GET['id']) 	&& !empty($_GET['id']) 
						&& getUserIDcomment($_SESSION["usern"],$_SESSION["userp"])!="") {
	if (yorumSil(temizle2($_GET['id'])))
		echo iconv( "ISO-8859-9","UTF-8",$metin[309]);
		else
		echo "Error!";
} else {
   echo "";
   }

?>