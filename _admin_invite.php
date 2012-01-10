<?php
$metaTitle = "Flator.se > Inbjudningar";
$numPerPage = 30;

if ( (int)$_SESSION["rights"] < 6 )
{
	$adminFooter = FALSE;
	$noLogo = TRUE;
	$adminMenu = FALSE;
	$loginUrl = $baseUrl . "/admin_invite.html";
	include( "login.php" );
}
else
{

	$body = "
<div id=\"content\">
	<div class=\"contentdiv\">

<h2>Inbjudningar</h2>
	";

	$body.= "
<p>Eftersom denna community inte är öppan för allmänheten kan man istället bjuda in personer att bli medlemmar. Inbjudan mailas iväg till de berörda personerna och i det mailet finns en unik kod med som används vid medlemsregistrering.</p>

<p>Klicka på användare i menyn för att lägga till e-postadresser att skicka inbjudan till. Inbjudningar kan inte skickas ut till e-postadresser som redan är markerade som medlemmar.</p>
	";

	$body.= "
<p><div id=\"leftTutorial\">1.</div>
<div id=\"rightTutorial\"><div id=\"selectTemplate\">";

	if ( (int)$_GET["templateId"] > 0 )
	{
		$row = array();
		$q = "SELECT * FROM fl_templates WHERE templateType = 'invite' AND id = " . (int)$_GET["templateId"] . " AND active = 'YES'";
		if ( $row = $DB->GetRow( $q ) )
		{
			$body.= "<a href=\"#\" onClick=\"getContent('select_template.php?target=selectTemplate&type=invite&action=select&templateId=" . (int)$_GET["templateId"] . "');\">" . $row["name"] . " - " . $row["insDate"] . "</a> <a href=\"" . $baseUrl . "/admin_invite_template.html?templateId=" . $row["id"] . "\" onClick=\"openPopup(this.href,'admin_invite_template" . $row["id"] . "', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/edit.gif\" border=\"0\" alt=\"Redigera mall\"></a> <a href=\"" . $baseUrl . "/admin_delete_template.html?templateId=" . $row["id"] . "\" OnClick=\"if(confirm('Ta bort " . $row["name"] . "?')) { document.location=this.href; } else { return false; }\"><img src=\"" . $baseUrl . "/img/delete.png\" border=\"0\" alt=\"Ta bort mall\"></a> <a href=\"" . $baseUrl . "/admin_invite_template.html\" onClick=\"openPopup(this.href,'admin_invite_template', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/new.png\" border=\"0\" alt=\"Ny mall\"></a>\n";
		}
		else
		{
			$body.= templateLink( "invite" );
		}
	}
	else
	{
		$body.= templateLink( "invite" );
	}
	
	$body.= "</div></div></p>";

	if ( (int)$_GET["templateId"] > 0 )
	{
		$body.= "<form method=\"post\" style=\"margin: 0px; padding: 0px\">
<input type=\"hidden\" name=\"templateId\" value=\"" . $_GET["templateId"] . "\" />
<p><div id=\"leftTutorial\">2.</div>
<div id=\"rightTutorial\"><p>Välj e-postadresser</p>";

		$q = "SELECT fl_users.*, COUNT(fl_email_log.id) AS invitations FROM fl_users LEFT JOIN fl_email_log ON fl_email_log.recipientUserId = fl_users.id WHERE rights = 1 GROUP BY fl_users.id ORDER BY fl_users.email ASC";
		$row = $DB->GetAssoc( $q, FALSE, TRUE );
		if ( count( $row ) > 0 )
		{
			if ( count( $row ) < 20 )
			{
				$body.= "<br /><select name=\"userIds\" multiple size=\"" . count( $row ) . "\" onKeyPress=\"return !(window.event && window.event.keyCode == 13);\">";
			}
			else
			{
				$body.= "<br /><select name=\"userIds\" multiple size=\"20\" onKeyPress=\"return !(window.event && window.event.keyCode == 13);\">";
			}

			while ( list( $key, $value ) = each( $row ) )
			{
				$body.= "	<option value=\"" . $row[ $key ]["id"] . "\">" . $row[ $key ]["email"] . " (" . (int)$row[ $key ]["invitations"] . ")</option>\n";
			}
		}

		$body.= "</select>
<p><i>Siffran inom parentes anger hur många gånger tidigare de fått en inbjudan. De e-postadresser som listas här är endast till dom som ej redan är medlemmar.</i></p>

</div></p>
<p><div id=\"leftTutorial\">3.</div>
<div id=\"rightTutorial\"><input type=\"button\" value=\"Skicka\" onClick=\"showLoad('emailProgress');getContent('send_emails.php?target=emailProgress&type=invitation&templateId=' + this.form.templateId.value + '&userIds=' + getSelectValue(this.form.userIds));\" /></div></p>
</form>

<div id=\"emailProgress\"></div>";

	}

	$body.= "
	</div>
</div>";

}
?>