<?php
$metaTitle = "Flator.se > Omr�stningar";
$numPerPage = 1000;

$rights = array( 0 => "Ingen �tkomst",
				 1 => "Nyhetsbrev",
				 2 => "Obekr�ftad",
				 3 => "Medlem",
				 4 => "Moderator",
				 5 => "Fr�ga flatan",
				 6 => "Administrat�r" );

if ( (int)$_SESSION["rights"] < 6 )
{
	$adminFooter = FALSE;
	$noLogo = TRUE;
	$adminMenu = FALSE;
	$loginUrl = $baseUrl . "/admin_poll.html";
	include( "login.php" );
}
else
{

	










	$body = "
<div id=\"content\">
	<div class=\"contentdiv\">";
$body .= $result;
	$body .= "
<div id=\"previous\"><h2>Omr�stningar</h2></div><div id=\"next\"><a href=\"" . $baseUrl . "/admin_add_poll.html\" id=\"mark\" onClick=\"openPopup(this.href,'admin_add_poll', 500, 400); return false;\">Skapa ny omr�stning</a></div>

<br /><br />
";

	$q = "SELECT * FROM fl_polls ORDER BY id ASC";
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
		$body.= "<tr><th>#</th><th>Fr�ga</th><th>Beskrivning</th><th>Startad</th><th>Inkomna svar</td><th>Aktiv</th><th>&nbsp;</th></tr>\n";

		while ( list( $key, $value ) = each( $row ) )
		{
			$i2++;
			if ( $i2 <= (int)$_GET["offset"] ) continue;
			if ( $i2 > ( (int)$_GET["offset"] + $numPerPage ) ) break;

			$q = "SELECT count(*) as antal FROM fl_polls_answers WHERE pollId = '".$row[ $key ]["id"]."' AND optionId != 0 GROUP BY pollId";
			$antalRow = $DB->GetRow( $q, FALSE, TRUE );
			$antal = $antalRow["antal"];



			$i++;
			$body.= "<tr><td>" . number_format( $i, 0, ",", " ") . "</td><td>" . $row[ $key ]["question"] . "</td><td>" . $row[ $key ]["description"] . "</td><td>" . ($row[ $key ]["active"] == "YES" ? $row[ $key ]["insDate"] : ""). "</td><td>" . $antal . "</td><td>" . $row[ $key ]["active"] . "</td><td><a href=\"" . $baseUrl . "/admin_edit_poll.html?pollId=" . $key . "\" onClick=\"openPopup(this.href,'admin_edit_poll" . $key . "', 500, 600); return false;\"><img src=\"" . $baseUrl . "/img/edit.gif\" border=\"0\" alt=\"Redigera anv�ndare\"></a><a href=\"" . $baseUrl . "/admin_poll_result.html?pollId=" . $key . "\" onClick=\"openPopup(this.href,'admin_poll_result" . $key . "', 600, 400); return false;\"><img src=\"" . $baseUrl . "/img/new.png\" border=\"0\" alt=\"Redigera anv�ndare\"></a></td></tr>\n";
		}

		$body.= "</table></p>\n";
	}

	if ( count( $row ) > $numPerPage )
	{
		if ( (int)$_GET["offset"] > 0 )
		{
			$body.= "<div id=\"previous\"><a href=\"" . $baseUrl . "/admin_users.html?offset=" . ( (int)$_GET["offset"] - $numPerPage ) . "\">F�reg�ende sida</a></div>";
		}
		if ( $i < count( $row ) )
		{
			$body.= "<div id=\"next\"><a href=\"" . $baseUrl . "/admin_users.html?offset=" . $i . "\">N�sta sida</a></div>";
		}
	}

$body.= "
	</div>
</div>
	";

}
?>