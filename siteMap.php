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
ob_start (); // Buffer output
    session_start (); 
    $_SESSION ['ready'] = TRUE; 
  require("conf.php");  		
  $time = getmicrotime();
  checkLoginLang(false,true,"siteMap.php");	   

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
	<title>eOgr -<?php echo $metin[547]?></title>
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
	</head>
	<body>
    <?php require("menu.php");?>
    <div class="container">
      <div class="col-lg-12">
        <h2 class="PostHeaderIcon-wrapper"> <span class="PostHeader"><img src="img/logo1.png" border="0" style="vertical-align: middle;" alt="main" title="<?php echo $metin[286]?>"/> - <?php echo $metin[547]?> </span></h2>
        <p>
        <?php printf($metin[550],'<img src="img/imp_1.gif" border="0" style="vertical-align: middle;" alt="new" />','<img src="img/imp_2.gif" border="0" style="vertical-align: middle;" alt="newish" />','<img src="img/imp_3.gif" border="0" style="vertical-align: middle;" alt="not so new" />');?>
        </p>
        <div class="PostContent">
          <?php
	$imge1 =  ' <img src="img/imp_1.gif" border="0" style="vertical-align: baseline;" alt="new" />';
	$imge2 =  ' <img src="img/imp_2.gif" border="0" style="vertical-align: baseline;" alt="newish" />';
	$imge3 =  ' <img src="img/imp_3.gif" border="0" style="vertical-align: baseline;" alt="not so new" />';

		if(sonTarihGetir("sohbet",0))
		  	$bilgi1 = $imge1;
		elseif(sonTarihGetir("sohbet",1))
			$bilgi1 = $imge2;  
		elseif(sonTarihGetir("sohbet",2))
			$bilgi1 = $imge3;  
		else
			$bilgi1 = "";

		if(sonTarihGetir("yorum",0))
		  	$bilgi2 = $imge1;
		elseif(sonTarihGetir("yorum",1))
			$bilgi2 = $imge2;  
		elseif(sonTarihGetir("yorum",2))
			$bilgi2 = $imge3;  
		else
			$bilgi2 = "";

		if(sonTarihGetir("oy",0))
		  	$bilgi3 = $imge1;
		elseif(sonTarihGetir("oy",1))
			$bilgi3 = $imge2;  
		elseif(sonTarihGetir("oy",2))
			$bilgi3 = $imge3;  
		else
			$bilgi3 = "";

		if(sonTarihGetir("ders",0))
		  	$bilgi4 = $imge1;
		elseif(sonTarihGetir("ders",1))
			$bilgi4 = $imge2;  
		elseif(sonTarihGetir("ders",2))
			$bilgi4 = $imge3;  
		else
			$bilgi4 = "";

		if(sonTarihGetir("uye",0))
		  	$bilgi5 = $imge1;
		elseif(sonTarihGetir("uye",1))
			$bilgi5 = $imge2;  
		elseif(sonTarihGetir("uye",2))
			$bilgi5 = $imge3;  
		else
			$bilgi5 = "";

		if(sonTarihGetir("dosya",0))
		  	$bilgi6 = $imge1;
		elseif(sonTarihGetir("dosya",1))
			$bilgi6 = $imge2;  
		elseif(sonTarihGetir("dosya",2))
			$bilgi6 = $imge3;  
		else
			$bilgi6 = "";

		if(sonTarihGetir("haber",0))
		  	$bilgi7 = $imge1;
		elseif(sonTarihGetir("haber",1))
			$bilgi7 = $imge2;  
		elseif(sonTarihGetir("haber",2))
			$bilgi7 = $imge3;  
		else
			$bilgi7 = "";

		if(sonTarihGetir("islem",0))
		  	$bilgi8 = $imge1;
		elseif(sonTarihGetir("islem",1))
			$bilgi8 = $imge2;  
		elseif(sonTarihGetir("islem",2))
			$bilgi8 = $imge3;  
		else
			$bilgi8 = "";

		if(sonTarihGetir("calis",0))
		  	$bilgi9 = $imge1;
		elseif(sonTarihGetir("calis",1))
			$bilgi9 = $imge2;  
		elseif(sonTarihGetir("calis",2))
			$bilgi9 = $imge3;  
		else
			$bilgi9 = "";

		if(sonTarihGetir("arkadas",0))
		  	$bilgi10 = $imge1;
		elseif(sonTarihGetir("arkadas",1))
			$bilgi10 = $imge2;  
		elseif(sonTarihGetir("arkadas",2))
			$bilgi10 = $imge3;  
		else
			$bilgi10 = "";

		if(sonTarihGetir("soru",0))
		  	$bilgi11 = $imge1;
		elseif(sonTarihGetir("soru",1))
			$bilgi11 = $imge2;  
		elseif(sonTarihGetir("soru",2))
			$bilgi11 = $imge3;  
		else
			$bilgi11 = "";
