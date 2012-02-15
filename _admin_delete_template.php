<?php
$metaTitle = "Flator.se > Ta bort mall";

if ( (int)$_SESSION["rights"] < 6 )
{
	$adminFooter = FALSE;
	$loginUrl = $baseUrl . "/admin_delete_template.html";
	include( "login.php" );
}
else
{
	if ( (int)$_GET["templateId"] > 0 )
	{
		$q = "DELETE FROM fl_templates WHERE id = " . (int)$_GET["templateId"];
		$DB->Execute( $q );

		header( "Location: " . $_SERVER["HTTP_REFERER"] );
	}
	else
	{
		$message = "Ett mall ID måste anges.";
	}

	$body = "
<div id=\"content\">
	<div class=\"contentdiv\">

<h2>Ta bort användare</h2>
";

if ( strlen( $message ) > 0 ) $body.= "<div id=\"error\">" . $message . "</div>\n";

}

?>