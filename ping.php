<script language="javascript" type="text/javascript" src="lib/jquery.ping.js"></script>
<script type="text/javascript">
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
/*
pingTest:
sayfadan sunucuya ping testi
*/
$(document).ready(function (){
	$('#pingTest').ping({
		interval : 3, 
		unit : ''   
	});
});
</script>

<img id="pingTest" src="img/loadingRect2.gif" alt="ping" title="ping" style="vertical-align: middle;" />