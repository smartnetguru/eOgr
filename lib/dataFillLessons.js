/*
lessons.php AJAX engine is here

This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 3 of the License, or any later version. See the GNU
Lesser General Public License for more details.
*/
// Get the HTTP Object
/*
getHTTPObject:
Ajax nesnesinin haz&#305;rlanmas&#305;
*/
function getHTTPObject(){
  var xmlhttp = null;
  if (window.XMLHttpRequest) {
   xmlhttp = new XMLHttpRequest();
   	    if (xmlhttp.overrideMimeType) {
            xmlhttp.overrideMimeType('text/xml; charset=UTF-8');
         }
  } else if(window.ActiveXObject) {
   try {
    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
   } catch (e) {
    try {
     xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e) {
	 alert("Your browser does not support AJAX.");
     xmlhttp = null;
    }
   }
  }
  return xmlhttp;		 
} 
/*
bitirmeYuzdesi:
ders &ccedil;al&#305;&#351;mada ilerleme &ccedil;ubu�unun de�erinin bulunmas&#305;
*/
function bitirmeYuzdesi(){
	return parseInt(document.getElementById('sonSayfaHidden').value) * 100 / parseInt(document.getElementById('sayfaSayisi').innerHTML);
}
/*
sureDolduTemizle:
genel olarak ders sayfas&#305;ndaki b�l&uuml;mlerin temizlenmesi
*/
function sureDolduTemizle(){
		//$("#calismaSuresi").stopTime();
		$("#cevapSuresi").stopTime();
		window.clearTimeout(timeoutId);
				
        document.getElementById('anaMetin').innerHTML =   "<font id='hata'>�z&uuml;r dileriz, s&uuml;reniz dolmu&#351; veya sayfa ge&ccedil; y&uuml;kleniyor olabilir.<p>Sayfay&#305; <a href='lessons.php?konu="+document.getElementById('konu_id').value+"'>yenilemeyi</a> deneyiniz veya <a href='index.php'>oturum</a> a&ccedil;&#305;n&#305;z.</p></font>";          
		document.getElementById('eklenmeTarihi').innerHTML =  "-";		
		document.getElementById('hazirlayan').innerHTML =   "-";
		document.getElementById('sayfaSayisi').innerHTML =  "-";		
		document.getElementById('konuAdi').innerHTML =   "-";
		document.getElementById('soruGeriSayim').innerHTML =   "";		
		document.getElementById('sonrakiKonu').innerHTML =   "";		
		document.getElementById('oncekiKonu').innerHTML =  "";		
		document.getElementById('cevapSuresi').innerHTML = '' ;
		document.getElementById('gercekCevapSuresi').innerHTML =   "";		
		document.getElementById('slideGecisSuresi').innerHTML =   "";		
		document.getElementById('sayfaNo').innerHTML =  "-";
		document.getElementById('calismaSuresi').innerHTML =  "-";
		document.getElementById('bitirmeYuzdesi').innerHTML =  "";
		document.getElementById('geriDugmesi').innerHTML  ='';
		document.getElementById('ileriDugmesi').innerHTML ='';
		document.getElementById('konuAdi').innerHTML =   "-";
		document.getElementById('konu_id').value =   "";
		document.getElementById('cevapVer').style.visibility = 'hidden' ;
		document.getElementById('sunuDurdur').style.visibility = 'hidden';
		document.getElementById('yukleniyor').style.visibility = "hidden";
		if (document.getElementById("hata")!=null) fadeUp(document.getElementById("hata"),255,0,0,150,0,0);
}

var timeoutId = null;
var connectionTimeout = 60000; // 60sec 
var items = new Array(); 		//ders sayfalar&#305; bilgileri

