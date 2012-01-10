<?php
session_start();
if ( (int)$_SESSION["rights"] < 2 )
{
	echo $_GET["target"] . "[-END-]Session timeout! Try to login again.";
}
else
{
	include( "config.php" );
?>
<?=$_GET["target"]?>[-END-]
<?php
	if ( $_GET["action"] == "visible"  && $_SESSION["demo"] != TRUE )
	{
		$record["visible"] = "YES";
		$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = ' . (int)$_SESSION["userId"] ); 
?>
<span onMouseOver="document.synlig.src='<?=$baseUrl?>/img/symbols/gif_red/synlig.gif'" onMouseOut="document.synlig.src='<?=$baseUrl?>/img/symbols/gif_purple/synlig.gif'"><a  href="#noexist" onClick="getContent('visible_invisible.php?target=visibleInvisible&action=invisible');" style="font-weight: normal"><img src="<?=$baseUrl?>/img/symbols/gif_purple/synlig.gif" border="0" style="vertical-align:middle;" name="synlig" >&nbsp;&nbsp;Jag &auml;r: <span class="current">Synlig</span> / Osynlig</a></span>
<?php
	}
	elseif ( $_GET["action"] == "invisible"  && $_SESSION["demo"] != TRUE )
	{
		$record["visible"] = "NO";
		$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = ' . (int)$_SESSION["userId"] );
?>
<span onMouseOver="document.synlig.src='<?=$baseUrl?>/img/symbols/gif_red/osynlig.gif'" onMouseOut="document.synlig.src='<?=$baseUrl?>/img/symbols/gif_purple/osynlig.gif'"><a  href="#noexist" onClick="getContent('visible_invisible.php?target=visibleInvisible&action=visible');" style="font-weight: normal"><img src="<?=$baseUrl?>/img/symbols/gif_purple/soynlig.gif" border="0" style="vertical-align:middle;" name="synlig" >&nbsp;&nbsp;Jag &auml;r: Synlig / <span class="current">Osynlig</span></a></span><?php		
	}
}
?>