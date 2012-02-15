<?php
$metaTitle = "Flator.se > Ta bort nyhet";

if ( (int)$_SESSION["rights"] < 6 )
{
	$adminFooter = FALSE;
	$loginUrl = $baseUrl . "/admin_shout.html";
	include( "login.php" );
}
else
{
	if ( (int)$_GET["shoutId"] > 0 )
	{

		$DB->_Execute( "DELETE FROM fl_shouts where id = ".(int)$_GET["shoutId"]."" );


		header( "Location: " . $_SERVER["HTTP_REFERER"] );
	}
	else
	{
		$message = "Ett nyhets-ID måste anges.";
	}

	$body = "
<div id=\"content\">
	<div class=\"contentdiv\">

<h2>Ta bort event</h2>
";

if ( strlen( $message ) > 0 ) $body.= "<div id=\"error\">" . $message . "</div>\n";

}

?>