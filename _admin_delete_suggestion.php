<?php
$metaTitle = "Flator.se > Ta bort f�rslag";

if ( (int)$_SESSION["rights"] < 6 )
{
	$adminFooter = FALSE;
	$loginUrl = $baseUrl . "/admin_delete_suggestion.html";
	include( "login.php" );
}
else
{
	if ( (int)$_GET["suggestionId"] > 0 )
	{
		$q = "DELETE FROM fl_suggestions WHERE id = " . (int)$_GET["suggestionId"];
		$DB->Execute( $q );

		header( "Location: " . $_SERVER["HTTP_REFERER"] );
	}
	else
	{
		$message = "Ett ID m�ste anges.";
	}

	$body = "
<div id=\"content\">
	<div class=\"contentdiv\">

<h2>Ta bort f�rslag</h2>
";

if ( strlen( $message ) > 0 ) $body.= "<div id=\"error\">" . $message . "</div>\n";

}

?>