?>
          <div class="row">
            <div class="col-lg-3">
              <ul>
                <li><img src="img/user_manager.gif" border="0" style="vertical-align: middle;" alt="<?php echo $metin[551]?>"/> <?php echo $metin[551]?>
                  <ul style="list-style:none">
                    <li><a href="index.php"><img src="img/home.png" border="0" style="vertical-align: middle;" alt="main"/> <?php echo $metin[54]?></a> </li>
                    <li><a href="lessonsList.php"><span><span><img src="img/lessons.gif" border="0" style="vertical-align: middle;" alt="lessons"/> <?php echo $metin[55].$bilgi4?> </span></span></a> </li>
                    <li><a href="newUser.php"><span><span><img src="img/user_add.gif" border="0" style="vertical-align: middle;" alt="userman"/> <?php echo $metin[64]?> </span></span></a></li>
                    <li><a href="passwordRemember.php"><span><span> <?php echo $metin[65]?> </span></span></a></li>
                    <li><a href="rss.php"><span><span> <?php echo $metin[153].$bilgi7?></span></span></a></li>
                    <li> <a href="help.php" target="_blank" onclick="window.open('help.php');return false;" ><img src="img/help.png" border="0" style="vertical-align:middle;" alt="<?php echo $metin[243]?>" title="<?php echo $metin[243]?>" /> <?php echo $metin[243]?></a></li>
                    <li><a href="siteMap.php"><span><span><img src="img/sitemap.png" border="0" style="vertical-align:middle;" alt="<?php echo $metin[547]?>" title="<?php echo $metin[547]?>" /> <?php echo $metin[547]?></span></span></a></li>
                  </ul>
              </ul>
            </div>
            <div class="col-lg-3">              
              <ul style="list-style:none">
                <li><img src="img/ogr_user.png" border="0" style="vertical-align: middle;" alt="<?php echo $metin[94]?>"/> <?php echo $metin[94]?>
                  <ul style="list-style:none">
                    <li><a href="login.php"><span><span><img src="img/mainPage.gif" border="0" style="vertical-align: middle;" alt="login"/> <?php echo $metin[60]?></span></span></a></li>
                    <li><a href="kursDetay.php"><img src="img/course.gif" border="0" style="vertical-align:middle;" alt="kurs" /> <span><span> <?php echo $metin[461]?></span></span></a></li>
                    <li><a href="stats.php"><span><span> <?php echo $metin[197]?></span></span></a></li>
                    <li><a href="friends.php"><span><span><img src="img/users.png" border="0" style="vertical-align: middle;" alt="users"/> <?php echo $metin[549]?></span></span></a></li>
                    <li><a href="fileShare.php"><span><span> <?php echo $metin[463].$bilgi6?></span></span></a></li>
                    <li><a href="askQuestion.php"><span><span><img src="img/question.png" border="0" style="vertical-align:middle" alt="<?php echo $metin[628]?>"/> <?php echo $metin[628].$bilgi11?> </span></span></a></li>
                    <?php
  if($seceneklerimiz[10]=="1" and $kullaniciSecen[10]=="1"){
	echo ("<li><a href=\"chat.php\" target='_blank' onclick=\"window.open(&quot;chat.php&quot;,&quot;chat&quot;,&quot;width=590,height=400,top=100,left=100,toolbar=0,location=0,menubar=0,copyhistory=0,status=0,resizable=yes,scrollbars=yes,directories=0&quot;);return false;\"><span><span><img src=\"img/comment.gif\" border=\"0\" style=\"vertical-align: middle;\" alt=\"chat\"/> ".$metin[56].$bilgi1."</span></span></a></li>");
  }