//http://www.netlobo.com/url_query_string_javascript.html
function gup( name )
{
  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regexS = "[\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp( regexS );
  var results = regex.exec( window.location.href );
  if( results == null )
    return "";
  else
    return results[1];
}
/*
setOutputOda:
i&ccedil;i bo&#351; fonksiyon
*/
function setOutputOda(){
}
/*
replaceNbsps:
konudaki nbsp karakteri problemi � 
*/
function replaceNbsps(str) {
  //var re = new RegExp(String.fromCharCode(160), "g");
  return str.replace(/�/g, " ");  
}
/*
setOutputKonu:
konudaki bilgilerin ekrana getirilmesi
*/
function setOutputKonu(sayfaNo, konu, noCount){

	if(noCount === undefined) noCount=0;

		window.clearTimeout(timeoutId);
		document.getElementById('yukleniyor').style.visibility = "hidden";
		
		//alert("3- setOutpuKonu " + sayfaNo + " " + items.length);
		
		if(items.length!=15 || items=="1"){//bazen sadece 1 geliyor...
			//return; //exit function
		}

		var birSayi, kayitSayisi, yuzdesi;
		var eskiYeri;		

		document.getElementById('cevapVer').style.visibility = 'hidden' ;
		document.getElementById('ileriGeri').style.visibility = 'visible' ;
		document.getElementById('cevapSuresi').style.visibility = 'hidden' ;
		document.getElementById('sunuDurdur').style.visibility = 'hidden';
		
		var dersAnaMetni = items[0];
		document.getElementById('anaMetin').innerHTML = replaceNbsps(dersAnaMetni);                 

		$("#anaMetin").animate( {  "opacity": "show" }, { queue:true, duration:200 } );

		document.getElementById('anaMetin').tabindex = -1;
		document.getElementById('anaMetin').focus();
		//eri&#351;ilebilirlik
		
		document.getElementById('aktifKonuNo').innerHTML =   items[12];          		
		document.getElementById('gercekCevapSuresi').innerHTML =   items[13];          
		document.getElementById('slideGecisSuresi').innerHTML =   items[14];          
		
		document.getElementById('eklenmeTarihi').innerHTML =  items[1];		
		document.getElementById('hazirlayan').innerHTML =   items[2];
		document.getElementById('sayfaSayisi').innerHTML =  items[3];		
		kayitSayisi = items[3];
		document.getElementById('konuAdi').innerHTML =   items[5];

		if(items[7]=="-" || items[6]=="-" || items[7]=="" || items[6]=="0")
			document.getElementById('oncekiKonu').innerHTML =   "";		
			else
			document.getElementById('oncekiKonu').innerHTML =   "<a href='lessons.php?konu="+ items[6] +"&amp;mode="+gup("mode")+"'><span class=\"glyphicon glyphicon-menu-left btn btn-warning btn-xs\" aria-hidden=\"true\" title=\"" + items[7] + "\"></span></a>";		
		if(items[8]=="-" || items[9]=="-" || items[8]=="" || items[9]=="")
			document.getElementById('sonrakiKonu').innerHTML =   "";		
			else
			document.getElementById('sonrakiKonu').innerHTML =   "<a href='lessons.php?konu="+ items[8] +"&amp;mode="+gup("mode")+"'><span class=\"glyphicon glyphicon-menu-right btn btn-warning btn-xs\" aria-hidden=\"true\" title=\"" + items[9] + "\"></span></a>";		

		document.getElementById('konu_id').value = konu;		
		
		if (noCount==0){
			document.getElementById('calismaSuresi').innerHTML =  "-";
			$("#calismaSuresi").stopTime();
			if(items[3]>0) sayacTetik();
		}

			if(items[10]>0) {sayacTetik2(items[10]);}
			
			if(items[11]>0 && items[11]!="-") {//Soru varsa	
				document.getElementById('sayfa_id').value = items[11];
				document.getElementById('cevapLink').href = "soruCevapla.php?sayfa="+items[11];
				document.getElementById('cevapVer').style.visibility = 'visible' ;
				document.getElementById('ileriGeri').style.visibility = 'hidden' ;
				document.getElementById('cevapSuresi').style.visibility = 'visible' ;
				//if (document.getElementById("cevapVer")!=null) fadeUp(document.getElementById("cevapVer"),255,255,0,0,0,150);
				document.getElementById('cevapSuresi').innerHTML = '' ;
				$("#cevapSuresi").stopTime();//�nceki timer kapan&#305;r			
				}				
			else if(items[14]>0 && items[14]!="-") {//Slayt varsa	
				document.getElementById('sayfa_id').value = items[11];
				document.getElementById('cevapSuresi').style.visibility = 'visible' ;
				document.getElementById('cevapSuresi').innerHTML = items[14];
				//if (document.getElementById("cevapSuresi")!=null) fadeUp(document.getElementById("cevapSuresi"),0,255,0,0,0,150);
				$("#cevapSuresi").stopTime();//�nceki timer kapan&#305;r	
				sayacTetik3(items[14]);	
				document.getElementById('sunuDurdur').style.visibility = 'visible';	
				}
		
		document.getElementById('sayfaNo').innerHTML =  sayfaNo;
		document.getElementById('bitirmeYuzdesi').innerHTML =  "";
		
		eskiYeri = document.getElementById('sonSayfaHidden').value;		
		
		if (sayfaNo<eskiYeri) {
		  	yuzdesi = eskiYeri*100/kayitSayisi;
			}
		  else{
			yuzdesi = sayfaNo*100/kayitSayisi;
		  	document.getElementById('sonSayfaHidden').value=sayfaNo;
		  }
		
		if(yuzdesi == Number.NaN) 
		    document.getElementById('bitirmeYuzdesi').innerHTML =  "";
			else
			document.getElementById('bitirmeYuzdesi').innerHTML =  "<img src='img/progressbar.png' alt='progress' width='" + Math.round(yuzdesi) + "' height='5' border='0' title='%"+ Math.round(yuzdesi) +" ilerlediniz'/>";
		
		if (kayitSayisi>0) {
			if (sayfaNo<=1) {
				document.getElementById('geriDugmesi').innerHTML  ='';
			}else {
				birSayi = sayfaNo - 1;
				document.getElementById('geriDugmesi').innerHTML  ='<a href="#" onclick="konuSec2('+birSayi+',1);return false;"><img src="img/sayfa_l.png" border="0" style="vertical-align:middle" alt="left" title="Shortcut: Left Arrow (Klavye K&#305;sayolu: Sol Ok Tu&#351;udur)"/></a>';
			}
			if (sayfaNo>=kayitSayisi) 	{
				document.getElementById('ileriDugmesi').innerHTML ='';
			}else {
				birSayi = sayfaNo + 1;
				document.getElementById('ileriDugmesi').innerHTML ='<a href="#" onclick="konuSec2('+birSayi+',1);return false;"><img src="img/sayfa_r.png" border="0" style="vertical-align:middle" alt="right" title="Shortcut: Right Arrow (Klavye K&#305;sayolu: Sa&#287; Ok Tu&#351;udur)"/></a>';
				//konu se&ccedil;ili ise hint g�sterilebilir!
					var timeoutHint = null;
					var valTimeout = 10; 
					var timeoutHint2 = null;
					var valTimeout2 = 1000; 
					
				if(document.getElementById('ileriGeri').style.visibility == 'visible' 
				    && sayfaNo==1 && eskiYeri<1){
					
					window.clearTimeout(timeoutHint);
					window.clearTimeout(timeoutHint2);
					
					/*timeoutHint = window.setTimeout(function() {
						$('#hint').fadeIn(500,null);	 
						document.getElementById("hint").style.display = "inline";	
						 }, valTimeout);*/
					timeoutHint2 = window.setTimeout(function() { 
						//document.getElementById("hint").style.display = "none";	
						$('#hint').fadeOut(550,null);	 
						 }, valTimeout2);
				}else{
					window.clearTimeout(timeoutHint);
					window.clearTimeout(timeoutHint2);
					$('#hint').fadeOut(550,null);
				}

			}
		}
		else {
			document.getElementById('sayfaNo').innerHTML =  '-';
			document.getElementById('geriDugmesi').innerHTML  ='';
			document.getElementById('ileriDugmesi').innerHTML ='';
		    document.getElementById('bitirmeYuzdesi').innerHTML =  "";
//			document.getElementById('sonSayfaHidden').value=0;

		}

		fix_flash();
		document.getElementById('yukleniyor').style.visibility = "hidden";			
}
/*
sayacTetik:
sayfadaki &ccedil;al&#305;&#351;ma s&uuml;resinin &ccedil;al&#305;&#351;mas&#305;
*/
function sayacTetik()  {
					$("#calismaSuresi").everyTime(1000,function(i) {
						$(this).html(i);
						loginDurumu();
					});
};
/*
sayacTetik2:
cevap verme s&uuml;resinin &ccedil;al&#305;&#351;mas&#305;
*/ 
function sayacTetik2(sure)  {
					$("#soruGeriSayim").oneTime((sure*60) + "s",function() {																		
						//$("#calismaSuresi").stopTime();
						saveUserWork();//even if less then ignored limited time !!
						sureDolduTemizle();
					});
};
/*
sayacTetik3:
slayt ge&ccedil;i&#351; s&uuml;resinin &ccedil;al&#305;&#351;mas&#305;
*/ 
function sayacTetik3(sure)  {
	if(!document.sunum.sunuDurdur.checked)	
					$("#cevapSuresi").everyTime(1000,function(i) {
						$(this).html(sure-i);
						if(i==sure) {//slayt s&uuml;resi bitti ise sonraki sayfaya ge&ccedil;
						  $("#cevapSuresi").stopTime();
						  sayfa = document.getElementById('sayfaNo').innerHTML;
						  sonsayfa = document.getElementById('sayfaSayisi').innerHTML;
						  if(sayfa==sonsayfa)  
						    sayfa=1;
							else
 						    sayfa++;
						  konuSec2(sayfa,1);//1 normal zaman&#305; etkilememesi i&ccedil;indir						 						
						}
					});
};
/*
konuSec2:
alt se&ccedil;eneklerin oturumdan istenmesi
*/
function konuSec2(sayfaNo, noCount){    

	$('#hint').fadeOut(550,null);
//$("#anaMetin").delay(500).animate( { "opacity": "hide" }, { queue:true, duration:200 } );	
	if(noCount === undefined) noCount=0;	
	if(sayfaNo == "" || parseInt(sayfaNo)==0) {
		 return;
	}
				
	if(httpObject!=null) {//�nceki istek bitmeli
		httpObject.onreadystatechange = function(){};
		httpObject.abort;
	}
	
	delete httpObject;
	httpObject = getHTTPObject();
	
    if (httpObject != null && sayfaNo != "") {
		
		httpObject.open("POST", "getSubOption.php", true);
		httpObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
  		httpObject.send('sayfaNo=' + sayfaNo);
        httpObject.onreadystatechange = function() {
			
			if(httpObject.readyState != 4){
			//yukleniyor
			document.getElementById('yukleniyor').style.visibility = "visible";			
			window.clearTimeout(timeoutId);
			timeoutId = window.setTimeout(function() { 
											httpObject.onreadystatechange = function(){};
											httpObject.abort();          
											sureDolduTemizle();							                                        //alert("Connection timeout!\nBa�lant&#305; zaman a&#351;&#305;m&#305;!"); 
										}, connectionTimeout);		
			};	

			 if(httpObject.readyState == 4)
				 if(httpObject.status == 200 || httpObject.status == 304){			

					var response = httpObject.responseText;

					if(response==""){
						document.getElementById('anaMetin').innerHTML =   "<font id='hata'>Sayfa y&uuml;klenemedi!<p>Ba&#351;ka bir ders <a href='lessons.php'>se&ccedil;iniz</a>.</p></font>";
						return;
					}
					
					items = response.split("|");
					//bir sayfadaki temel ��eler
					
					document.getElementById("kapsayici").scrollTop = 0;
					document.getElementById("kapsayici").scrollLeft = 0;

					//de�erlerin i&#351;lenmesi i&ccedil;in alt programa gidelim
					setOutputKonu(sayfaNo, document.getElementById('konu_id').value, noCount);
					
					if (document.getElementById("navigation")!=null) fadeUp(document.getElementById("navigation"),255,255,154,255,255,150);
				 }
		}		
		
		if (document.getElementById("hata")!=null) fadeUp(document.getElementById("hata"),255,0,0,150,0,0);
		if (document.getElementById("uyari")!=null) fadeUp(document.getElementById("uyari"),0,0,255,0,0,150);
		if (document.getElementById("tamam")!=null) fadeUp(document.getElementById("tamam"),0,255,0,0,150,0);  
    }
}
/*
konuHazirla:
sayfa ilk acilis verileri alma
*/
function konuHazirla(konuNo){    
    httpObject2 = getHTTPObject();
    if (httpObject2 != null && konuNo>0) {
        httpObject2.open("POST", "getContent.php", true);
		httpObject2.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
  		httpObject2.send('konu='+encodeURIComponent(konuNo));
        httpObject2.onreadystatechange = function(){			
			if(httpObject2.readyState == 4 && (httpObject2.status == 200 || httpObject2.status == 304)){
				if(httpObject2.responseText.trim()=="OK")					
					konuSec2(1); //icerik geldi ve 1. sayfa secilir	
				 else
				    document.getElementById('anaMetin').innerHTML =   "<font id='hata'>Sayfalar y&uuml;klenemedi!<p>Ba&#351;ka bir ders <a href='lessons.php'>se&ccedil;iniz</a>.</p></font>";	
					
				}else{
					document.getElementById('anaMetin').innerHTML =   "<font id='uyari'>Sayfalar y&uuml;kleniyor!<p>Uzun s&uuml;r&uuml;yorsa sayfay&#305; <a href='lessons.php?konu="+document.getElementById('konu_id').value+"'>yenileyebilirsiniz</a>.</p></font>";
					}			
		};		
    }
}
/*
saveUserWork:
ders bitti�inde kullan&#305;c&#305;ya ders bilgisinin kaydedilmesi
*/
function saveUserWork(){ 
    httpObject3 = getHTTPObject();
    if (httpObject3 != null) {
        httpObject3.onreadystatechange = setOutputOda;		
        httpObject3.open("GET", "setUserWork.php?"+'konuID='+encodeURIComponent(document.getElementById('konu_id').value)+'&sure='+encodeURIComponent(document.getElementById('calismaSuresi').innerHTML)+'&sonSayfa='+encodeURIComponent(bitirmeYuzdesi()), false);
  		httpObject3.send(null);		
    }
}
/*
yorumGonder:
derse kullan&#305;c&#305;n&#305;n yorum eklemesi
*/
function yorumGonder(konuID, comment){    
    httpObject4 = getHTTPObject();
    if (httpObject4 != null) {
        httpObject4.open("POST", "addComment2.php", true);
		httpObject4.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
  		httpObject4.send('yorum='+encodeURIComponent(comment) + '&konu=' + encodeURIComponent(konuID));
        httpObject4.onreadystatechange = setOutputOda;		
    }
}
/*
setCevapSonuc:
soruya cevap verilmesi
*/
function setCevapSonuc(){
    if(httpObjectCevap.readyState == 4)
	 if(httpObjectCevap.status == 200 || httpObjectCevap.status == 304){
		document.getElementById('cevapSonucu').innerHTML = (httpObjectCevap.responseText);
		//gelen bilgide tick_circle yaz&#305;s&#305; kontrol ediliyor
		if(httpObjectCevap.responseText.indexOf("tick_circle")>0){	
 		 document.getElementById('ileriGeri').style.visibility = 'visible' ;
		 document.getElementById('cevapVer').style.visibility = "hidden";	
 		 document.getElementById('cevapDegerlendirmeYeri').style.visibility = "hidden";	
		 document.getElementById('cevapSuresi').innerHTML = '' ;
		 if (document.getElementById("cevapSonucu")!=null) fadeUp(document.getElementById("cevapSonucu"),0,255,0,0,150,0);
		 $("#cevapSuresi").stopTime();//�nceki timer kapan&#305;r			
		}else{
		 if (document.getElementById("cevapSonucu")!=null) fadeUp(document.getElementById("cevapSonucu"),255,0,0,150,0,0);
		}		 
    }
} 
/*
cevapDegerlendir:
gelen cevap de�erinin veritaban&#305;ndan kar&#351;&#305;la&#351;t&#305;r&#305;lmas&#305;
*/
function cevapDegerlendir(cevap, id){    
    httpObjectCevap = getHTTPObject();
    if (httpObjectCevap != null) {
        httpObjectCevap.open("POST", "soruCevapla2.php", true);
		httpObjectCevap.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
  		httpObjectCevap.send('cevap='+encodeURIComponent(cevap) + '&id=' + encodeURIComponent(id));
        httpObjectCevap.onreadystatechange = setCevapSonuc;		
    }
}
/*
cevapDegerlendir2:
gelen cevap de�erinin veritaban&#305;ndan kar&#351;&#305;la&#351;t&#305;r&#305;lmas&#305;, MULTIPLE CHOICE
*/
function cevapDegerlendir2(cevap, id){    
    httpObjectCevap = getHTTPObject();
    if (httpObjectCevap != null) {
        httpObjectCevap.open("POST", "soruCevapla3.php", true);
		httpObjectCevap.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
  		httpObjectCevap.send('cevap='+encodeURIComponent(cevap) + '&id=' + encodeURIComponent(id));
        httpObjectCevap.onreadystatechange = setCevapSonuc;		
    }
}
/*
trim:
sa� ve soldaki bo&#351;luklar&#305; siler
*/
function trim(stringToTrim)
{
	return stringToTrim.replace(/^\s+|\s+$/g,"");
}
/*
setOutputAll:
yaz&#305;c&#305; �nizlemesi yap&#305;m&#305;
*/
function setOutputAll(){	
    if(httpObject.readyState == 4)
	 if(httpObject.status == 200 || httpObject.status == 304){
		if(trim(httpObject.responseText)!="")
		  if(trim(httpObject.responseText)!="1") {			
			w=window.open('about:blank','onizleme','height=600,width=700,top=100,left=100,toolbar=no, location=no,directories=no,status=no,menubar=no,resizable=yes,scrollbars=yes');
			w.document.open();
			w.document.writeln("<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><html xmlns=\"http://www.w3.org/1999/xhtml\"><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />");
			w.document.write("<title>&Ouml;nizleme/Preview</title></head><body>" + httpObject.responseText);			
			w.document.writeln("</body></html>");
			w.document.close();
			}
	}
}
/*
printIt:
sayfalar&#305;n yazd&#305;r&#305;lmas&#305; i&ccedil;in bilgilerinin istenmesi
*/
function printIt()		{
    httpObject = getHTTPObject();
    if (httpObject != null) {
        httpObject.onreadystatechange = setOutputAll;
        httpObject.open("GET", "getSubOption2.php?"+'konuID='+encodeURIComponent(document.getElementById('konu_id').value), true);
  		httpObject.send(null);	
    }
}
/*
loginDurumu:
kay&#305;tl&#305; kullan&#305;c&#305;lar i&ccedil;in oturum a&ccedil;&#305;k oldu�unun kontrol edilmesi
*/
function loginDurumu(){	
    httpObject7 = getHTTPObject();
    if (httpObject7 != null) {
		konu = document.getElementById('konu_id').value;
        httpObject7.open("GET", "getDurum.php?konu="+encodeURIComponent(konu), true);
  		httpObject7.send(null);	
        httpObject7.onreadystatechange = function(){
			if(httpObject7.readyState == 4 && (httpObject7.status == 200 || httpObject7.status == 304)){
				if(httpObject7.responseText=="0"){					
					sureDolduTemizle();	 //oturum kapanm&#305;&#351; ise
					$("#calismaSuresi").stopTime();
					}
			}
		}			
    }
}

var httpObject = null;