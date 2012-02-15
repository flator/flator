<?php
$metaTitle = "Flator.se > Godkänn nya användare";
$numPerPage = 1000;

$rights = array( 0 => "Ingen åtkomst",
				 1 => "Nyhetsbrev",
				 2 => "Obekräftad",
				 3 => "Medlem",
				 4 => "Moderator",
				 5 => "Fråga flatan",
				 6 => "Administratör" );

if ( (int)$_SESSION["rights"] < 6 )
{
	$adminFooter = FALSE;
	$noLogo = TRUE;
	$adminMenu = FALSE;
	$loginUrl = $baseUrl . "/admin_approve.html";
	include( "login.php" );
}
else
{

	if ( strlen( $_GET["userIds"] ) > 0)
	{
		$recipentFriendsArr = array();
		$_GET["userIds"] = str_replace( "message,", "", $_GET["userIds"] );
		$recipentFriendsArr = explode( ",", $_GET["userIds"] );
		$q = "SELECT * FROM fl_users WHERE rights > 1 AND id IN (" . addslashes( implode( ",", $recipentFriendsArr ) ) . ") ORDER BY username ASC";
#		echo $q;
		$row = $DB->GetAssoc( $q, FALSE, TRUE );
		if ( count( $row ) > 0 )
		{
			while ( list( $key, $value ) = each( $row ) )
			{
				$validRecipentArr[] = $row[ $key ]["id"];

				if ( strlen( $result ) > 0 )
				{
					$result.= ", ";
				}
				$result.= "<a href=\"" . $baseUrl . "/user/" . $row[ $key ]["username"] . ".html\">" . $row[ $key ]["username"] . "</a>";

					$record = array();
					$record["approved"] = "YES";					
					$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = '.(int)$row[ $key ]["id"] );
			}
			$result = "Följande medlemmar är nu godkända: ".$result;
		}
	}










	$body = "
<div id=\"content\">
	<div class=\"contentdiv\">";
$body .= $result;
	$body .= "
<form name=\"form\" style=\"margin: 0px; padding: 0px\" method=\"post\">
<div id=\"previous\"><h2>Användare</h2></div>
<div id=\"next\"><a href=\"#noexist\" onClick=\"checkAll(document.form.userId)\">Markera alla</a></div><input type=\"checkbox\" style=\"display:none\" name=\"userId\" value=\"xx\" checked>
<br /><br />
";

	$q = "SELECT * FROM fl_users WHERE rights > 0 AND approved = 'NO' AND personalCodeNumber != '' ORDER BY insDate ASC";
	$row = $DB->GetAssoc( $q, FALSE, TRUE );

#	for( $i = 0; $i < 155; $i++ )
#	{
#		$row[ $i+20 ]["username"] = $i;
#	}

	if ( count( $row ) > 0 )
	{
		$i = (int)$_GET["offset"];
		$i2 = 0;

		$body.= "<p><table border=\"0\" width=\"100%\" class=\"spread\">\n";
		$body.= "<tr><th>#</th><th>Användarnamn</th><th>Blev medlem</th><th>E-post</td><th>IP</th><th>Angivet namn</th><th>Namn enl. personnummer</th><th>Personnummer</th><th colspan=\"3\">&nbsp;</th></tr>\n";

		while ( list( $key, $value ) = each( $row ) )
		{
			$i2++;
			if ( $i2 <= (int)$_GET["offset"] ) continue;
			if ( $i2 > ( (int)$_GET["offset"] + $numPerPage ) ) break;

			$i++;
			$body.= "<tr><td>" . number_format( $i, 0, ",", " ") . "</td><td>" . $row[ $key ]["username"] . "</td><td>" . $row[ $key ]["insDate"] . "</td><td>" . $row[ $key ]["email"] . "</td><td>" . $row[ $key ]["remoteAddr"] . "</td><td>" . $row[ $key ]["firstName"] . " " . $row[ $key ]["lastName"] . "</td><td>" . $row[ $key ]["verifiedName"] . "</td><td>" . $row[ $key ]["personalCodeNumber"] . "</td><td><a href=\"" . $baseUrl . "/admin_edit_user.html?userId=" . $key . "\" onClick=\"openPopup(this.href,'admin_edit_user" . $key . "', 500, 400); return false;\"><img src=\"" . $baseUrl . "/img/edit.gif\" border=\"0\" alt=\"Redigera användare\"></a></td><td>";

			if ( $key == $_SESSION["userId"] )
			{
				$body.= "<a href=\"#nonexist\" OnClick=\"alert('Av säkerhetsskäl kan man inte ta bort det konto man är inloggad med.')\"><img src=\"" . $baseUrl . "/img/delete.png\" border=\"0\" alt=\"Ta bort användare\"></a>";
			}
			else
			{
				$body.= "<a href=\"" . $baseUrl . "/admin_delete_user.html?userId=" . $key . "\" OnClick=\"if(confirm('Ta bort " . $row[ $key ]["username"] . "?')) { document.location=this.href; } else { return false; }\"><img src=\"" . $baseUrl . "/img/delete.png\" border=\"0\" alt=\"Ta bort användare\"></a>";
			}

			$body.= "</td><td><input type=\"checkbox\" style=\"border: 1px solid #b28aa6\" name=\"userId\" value=\"" . $key . "\"></td></tr>\n";
		}

		$body.= "</table></p>\n";
	}

	if ( count( $row ) > $numPerPage )
	{
		if ( (int)$_GET["offset"] > 0 )
		{
			$body.= "<div id=\"previous\"><a href=\"" . $baseUrl . "/admin_users.html?offset=" . ( (int)$_GET["offset"] - $numPerPage ) . "\">Föregående sida</a></div>";
		}
		if ( $i < count( $row ) )
		{
			$body.= "<div id=\"next\"><a href=\"" . $baseUrl . "/admin_users.html?offset=" . $i . "\">Nästa sida</a></div>";
		}
	}

$body.= "<div id=\"next\"><a href=\"#noexist\" onClick=\"location='" . $baseUrl . "/admin_approve.html?userIds=' + checkboxValues(document.form.userId)\">Godkänn markerade</a></div></form>
	</div>
</div>
	";

}
?>