?>
                    <li><a href="userSettings.php"><span><span><img src="img/user_manager.gif" border="0" style="vertical-align: middle;" alt="userman"/> <?php echo $metin[57]?> </span></span></a> </li>
                  </ul>
                </li>
              </ul>             
            </div>
            <div class="col-lg-3">
              <ul style="list-style:none">
                <li><img src="img/ogrt_user.png" border="0" style="vertical-align: middle;" alt="<?php echo $metin[95]?>"/> <?php echo $metin[95]?>
                  <ul style="list-style:none">
                    <li><a href="lessonsEdit.php"><span><span> <?php echo $metin[62].$bilgi4?></span></span></a></li>
                    <li><?php echo $metin[185];?>
                      <ul style="list-style:none">
                        <li><a href="dataWorkList.php"><span><span> <?php echo $metin[186].$bilgi9?></span></span></a></li>
                        <li><a href="dataRatingList.php"><span><span> <?php echo $metin[287].$bilgi3?> </span></span></a></li>
                        <li><a href="dataChatActions.php"><span><span> <?php echo $metin[67].$bilgi1?> </span></span></a></li>
                        <li><a href="dataCommentList2.php"><span><span> <?php echo $metin[288].$bilgi2?></span></span></a></li>
                      </ul>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
            <div class="col-lg-3">
              <ul style="list-style:none">
                <li><img src="img/admin_user.png" border="0" style="vertical-align: middle;" alt="<?php echo $metin[96]?>"/> <?php echo $metin[96]?>
                  <ul style="list-style:none">
                    <li><a href="siteNotices.php"><span><span><img src="img/admin.gif" border="0" style="vertical-align: middle;" alt="admin"/> <?php echo $metin[471]?> </span></span></a></li>
                    <li><a href="siteSettings.php"><span><span> <?php echo $metin[472].$bilgi5?> </span></span></a></li>
                    <li><a href="siteSettings2.php"><span><span><img src="img/database.gif" border="0" style="vertical-align: middle;" alt="install"/> <?php echo $metin[156]?> </span></span></a></li>
                    <li><a href="siteSettings3.php"><span><span> <?php echo $metin[112]?> </span></span></a></li>
                    <li><a href="rssEdit.php"><span><span> <?php echo $metin[70].$bilgi7?> </span></span></a> </li>
                    <li><?php echo $metin[185];?>
                      <ul style="list-style:none">
                        <li><a href="dataActions.php"><span><span> <?php echo $metin[66].$bilgi8?> </span></span></a></li>
                        <li><a href="dataWorkList2.php"><span><span> <?php echo $metin[186].$bilgi9?> </span></span></a></li>
                        <li><a href="dataRatingList.php"><span><span> <?php echo $metin[287].$bilgi3?> </span></span></a></li>
                        <li><a href="dataChatActions.php"><span><span> <?php echo $metin[67].$bilgi1?> </span></span></a></li>
                        <li><a href="dataCommentList.php"><span><span> <?php echo $metin[288].$bilgi2?></span></span></a></li>
                        <li><a href="dataFriendActions.php"><span><span> <?php echo $metin[594].$bilgi10?></span></span></a></li>
                      </ul>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>            
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
</body>
</html>
<?php
 mysqli_close($yol);
 mysqli_close($yol1);
?>