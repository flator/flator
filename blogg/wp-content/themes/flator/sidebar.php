</div><div id="right">

<div style="padding-bottom: 4px; border-bottom: 1px dotted #c8c8c8;"><h3 style="color: #645d54">Logga in</h3></div>
<form name="loginform" method="post" action="http://www.flator.se" style="padding: 0px; margin: 0px" id="loginform">

<p><label class="login" for="username" style="font-size:9px">Användarnamn:</label> <input type="text" id="username" name="username" style="float:right; height:20px; font-size:13px; border:solid 1px #aa567a;filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;background-color:#fff;width:130px; margin:0px; padding:2px;"></p>
<div style="clear:both;"></div>
<p><label class="login" for="password" style="font-size:9px">Lösenord:</label> <input type="password" id="password" name="password" style="float:right; height:20px; font-size:13px; border:solid 1px #aa567a;filter:alpha(opacity=70);-moz-opacity:.70;opacity:.70;background-color:#fff;width:130px; margin:0px; padding:2px;"></p>
<div style="float:right; margin-top:10px;">
<span onMouseOver="document.getElementById('loginButton').src='http://www.flator.se/img/logga_in_active.gif'" onMouseOut="document.getElementById('loginButton').src='http://www.flator.se/img/logga_in.gif'">
<INPUT TYPE="IMAGE" SRC="http://www.flator.se/img/logga_in.gif" ALT="Logga in"  id="loginButton">
</span></div>
<div style="clear:both;"></div>
<div style="float:right; margin-top:10px;">
<a href="http://www.flator.se/reset_password.html" style="font-weight:normal; font-size:10px">Har du glömt ditt lösenord?</a></div>
</form>
<br><br>
<br>


<div style="padding-bottom: 4px; border-bottom: 1px dotted #c8c8c8;"><h3 style="color: #645d54">Skapa konto</h3></div>
<p>Vill du bli medlem på Flator.se? <a href="http://www.flator.se/register.html">Skapa konto h&auml;r!</a></p>

<br>
<div style="padding-bottom: 4px; border-bottom: 1px dotted #c8c8c8; margin-top:0px;"><h3 style="color: #645d54">flator.se <span style="font-weight: normal">för att</span></h3></div>
<table border="0" width="100%" cellpadding="0" cellspacing="0" style="font-size: 12px; margin-bottom: 20px; font-weight: normal"> <tr>
	<td align="left" valign="middle" style="line-height: 8px" >&nbsp;</td>
 </tr> <tr>
	<td align="left" valign="middle" style="line-height: 20px" class="colorText"><img src="http://www.flator.se/img/symbols/gif_purple/sok.gif" border="0" style="vertical-align:middle;" name="keepConnected">&nbsp;&nbsp;Umgås och hitta flator online</td>
 </tr> <tr>
	<td align="left" valign="middle" style="line-height: 20px" class="colorText"><img src="http://www.flator.se/img/symbols/gif_purple/bjud_in_vanner.gif" border="0" style="vertical-align:middle;" name="events">&nbsp;&nbsp;Events för flator</td>
 </tr> <tr>
	<td align="left" valign="middle" style="line-height: 20px" class="colorText"><img src="http://www.flator.se/img/symbols/gif_purple/tipsa_om_flator_se.gif" border="0" style="vertical-align:middle;" name="partyImages">&nbsp;&nbsp;Festbilder</td>
 </tr> <tr>
	<td align="left" valign="middle" style="line-height: 20px" class="colorText"><img src="http://www.flator.se/img/symbols/gif_purple/chat.gif" border="0" style="vertical-align:middle;" name="videoChat">&nbsp;&nbsp;Videochat</td>
 </tr> <tr>
	<td align="left" valign="middle" style="line-height: 20px" class="colorText"><img src="http://www.flator.se/img/symbols/gif_purple/blogg.gif" border="0" style="vertical-align:middle;" name="videoChat">&nbsp;&nbsp;Blogga</td>
 </tr> <tr>
	<td align="left" valign="middle" style="line-height: 20px" class="colorText"><img src="http://www.flator.se/img/symbols/gif_purple/grupp.gif" border="0" style="vertical-align:middle;" name="sharePhotos">&nbsp;&nbsp;Dela foton & filmklipp</td>
 </tr> <tr>
	<td align="left" valign="middle" style="line-height: 20px" class="colorText"><img src="http://www.flator.se/img/symbols/gif_purple/mest_sedda.gif" border="0" style="vertical-align:middle;" name="chooseFriends">&nbsp;&nbsp;Synlig / osynlig</td>
 </tr> <tr>
	<td align="left" valign="middle" style="line-height: 20px" class="colorText"><img src="http://www.flator.se/img/symbols/gif_purple/flort.gif" border="0" style="vertical-align:middle;" name="flirt">&nbsp;&nbsp;Flörta i hemlighet</td>
 </tr> <tr>
	<td align="left" valign="middle" style="line-height: 20px" class="colorText"><img src="http://www.flator.se/img/symbols/gif_purple/annonser_erbjudanden.gif" border="0" style="vertical-align:middle;" name="flirt">&nbsp;&nbsp;Diskutera på forumet</td>
 </tr></table>

		 <div class="sideblock">
<h3>Kategorier</h3>

<ul>

<?php wp_list_cats('sort_column=name&hierarchical=0'); ?>

</ul>

</div>
 <div class="sideblock">
 
 <h3>Arkiv</h3>

<ul>

<?php wp_get_archives('type=monthly'); ?>

</ul>
</div>

 </div>