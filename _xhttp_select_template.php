<?php
session_start();
if ( (int)$_SESSION["rights"] < 6 )
{
	echo $_GET["target"] . "[-END-]Session timeout! Try to login again.";
}
else
{
?>
<?=$_GET["target"]?>[-END-]
<?php
	include( "config.php" );

	if ( $_GET["action"] == "select" )
	{
		echo "<form style=\"padding: 0px; margin: 0px\">\n";
		if ( addslashes( $_GET["type"] ) == "invite" )
		{
			echo "<select onChange=\"location='" . $baseUrl . "/admin_invite.html?templateId=' + this.value\">\n";
			$q = "SELECT * FROM fl_templates WHERE templateType = '" . addslashes( $_GET["type"] ) . "' AND active = 'YES' ORDER BY name, insDate ASC";
		}
		elseif ( addslashes( $_GET["type"] ) == "newsletter" )
		{
			echo "<select onChange=\"location='" . $baseUrl . "/admin_newsletter.html?templateId=' + this.value\">\n";
			$q = "SELECT * FROM fl_templates WHERE templateType = '" . addslashes( $_GET["type"] ) . "' AND active = 'YES' ORDER BY name, insDate ASC";
		}
		elseif ( addslashes( $_GET["type"] ) == "confirmEmail" || addslashes( $_GET["type"] ) == "welcomeEmail" || addslashes( $_GET["type"] ) == "resetPassword" || addslashes( $_GET["type"] ) == "newPassword" || addslashes( $_GET["type"] ) == "newSubscriber" || addslashes( $_GET["type"] ) == "newSubscriberFriend" )
		{
			echo "<select onClick=\"getContent('select_template.php?target=" . $_GET["type"] . "&action=save&type=" . $_GET["type"] . "&templateId=' + this.value + '')\">\n";
			$q = "SELECT * FROM fl_templates WHERE templateType = 'email' AND active = 'YES' ORDER BY name, insDate ASC";
		}
		echo "<option value=\"\">--</option>\n";

		$row = $DB->GetAssoc( $q, FALSE, TRUE );
		if ( count( $row ) > 0 )
		{
			while ( list( $key, $value ) = each ( $row ) )
			{
?>
<option value="<?=$row[ $key ]["id"]?>"<?php echo ( $row[ $key ]["id"] == $_GET["templateId"] ) ? " selected":""; ?>><?=htmlentities( $row[ $key ]["name"] )?></option>
<?php
			}
		}
		echo "</select>\n</form>\n";
	}
	elseif ( $_GET["action"] == "save" )
	{
		$record = array();
		$record["insDate"] = date( "Y-m-d H:i:s" );
		$record["value"] = $_GET["templateId"];

		$q = "SELECT * FROM fl_configuration WHERE type = '" . addslashes( $_GET["type"] ) . "' LIMIT 0,1";
		$row = $DB->GetRow( $q, FALSE, TRUE );
		if ( count( $row ) > 0 )
		{
			$DB->AutoExecute( "fl_configuration", $record, 'UPDATE', "type = '" . $_GET["type"] . "'" );
		}
		else
		{
			$record["type"] = $_GET["type"];			
			$DB->AutoExecute( "fl_configuration", $record, 'INSERT' );
		}

		$q = "SELECT * FROM fl_templates WHERE templateType = 'email' AND id = " . (int)$_GET["templateId"] . " AND active = 'YES'";
		if ( $row = $DB->GetRow( $q ) )
		{
			$body= "<a href=\"#noexist\" onClick=\"getContent('select_template.php?target=" . $_GET["type"] . "&type=" . $_GET["type"] . "&action=select&templateId=" . (int)$_GET["templateId"] . "');\">" . htmlentities( $row["name"] ) . " - " . $row["insDate"] . "</a> <a href=\"" . $baseUrl . "/admin_template.html?templateId=" . (int)$_GET["templateId"] . "&type=" . $_GET["type"] . "\" onClick=\"openPopup(this.href,'admin_" . $_GET["type"] . "_template" . (int)$_GET["templateId"] . "', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/edit.gif\" border=\"0\" alt=\"Redigera mall\"></a> <a href=\"" . $baseUrl . "/admin_delete_template.html?templateId=" . (int)$_GET["templateId"] . "\" OnClick=\"if(confirm('Ta bort " . $row["name"] . "?')) { document.location=this.href; } else { return false; }\"><img src=\"" . $baseUrl . "/img/delete.png\" border=\"0\" alt=\"Ta bort mall\"></a> <a href=\"" . $baseUrl . "/admin_template.html?type=" . $_GET["type"] . "\" onClick=\"openPopup(this.href,'admin_" . $_GET["type"] . "_template', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/new.png\" border=\"0\" alt=\"Ny mall\"></a>\n";
		}
		else
		{
			$body= templateLink( "email", $_GET["type"] );
		}
		echo $body;

	}
}
?>