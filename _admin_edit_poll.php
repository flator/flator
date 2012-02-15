<?php
$metaTitle = "Flator.se > Redigera omröstning";

if ( (int)$_SESSION["rights"] < 6 )
{
	$adminFooter = FALSE;
	$loginUrl = $baseUrl . "/admin_edit_poll.html";
	include( "login.php" );
}
else
{
	if ( strlen( $_POST["question"] ) > 0 )
	{
		if ( $_POST["active"] == "YES" ) {
			$record["insDate"] = date( "Y-m-d H:i:s" );
			$q = "UPDATE fl_polls SET active = 'NO' WHERE active = 'YES'";
			$DB->Execute( $q );

		}
		$record["question"] = $_POST["question"]; 
		$record["description"] = $_POST["description"];
		$record["active"] = $_POST["active"];
		$record["popup"] = $_POST["popup"];
		$DB->AutoExecute( "fl_polls", $record, 'UPDATE', 'id = ' . (int)$_GET["pollId"] ); 

	} elseif ( strlen( $_POST["title"] ) > 0 )
	{
		$record = array();
		$record["insDate"] = date( "Y-m-d H:i:s" );
		$record["pollId"] = (int)$_GET["pollId"]; 
		$record["title"] = addslashes($_POST["title"]);
		$DB->AutoExecute( "fl_polls_options", $record, 'INSERT'); 

	}

	if ( (int)$_GET["deleteOption"] > 0 )
	{

		$q = "DELETE FROM fl_polls_options WHERE id = " . (int)$_GET["deleteOption"] . "";
		$DB->Execute( $q );

	}

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

<h2>Redigera omröstning</h2>
";

if ( strlen( $message ) > 0 ) $body.= "<div id=\"error\">" . $message . "</div>\n";

	$body.= "
<form method=\"post\" style=\"padding: 0px; margin: 0px\">

<p><label for=\"question\">Fråga:</label> <input type=\"text\" id=\"question\" name=\"question\" value=\"" . stripslashes( $_POST["question"] ) . "\" /></p>
<p><label for=\"description\">Beskrivning:</label> <input type=\"text\" id=\"description\" name=\"description\" value=\"" . stripslashes( $_POST["description"] ) . "\" /></p>
<p><label for=\"active\">Aktiv:</label> <select id=\"active\" name=\"active\" />
";

if ( $_POST["active"] == "YES" ) { $body.= "<option value=\"YES\" selected>Ja</option>"; } else { $body.= "<option value=\"YES\">Ja</option>"; }
if ( $_POST["active"] == "NO" ) { $body.= "<option value=\"NO\" selected>Nej</option>"; } else { $body.= "<option value=\"NO\">Nej</option>"; }

	$body.= "	
</select></p>
<p>Observera att om aktiv sätts till \"Ja\" så inaktiveras andra omröstningar och denna nya omröstning kommer att visas så fort minst 2 alternativ finns angivna nedan.</p>

<p><label for=\"popup\">Visa i popup:</label> <select id=\"popup\" name=\"popup\" />
";

if ( $_POST["popup"] == "YES" ) { $body.= "<option value=\"YES\" selected>Ja</option>"; } else { $body.= "<option value=\"YES\">Ja</option>"; }
if ( $_POST["popup"] == "NO" ) { $body.= "<option value=\"NO\" selected>Nej</option>"; } else { $body.= "<option value=\"NO\">Nej</option>"; }

	$body.= "	
</select></p>
<p>Om \"visa i popup\" är satt till \"Ja\" så kommer omröstningen att visas i fullskärmsläge en gång för alla användare, detta kan vara irriterande, så det bör endast utnyttjas vid väldigt viktiga frågor.</p>

<p class=\"submit\"><input type=\"submit\" value=\"Spara ändringar\" /></p>
</form>


<h2>Alternativ</h2>
";
		$q = "SELECT * FROM fl_polls_options WHERE pollId = '".(int)$_GET["pollId"]."' ORDER BY ID ASC";
		$currPollOptions = $DB->GetAssoc( $q, FALSE, TRUE );
		if (count($currPollOptions) > 0) {

			$body .= "<table><tr><th>Alternativ</th><th>Radera</th></tr>";

		while ( list( $key, $value ) = each( $currPollOptions ) )
		{
			$body .= "<tr><td>".$currPollOptions[ $key ]["title"]."</td><td><a href=\"".$baseUrl."/admin_edit_poll.html?pollId=".(int)$_GET["pollId"]."&deleteOption=".(int)$currPollOptions[ $key ]["id"]."\">Ta bort</a></td></tr>";

	}
		$body .= "</table>";


		}

$body .= "
<form method=\"post\" style=\"padding: 0px; margin: 0px\">
<p><label for=\"title\">Alternativ:</label> <input type=\"text\" id=\"title\" name=\"title\" value=\"\" /></p>
<p class=\"submit\"><input type=\"submit\" value=\"Lägg till alternativ\" /></p>
</form>
<br /><br />
";

		


}

?>