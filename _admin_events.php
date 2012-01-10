<?php
$metaTitle = "Flator.se > Events";
$numPerPage = 30;

if ( (int)$_SESSION["rights"] < 6 )
{
	$adminFooter = FALSE;
	$noLogo = TRUE;
	$adminMenu = FALSE;
	$loginUrl = $baseUrl . "/admin_events.html";
	include( "login.php" );
}
else
{
	$body = "
<div id=\"content\">
	<div class=\"contentdiv\">

<div id=\"previous\"><h2>Ansökningar om att bli publika events</h2></div>
<br /><br />
";

	$q = "SELECT * FROM fl_events WHERE applyPublic = 'YES' AND public = 'NO' AND deleted = 'NO' ORDER BY applyPublicDate ASC";
	$row = $DB->GetAssoc( $q, FALSE, TRUE );

#	for( $i = 0; $i < 155; $i++ )
#	{
#		$row[ $i+20 ]["username"] = $i;
#	}

	if ( count( $row ) > 0 )
	{
		$i = (int)$_GET["applyOffset"];
		$i2 = 0;

		$body.= "<p><table border=\"0\" width=\"100%\" class=\"spread\">\n";
		$body.= "<tr><th>#</th><th>Namn</th><th>Plats</th><th>Stad</th><th>Startar</td><th colspan=\"2\">Godkänn/Avslå</th></tr>\n";

		while ( list( $key, $value ) = each( $row ) )
		{
			$i2++;
			if ( $i2 <= (int)$_GET["applyOffset"] ) continue;
			if ( $i2 > ( (int)$_GET["applyOffset"] + $numPerPage ) ) break;

			$i++;
			$body.= "<tr><td>" . number_format( $i, 0, ",", " ") . "</td><td><a href=\"" . $baseUrl . "/admin_edit_event.html?eventId=" . $key . "\" onClick=\"openPopup(this.href,'admin_edit_applyEvent" . $key . "', 800, 400); return false;\" style=\"color: #000000\">" . $row[ $key ]["name"] . "</a></td><td>" . $row[ $key ]["location"] . "</td><td>" . $row[ $key ]["city"] . "</td><td>" . $row[ $key ]["startDate"] . "</td><td><a href=\"" . $baseUrl . "/admin_approve_public_event.html?eventId=" . $key . "\" onClick=\"if(confirm('Godkänn " . $row[ $key ]["name"] . "?')) { document.location=this.href; } else { return false; }\"><img src=\"" . $baseUrl . "/img/icon_approve.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Godkänn event\"></a></td><td>";

			$body.= "<a href=\"" . $baseUrl . "/admin_deny_public_event.html?eventId=" . $key . "\" OnClick=\"if(confirm('Avslå " . $row[ $key ]["name"] . "?')) { document.location=this.href; } else { return false; }\"><img src=\"" . $baseUrl . "/img/delete.png\" border=\"0\" alt=\"Avslå event\"></a>";

			$body.= "</td></tr>\n";
		}

		$body.= "</table></p>\n";
	}
	else
	{
		$body.= "<p><i>Inga ansökningar</i></p>";
	}

	if ( count( $row ) > $numPerPage )
	{
		if ( (int)$_GET["applyOffset"] > 0 )
		{
			$body.= "<div id=\"previous\"><a href=\"" . $baseUrl . "/admin_events.html?applyOffset=" . ( (int)$_GET["offset"] - $numPerPage ) . "\">Föregående sida</a></div>";
		}
		if ( $i < count( $row ) )
		{
			$body.= "<div id=\"next\"><a href=\"" . $baseUrl . "/admin_events.html?applyOffset=" . $i . "\">Nästa sida</a></div>";
		}
	}

$body.= "
<p>
<div id=\"previous\"><h2>Publika events</h2></div>
<div id=\"next\"><a href=\"" . $baseUrl . "/admin_add_event.html\" id=\"mark\" onClick=\"openPopup(this.href,'admin_add_event', 800, 400); return false;\">Lägg till event</a></div><br /><br />
";

	$q = "SELECT * FROM fl_events WHERE public = 'YES' AND deleted = 'NO' ORDER BY startDate ASC";
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
		$body.= "<tr><th>#</th><th>Namn</th><th>Plats</th><th>Stad</th><th>Startar</td><th colspan=\"2\">&nbsp;</th></tr>\n";

		while ( list( $key, $value ) = each( $row ) )
		{
			$i2++;
			if ( $i2 <= (int)$_GET["offset"] ) continue;
			if ( $i2 > ( (int)$_GET["offset"] + $numPerPage ) ) break;

			$i++;
			$body.= "<tr><td>" . number_format( $i, 0, ",", " ") . "</td><td>" . $row[ $key ]["name"] . "</td><td>" . $row[ $key ]["location"] . "</td><td>" . $row[ $key ]["city"] . "</td><td>" . $row[ $key ]["startDate"] . "</td><td><a href=\"" . $baseUrl . "/admin_edit_event.html?eventId=" . $key . "\" onClick=\"openPopup(this.href,'admin_edit_event" . $key . "', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/edit.gif\" border=\"0\" alt=\"Redigera event\"></a></td><td>";

			$body.= "<a href=\"" . $baseUrl . "/admin_delete_event.html?eventId=" . $key . "\" OnClick=\"if(confirm('Ta bort " . $row[ $key ]["name"] . "?')) { document.location=this.href; } else { return false; }\"><img src=\"" . $baseUrl . "/img/delete.png\" border=\"0\" alt=\"Ta bort event\"></a>";

			$body.= "</td></tr>\n";
		}

		$body.= "</table></p>\n";
	}
	else
	{
		$body.= "<p><i>Det finns inga events pågående eller framåt.</i></p>";
	}

	if ( count( $row ) > $numPerPage )
	{
		if ( (int)$_GET["offset"] > 0 )
		{
			$body.= "<div id=\"previous\"><a href=\"" . $baseUrl . "/admin_events.html?offset=" . ( (int)$_GET["offset"] - $numPerPage ) . "\">Föregående sida</a></div>";
		}
		if ( $i < count( $row ) )
		{
			$body.= "<div id=\"next\"><a href=\"" . $baseUrl . "/admin_events.html?offset=" . $i . "\">Nästa sida</a></div>";
		}
	}

$body.= "

	</div>
</div>
	";

}
?>