<?php
$metaTitle = "Flator.se > Mallväljaren";
$numPerPage = 30;

if ( (int)$_SESSION["rights"] < 6 )
{
	$adminFooter = FALSE;
	$noLogo = TRUE;
	$adminMenu = FALSE;
	$loginUrl = $baseUrl . "/admin_templates.html";
	include( "login.php" );
}
else
{
	if ( strlen( $_GET["type"] ) > 0 )
	{
		$record = array();
		$record["insDate"] = date("Y-m-d H:i:s");
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
	}

	$configuration = array();
	$q = "SELECT * FROM fl_configuration";
	$row = $DB->GetAssoc( $q, FALSE, TRUE );
	if ( count( $row ) > 0 )
	{
		while ( list( $key, $value ) = each( $row ) )
		{
			$configuration[ $row[ $key ]["type"] ] = $row[ $key ]["value"];
		}
	}
	
	$body = "
<div id=\"content\">
	<div class=\"contentdiv\">

<h2>Mallväljaren</h2>

<p>Välj vilka mallar som skall användas för olika mailutskick och liknande. Du kan också skapa nya mallar. Var försiktig när du tar bort mallar så att dessa inte används av någon funktion.</p>

<p><div id=\"leftTutorial\" style=\"min-width: 250px\">Bekräfta e-postadress</div>
<div id=\"rightTutorial\"><div id=\"confirmEmail\">";

	$row = array();
	$q = "SELECT * FROM fl_templates WHERE templateType = 'email' AND id = " . (int)$configuration["confirmEmail"] . " AND active = 'YES'";
	if ( $row = $DB->GetRow( $q ) )
	{
		$body.= "<a href=\"#\" onClick=\"getContent('select_template.php?target=confirmEmail&type=confirmEmail&action=select&templateId=" . (int)$row["id"] . "');\">" . $row["name"] . " - " . $row["insDate"] . "</a> <a href=\"" . $baseUrl . "/admin_template.html?templateId=" . $row["id"] . "&type=confirmEmail\" onClick=\"openPopup(this.href,'admin_confirmEmail_template" . $row["id"] . "', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/edit.gif\" border=\"0\" alt=\"Redigera mall\"></a> <a href=\"" . $baseUrl . "/admin_delete_template.html?templateId=" . $row["id"] . "\" OnClick=\"if(confirm('Ta bort " . $row["name"] . "?')) { document.location=this.href; } else { return false; }\"><img src=\"" . $baseUrl . "/img/delete.png\" border=\"0\" alt=\"Ta bort mall\"></a> <a href=\"" . $baseUrl . "/admin_template.html?type=confirmEmail\" onClick=\"openPopup(this.href,'admin_confirmEmail_template', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/new.png\" border=\"0\" alt=\"Ny mall\"></a>\n";
	}
	else
	{
		$body.= templateLink( "email", "confirmEmail" );
	}
	
	$body.= "</div></div></p>

<p><div id=\"leftTutorial\" style=\"min-width: 250px\">Välkomstbrev</div>
<div id=\"rightTutorial\"><div id=\"welcomeEmail\">";

	$row = array();
	$q = "SELECT * FROM fl_templates WHERE templateType = 'email' AND id = " . (int)$configuration["welcomeEmail"] . " AND active = 'YES'";
	if ( $row = $DB->GetRow( $q ) )
	{
		$body.= "<a href=\"#\" onClick=\"getContent('select_template.php?target=welcomeEmail&type=welcomeEmail&action=select&templateId=" . (int)$row["id"] . "');\">" . $row["name"] . " - " . $row["insDate"] . "</a> <a href=\"" . $baseUrl . "/admin_template.html?templateId=" . $row["id"] . "&type=welcomeEmail\" onClick=\"openPopup(this.href,'admin_welcomeEmail_template" . $row["id"] . "', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/edit.gif\" border=\"0\" alt=\"Redigera mall\"></a> <a href=\"" . $baseUrl . "/admin_delete_template.html?templateId=" . $row["id"] . "\" OnClick=\"if(confirm('Ta bort " . $row["name"] . "?')) { document.location=this.href; } else { return false; }\"><img src=\"" . $baseUrl . "/img/delete.png\" border=\"0\" alt=\"Ta bort mall\"></a> <a href=\"" . $baseUrl . "/admin_template.html?type=welcomeEmail\" onClick=\"openPopup(this.href,'admin_welcomeEmail_template', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/new.png\" border=\"0\" alt=\"Ny mall\"></a>\n";
	}
	else
	{
		$body.= templateLink( "email", "welcomeEmail" );
	}
	
	$body.= "</div></div></p>

<p><div id=\"leftTutorial\" style=\"min-width: 250px\">Begärt lösenord/login</div>
<div id=\"rightTutorial\"><div id=\"resetPassword\">";

	$row = array();
	$q = "SELECT * FROM fl_templates WHERE templateType = 'email' AND id = " . (int)$configuration["resetPassword"] . " AND active = 'YES'";
	if ( $row = $DB->GetRow( $q ) )
	{
		$body.= "<a href=\"#\" onClick=\"getContent('select_template.php?target=resetPassword&type=resetPassword&action=select&templateId=" . (int)$row["id"] . "');\">" . $row["name"] . " - " . $row["insDate"] . "</a> <a href=\"" . $baseUrl . "/admin_template.html?templateId=" . $row["id"] . "&type=resetPassword\" onClick=\"openPopup(this.href,'admin_resetPassword_template" . $row["id"] . "', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/edit.gif\" border=\"0\" alt=\"Redigera mall\"></a> <a href=\"" . $baseUrl . "/admin_delete_template.html?templateId=" . $row["id"] . "\" OnClick=\"if(confirm('Ta bort " . $row["name"] . "?')) { document.location=this.href; } else { return false; }\"><img src=\"" . $baseUrl . "/img/delete.png\" border=\"0\" alt=\"Ta bort mall\"></a> <a href=\"" . $baseUrl . "/admin_template.html?type=resetPassword\" onClick=\"openPopup(this.href,'admin_resetPassword_template', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/new.png\" border=\"0\" alt=\"Ny mall\"></a>\n";
	}
	else
	{
		$body.= templateLink( "email", "resetPassword" );
	}

	$body.= "</div></div></p>

<p><div id=\"leftTutorial\" style=\"min-width: 250px\">Nytt lösenord</div>
<div id=\"rightTutorial\"><div id=\"newPassword\">";

	$row = array();
	$q = "SELECT * FROM fl_templates WHERE templateType = 'email' AND id = " . (int)$configuration["newPassword"] . " AND active = 'YES'";
	if ( $row = $DB->GetRow( $q ) )
	{
		$body.= "<a href=\"#\" onClick=\"getContent('select_template.php?target=newPassword&type=newPassword&action=select&templateId=" . (int)$row["id"] . "');\">" . $row["name"] . " - " . $row["insDate"] . "</a> <a href=\"" . $baseUrl . "/admin_template.html?templateId=" . $row["id"] . "&type=newPassword\" onClick=\"openPopup(this.href,'admin_newPassword_template" . $row["id"] . "', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/edit.gif\" border=\"0\" alt=\"Redigera mall\"></a> <a href=\"" . $baseUrl . "/admin_delete_template.html?templateId=" . $row["id"] . "\" OnClick=\"if(confirm('Ta bort " . $row["name"] . "?')) { document.location=this.href; } else { return false; }\"><img src=\"" . $baseUrl . "/img/delete.png\" border=\"0\" alt=\"Ta bort mall\"></a> <a href=\"" . $baseUrl . "/admin_template.html?type=newPassword\" onClick=\"openPopup(this.href,'admin_newPassword_template', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/new.png\" border=\"0\" alt=\"Ny mall\"></a>\n";
	}
	else
	{
		$body.= templateLink( "email", "newPassword" );
	}

	$body.= "</div></div></p>

<p><div id=\"leftTutorial\" style=\"min-width: 250px\">Bekräftelse nyhetsbrev</div>
<div id=\"rightTutorial\"><div id=\"newSubscriber\">";

	$row = array();
	$q = "SELECT * FROM fl_templates WHERE templateType = 'email' AND id = " . (int)$configuration["newSubscriber"] . " AND active = 'YES'";
	if ( $row = $DB->GetRow( $q ) )
	{
		$body.= "<a href=\"#\" onClick=\"getContent('select_template.php?target=newSubscriber&type=newSubscriber&action=select&templateId=" . (int)$row["id"] . "');\">" . $row["name"] . " - " . $row["insDate"] . "</a> <a href=\"" . $baseUrl . "/admin_template.html?templateId=" . $row["id"] . "&type=newSubscriber\" onClick=\"openPopup(this.href,'admin_newSubscriber_template" . $row["id"] . "', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/edit.gif\" border=\"0\" alt=\"Redigera mall\"></a> <a href=\"" . $baseUrl . "/admin_delete_template.html?templateId=" . $row["id"] . "\" OnClick=\"if(confirm('Ta bort " . $row["name"] . "?')) { document.location=this.href; } else { return false; }\"><img src=\"" . $baseUrl . "/img/delete.png\" border=\"0\" alt=\"Ta bort mall\"></a> <a href=\"" . $baseUrl . "/admin_template.html?type=newSubscriber\" onClick=\"openPopup(this.href,'admin_newSubscriber_template', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/new.png\" border=\"0\" alt=\"Ny mall\"></a>\n";
	}
	else
	{
		$body.= templateLink( "email", "newSubscriber" );
	}

	$body.= "</div></div></p>

<p><div id=\"leftTutorial\" style=\"min-width: 250px\">Bekräftelse tipsad kompis</div>
<div id=\"rightTutorial\"><div id=\"newSubscriberFriend\">";

	$row = array();
	$q = "SELECT * FROM fl_templates WHERE templateType = 'email' AND id = " . (int)$configuration["newSubscriberFriend"] . " AND active = 'YES'";
	if ( $row = $DB->GetRow( $q ) )
	{
		$body.= "<a href=\"#\" onClick=\"getContent('select_template.php?target=newSubscriberFriend&type=newSubscriberFriend&action=select&templateId=" . (int)$row["id"] . "');\">" . $row["name"] . " - " . $row["insDate"] . "</a> <a href=\"" . $baseUrl . "/admin_template.html?templateId=" . $row["id"] . "&type=newSubscriberFriend\" onClick=\"openPopup(this.href,'admin_newSubscriberFriend_template" . $row["id"] . "', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/edit.gif\" border=\"0\" alt=\"Redigera mall\"></a> <a href=\"" . $baseUrl . "/admin_delete_template.html?templateId=" . $row["id"] . "\" OnClick=\"if(confirm('Ta bort " . $row["name"] . "?')) { document.location=this.href; } else { return false; }\"><img src=\"" . $baseUrl . "/img/delete.png\" border=\"0\" alt=\"Ta bort mall\"></a> <a href=\"" . $baseUrl . "/admin_template.html?type=newSubscriberFriend\" onClick=\"openPopup(this.href,'admin_newSubscriberFriend_template', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/new.png\" border=\"0\" alt=\"Ny mall\"></a>\n";
	}
	else
	{
		$body.= templateLink( "email", "newSubscriberFriend" );
	}

	$body.= "</div></div></p>

	
<p><div id=\"leftTutorial\" style=\"min-width: 250px\">Mail till inbjuden vän</div>
<div id=\"rightTutorial\"><div id=\"newInvitedFriend\">";

	$row = array();
	$q = "SELECT * FROM fl_templates WHERE templateType = 'invite' AND id = " . (int)$configuration["newInvitedFriend"] . " AND active = 'YES'";
	if ( $row = $DB->GetRow( $q ) )
	{
		$body.= "<a href=\"#\" onClick=\"getContent('select_template.php?target=newInvitedFriend&type=newInvitedFriend&action=select&templateId=" . (int)$row["id"] . "');\">" . $row["name"] . " - " . $row["insDate"] . "</a> <a href=\"" . $baseUrl . "/admin_invite_template.html?templateId=" . $row["id"] . "&type=invite\" onClick=\"openPopup(this.href,'admin_newInvitedFriend_template" . $row["id"] . "', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/edit.gif\" border=\"0\" alt=\"Redigera mall\"></a> <a href=\"" . $baseUrl . "/admin_delete_template.html?templateId=" . $row["id"] . "\" OnClick=\"if(confirm('Ta bort " . $row["name"] . "?')) { document.location=this.href; } else { return false; }\"><img src=\"" . $baseUrl . "/img/delete.png\" border=\"0\" alt=\"Ta bort mall\"></a> <a href=\"" . $baseUrl . "/admin_invite_template.html?type=newInvitedFriend\" onClick=\"openPopup(this.href,'admin_newInvitedFriend_template', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/new.png\" border=\"0\" alt=\"Ny mall\"></a>\n";
	}
	else
	{
		$body.= templateLink( "invite", "newInvitedFriend" );
	}

	$body.= "</div></div></p>
	

<p><div id=\"leftTutorial\" style=\"min-width: 250px\">Vi saknar dig!</div>
<div id=\"rightTutorial\"><div id=\"weMissYou\">";

	$row = array();
	$q = "SELECT * FROM fl_templates WHERE templateType = 'email' AND id = " . (int)$configuration["weMissYou"] . " AND active = 'YES'";
	if ( $row = $DB->GetRow( $q ) )
	{
		$body.= "<a href=\"#\" onClick=\"getContent('select_template.php?target=weMissYou&type=newSubscriberFriend&action=select&templateId=" . (int)$row["id"] . "');\">" . $row["name"] . " - " . $row["insDate"] . "</a> <a href=\"" . $baseUrl . "/admin_template.html?templateId=" . $row["id"] . "&type=weMissYou\" onClick=\"openPopup(this.href,'admin_weMissYou_template" . $row["id"] . "', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/edit.gif\" border=\"0\" alt=\"Redigera mall\"></a> <a href=\"" . $baseUrl . "/admin_delete_template.html?templateId=" . $row["id"] . "\" OnClick=\"if(confirm('Ta bort " . $row["name"] . "?')) { document.location=this.href; } else { return false; }\"><img src=\"" . $baseUrl . "/img/delete.png\" border=\"0\" alt=\"Ta bort mall\"></a> <a href=\"" . $baseUrl . "/admin_template.html?type=weMissYou\" onClick=\"openPopup(this.href,'admin_weMissYou_template', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/new.png\" border=\"0\" alt=\"Ny mall\"></a>\n";
	}
	else
	{
		$body.= templateLink( "email", "weMissYou" );
	}

	$body.= "</div></div></p>";
}
?>