<?php
$metaTitle = "Flator.se > Förslag";
$numPerPage = 30;

if ( (int)$_SESSION["rights"] < 6 )
{
	$adminFooter = FALSE;
	$noLogo = TRUE;
	$adminMenu = FALSE;
	$loginUrl = $baseUrl . "/admin_suggestions.html";
	include( "login.php" );
}
else
{
	$body = "
<div id=\"content\">
	<div class=\"contentdiv\">

<h2>Förslag</h2>";

	$q = "SELECT * FROM fl_suggestions ORDER BY insDate DESC";
	$row = $DB->GetAssoc( $q, FALSE, TRUE );

#	for( $i = 0; $i < 155; $i++ )
#	{
#		$row[ $i+20 ]["suggestion"] = $i;
#	}

	if ( count( $row ) > 0 )
	{
		$i = (int)$_GET["offset"];
		$i2 = 0;

		while ( list( $key, $value ) = each( $row ) )
		{
			$i2++;
			if ( $i2 <= (int)$_GET["offset"] ) continue;
			if ( $i2 > ( (int)$_GET["offset"] + $numPerPage ) ) break;

			$i++;

			$body.= "<div id=\"dataRow\"><a href=\"" . $baseUrl . "/admin_delete_suggestion.html?suggestionId=" . $key . "\" OnClick=\"if(confirm('Ta bort förslaget?')) { document.location=this.href; } else { return false; }\"><img src=\"" . $baseUrl . "/img/delete.png\" border=\"0\" alt=\"Ta bort förslaget\" align=\"absmiddle\"></a> " . stripslashes( $row[ $key ]["suggestion"] ) . " <i>(" . stripslashes( $row[ $key ]["name"] ) . " - " . $row[ $key ]["insDate"] . ")</i></div>\n";
		}
	}

	if ( count( $row ) > $numPerPage )
	{
		$body.= "<p>\n";

		if ( (int)$_GET["offset"] > 0 )
		{
			$body.= "<div id=\"previous\"><a href=\"" . $baseUrl . "/admin_suggestions.html?offset=" . ( (int)$_GET["offset"] - $numPerPage ) . "\">Föregående sida</a></div>";
		}
		if ( $i < count( $row ) )
		{
			$body.= "<div id=\"next\"><a href=\"" . $baseUrl . "/admin_suggestions.html?offset=" . $i . "\">Nästa sida</a></div>";
		}
	}

$body.= "
	</div>
</div>
	";

}
?>