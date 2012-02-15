<?php
$metaTitle = "Flator.se > Redigera omröstning";

if ( (int)$_SESSION["rights"] < 6 )
{
	$adminFooter = FALSE;
	$loginUrl = $baseUrl . "/admin_poll_result.html";
	include( "login.php" );
}
else
{
	

		$q = "SELECT * FROM fl_polls WHERE id = " . (int)$_GET["pollId"];
		$row = $DB->GetRow( $q, FALSE, TRUE );
		if ( count( $row ) > 0 )
		{
			$_POST["question"] = $row["question"];
			$_POST["description"] = $row["description"];
			$_POST["active"] = $row["active"];
			$_POST["popup"] = $row["popup"];
		}

	$body = "
<div id=\"content\">
	<div class=\"contentdiv\">



<h2>Nuvarande resultat</h2>
";

			$q = "SELECT count(*) as antal FROM fl_polls_answers WHERE pollId = '".(int)$_GET["pollId"]."' AND optionId != 0 GROUP BY pollId";
			$antalRow = $DB->GetRow( $q, FALSE, TRUE );
			$antalTot = $antalRow["antal"];
			$body .= "Svar totalt: ".$antalTot."<br />";



		$q = "SELECT * FROM fl_polls_options WHERE pollId = '".(int)$_GET["pollId"]."' ORDER BY ID ASC";
		$currPollOptions = $DB->GetAssoc( $q, FALSE, TRUE );
		if (count($currPollOptions) > 0) {

			$body .= "<table><tr><th>Alternativ</th><th>Vald antal</th><th>Procent vald</th></tr>";
		while ( list( $key, $value ) = each( $currPollOptions ) )
		{

			$q = "SELECT count(*) as antal FROM fl_polls_answers WHERE pollId = '".(int)$_GET["pollId"]."' AND optionId = '".(int)$currPollOptions[ $key ]["id"]."' GROUP BY pollId";
			$antalRow = $DB->GetRow( $q, FALSE, TRUE );
			$antal = $antalRow["antal"];
			$antalProcent = number_format((($antal / $antalTot) * 100), 1);

			$body .= "<tr><td>".$currPollOptions[ $key ]["title"]."</td><td>$antal</td><td>$antalProcent%</td></tr>";

	}
	$body .= "</table>";

		}


}

?>