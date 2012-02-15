<?php
$metaTitle = "Flator.se > Nyheter";
$numPerPage = 30;

if ( (int)$_SESSION["rights"] < 6 )
{
	$adminFooter = FALSE;
	$noLogo = TRUE;
	$adminMenu = FALSE;
	$loginUrl = $baseUrl . "/admin_shouts.html";
	include( "login.php" );
}
else
{
	$body = "
<div id=\"content\">
	<div class=\"contentdiv\">


<p>
<div id=\"previous\"><h2>Publika nyheter</h2></div>
<div id=\"next\"><a href=\"" . $baseUrl . "/admin_add_shout.html\" id=\"mark\" onClick=\"openPopup(this.href,'admin_add_shout', 800, 400); return false;\">Lägg till nyhet</a></div><br /><br />
";

	$q = "SELECT * FROM fl_shouts ORDER BY id DESC";
	$row = $DB->GetAssoc( $q, FALSE, TRUE );

#	for( $i = 0; $i < 155; $i++ )
#	{
#		$row[ $i+20 ]["username"] = $i;
#	}

	if ( count( $row ) > 0 )
	{
		$i = (int)$_GET["publicOffset"];
		$i2 = 0;

		$body.= "<p><table border=\"0\" width=\"100%\" class=\"spread\">\n";
		$body.= "<tr><th>#</th><th>Bild</th><th>Rubrik 1</th><th>Rubrik 2</th><th>Text</th><th>Länk</td><th colspan=\"2\">&nbsp;</th></tr>\n";

		while ( list( $key, $value ) = each( $row ) )
		{
			$i2++;
			if ( $i2 <= (int)$_GET["publicOffset"] ) continue;
			if ( $i2 > ( (int)$_GET["publicOffset"] + $numPerPage ) ) break;

			$i++;
			$body.= "<tr><td>" . number_format( $i, 0, ",", " ") . "</td><td><img src=\"" . $row[ $key ]["imagePath"] . "\" border=\"0\"></td><td>" . $row[ $key ]["subject"] . "</td><td>" . $row[ $key ]["subject2"] . "</td><td>" . $row[ $key ]["text"] . "</td><td>" . $row[ $key ]["link"] . "</td><td><a href=\"" . $baseUrl . "/admin_edit_shout.html?shoutId=" . $key . "\" onClick=\"openPopup(this.href,'admin_edit_shout" . $key . "', 800, 400); return false;\"><img src=\"" . $baseUrl . "/img/edit.gif\" border=\"0\" alt=\"Redigera nyhet\"></a></td><td>";

			$body.= "<a href=\"" . $baseUrl . "/admin_delete_shout.html?shoutId=" . $key . "\" OnClick=\"if(confirm('Ta bort " . $row[ $key ]["subject"] . "?')) { document.location=this.href; } else { return false; }\"><img src=\"" . $baseUrl . "/img/delete.png\" border=\"0\" alt=\"Ta bort nyhet\"></a>";

			$body.= "</td></tr>\n";
		}

		$body.= "</table></p>\n";
	}
	else
	{
		$body.= "<p><i>Det finns inga nyheter.</i></p>";
	}

	if ( count( $row ) > $numPerPage )
	{
		if ( (int)$_GET["publicOffset"] > 0 )
		{
			$body.= "<div id=\"previous\"><a href=\"" . $baseUrl . "/admin_shouts.html?publicOffset=" . ( (int)$_GET["offset"] - $numPerPage ) . "\">Föregående sida</a></div>";
		}
		if ( $i < count( $row ) )
		{
			$body.= "<div id=\"next\"><a href=\"" . $baseUrl . "/admin_shouts.html?publicOffset=" . $i . "\">Nästa sida</a></div>";
		}
	}

$body.= "

	</div>
</div>
	";

}
?>