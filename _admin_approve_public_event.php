<?php
$metaTitle = "Flator.se > Godkänn event";

if ( (int)$_SESSION["rights"] < 6 )
{
	$adminFooter = FALSE;
	$loginUrl = $baseUrl . "/admin_events.html";
	include( "login.php" );
}
else
{
	if ( (int)$_GET["eventId"] > 0 )
	{
		$record = array();
		$record["applyPublic"] = "NO";
		$record["public"] = "YES";
		$DB->AutoExecute( "fl_events", $record, 'UPDATE', 'id = ' . (int)$_GET["eventId"] ); 


		header( "Location: " . $_SERVER["HTTP_REFERER"] );
	}
	else
	{
		$message = "Ett event ID måste anges.";
	}

	$body = "
<div id=\"content\">
	<div class=\"contentdiv\">

<h2>Godkänn publikt event</h2>
";

if ( strlen( $message ) > 0 ) $body.= "<div id=\"error\">" . $message . "</div>\n";

}

?>