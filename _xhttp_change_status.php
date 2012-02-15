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
	if ( strlen( $_GET["status"] ) < 1  || $_SESSION["demo"] == TRUE  )
	{
?>
<form name="form" style="margin: 0px; padding: 0px" onsubmit="return false">
<img src="<?=$baseUrl?>/img/symbols/gif_red/logga_in.gif" border="0" align="ABSMIDDLE" name="changeStatus" /> <input type="text" name="status" value="Ange din status" onfocus="changeValueTemp(this);" onkeypress="return onEnter(event, 'change_status.php?target=<?=$_GET["target"]?>&type=<?=$_GET["type"]?>&status='+this.value, this);" onblur="getContent('change_status.php?target=<?=$_GET["target"]?>&type=<?=$_GET["type"]?>&status='+this.value);" />
</form>
<?php
	}
	else
	{
		$record = array();
		$record["insDate"] = date("Y-m-d H:i:s");
		$record["userId"] = (int)$_SESSION["userId"];
		$record["statusMessage"] = addslashes( htmlentities( $_GET["status"]) );
		$record["statusType"] = "personalMessage";
		$record["mostRecent"] = "YES";
		$DB->AutoExecute( "fl_status", $record, 'INSERT' );

		$record = array();
		$record["mostRecent"] = "NO";
		$DB->AutoExecute( "fl_status", $record, 'UPDATE', 'id != ' . $DB->Insert_ID() . ' AND userId = ' . (int)$_SESSION["userId"] . ' AND statusType = "personalMessage"' );

		if ( $_GET["type"] == "onlyMessage" )
		{
			echo "<span id=\"updatedStatus\" onMouseOver=\"document.changeStatus.src='" . $baseUrl . "/img/symbols/gif_red/logga_in.gif'\" onMouseOut=\"document.changeStatus.src='" . $baseUrl . "/img/symbols/gif_purple/logga_in.gif'\"><a href=\"#noexist\" onClick=\"getContent('change_status.php?target=updatedStatus&type=onlyMessage');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/logga_in.gif\" border=\"0\" align=\"ABSMIDDLE\" name=\"changeStatus\" />&nbsp;&nbsp;Status: " . stripslashes( htmlentities( $_GET["status"]) ) . "</a></span>";
		}
		else
		{
			echo "<a href=\"#noexist\" onClick=\"getContent('change_status.php?target=statusMessage');\" style=\"font-weight: normal\">" . stripslashes( htmlentities( $_GET["status"]) ) . "</a><br /><div class=\"email_date\" style=\"display:inline\">Uppdaterat nyss</div>";
		}
	}
}
?>