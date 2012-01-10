<?php
$metaTitle = "Flator.se > Lägg till omröstning";

if ( (int)$_SESSION["rights"] < 6 )
{
	$adminFooter = FALSE;
	$loginUrl = $baseUrl . "/admin_add_poll.html";
	include( "login.php" );
}
else
{
	if ( strlen( $_POST["question"] ) > 0 )
	{
		if ( $_POST["active"] == "YES" ) {
			$q = "UPDATE fl_polls SET active = 'NO' WHERE active = 'YES'";
			$DB->Execute( $q );
		}
		$record["insDate"] = date( "Y-m-d H:i:s" );
		$record["question"] = $_POST["question"]; 
		$record["description"] = $_POST["description"];
		$record["active"] = $_POST["active"];
		$record["popup"] = $_POST["popup"];
		$DB->AutoExecute( "fl_polls", $record, 'INSERT'); 
		$newId = $DB->Insert_ID();
		redirect($baseUrl."/admin_edit_poll.html?pollId=".$newId);

	} 

	$body = "
<div id=\"content\">
	<div class=\"contentdiv\">

<h2>Skapa ny omröstning</h2>
";

if ( strlen( $message ) > 0 ) $body.= "<div id=\"error\">" . $message . "</div>\n";

	$body.= "
<form method=\"post\" style=\"padding: 0px; margin: 0px\">

<p><label for=\"question\">Fråga:</label> <input type=\"text\" id=\"question\" name=\"question\" value=\"" . stripslashes( $_POST["question"] ) . "\" /></p>
<p><label for=\"description\">Beskrivning:</label> <input type=\"text\" id=\"description\" name=\"description\" value=\"" . stripslashes( $_POST["description"] ) . "\" /></p>
<p><label for=\"active\">Aktiv:</label> <select id=\"active\" name=\"active\" />
";

$body.= "<option value=\"YES\">Ja</option>";
 $body.= "<option value=\"NO\" selected>Nej</option>";

	$body.= "	
</select></p>
<p>Observera att om aktiv är satt till \"Ja\" så kommer andra omröstningar att inaktiveras och denna nya omröstning kommer att visas så fort du har fyllt i minst 2 alternativ i nästa steg.</p>
<p><label for=\"popup\">Visa i popup:</label> <select id=\"popup\" name=\"popup\" />
";

$body.= "<option value=\"YES\">Ja</option>";
 $body.= "<option value=\"NO\" selected>Nej</option>";

	$body.= "	
</select></p>
<p>Om \"visa i popup\" är satt till \"Ja\" så kommer omröstningen att visas i fullskärmsläge en gång för alla användare, detta kan vara irriterande, så det bör endast utnyttjas vid väldigt viktiga frågor.</p>
<p class=\"submit\"><input type=\"submit\" value=\"Spara ändringar\" /></p>
</form>

";

		


}

?>