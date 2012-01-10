<?php
$metaTitle = "Flator.se > Användare";
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
	$loginUrl = $baseUrl . "/admin_users.html";
	include( "login.php" );
}
else
{
	$body = "
<div id=\"content\">
	<div class=\"contentdiv\">

<div id=\"previous\"><h2>Användare</h2></div>
<div id=\"next\"><a href=\"" . $baseUrl . "/admin_add_user.html\" id=\"mark\" onClick=\"openPopup(this.href,'admin_add_user', 500, 400); return false;\">Lägg till användare</a></div><br /><br />
";

	$q = "SELECT * FROM fl_users WHERE rights > 0 ORDER BY insDate ASC";
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
		$body.= "<tr><th>#</th><th>Användarnamn</th><th>Blev medlem</th><th>Senast inloggad</th><th>E-post</td><th>IP</th><th>Angivet namn</th><th>Namn enl. personnummer</th><th>Personnummer</th><th>Nivå</th><th colspan=\"2\">&nbsp;</th></tr>\n";

		while ( list( $key, $value ) = each( $row ) )
		{
			$i2++;
			if ( $i2 <= (int)$_GET["offset"] ) continue;
			if ( $i2 > ( (int)$_GET["offset"] + $numPerPage ) ) break;

			$i++;
			$body.= "<tr><td>" . number_format( $i, 0, ",", " ") . "</td><td>" . $row[ $key ]["username"] . "</td><td>" . $row[ $key ]["insDate"] . "</td><td>" . $row[ $key ]["lastLogin"] . "</td><td>" . $row[ $key ]["email"] . "</td><td>" . $row[ $key ]["remoteAddr"] . "</td><td>" . $row[ $key ]["firstName"] . " " . $row[ $key ]["lastName"] . "</td><td>" . $row[ $key ]["verifiedName"] . "</td><td>" . $row[ $key ]["personalCodeNumber"] . "</td><td>" . $rights[ $row[ $key ]["rights"] ] . "</td><td><a href=\"" . $baseUrl . "/admin_edit_user.html?userId=" . $key . "\" onClick=\"openPopup(this.href,'admin_edit_user" . $key . "', 500, 400); return false;\"><img src=\"" . $baseUrl . "/img/edit.gif\" border=\"0\" alt=\"Redigera användare\"></a></td><td>";

			if ( $key == $_SESSION["userId"] )
			{
				$body.= "<a href=\"#nonexist\" OnClick=\"alert('Av säkerhetsskäl kan man inte ta bort det konto man är inloggad med.')\"><img src=\"" . $baseUrl . "/img/delete.png\" border=\"0\" alt=\"Ta bort användare\"></a>";
			}
			else
			{
				$body.= "<a href=\"" . $baseUrl . "/admin_delete_user.html?userId=" . $key . "\" OnClick=\"if(confirm('Ta bort " . $row[ $key ]["username"] . "?')) { document.location=this.href; } else { return false; }\"><img src=\"" . $baseUrl . "/img/delete.png\" border=\"0\" alt=\"Ta bort användare\"></a>";
			}

			$body.= "</td></tr>\n";
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

$body.= "
	</div>
</div>
	";

}
?>