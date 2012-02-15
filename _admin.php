<?php
$metaTitle = "Flator.se";

if ( (int)$_SESSION["rights"] < 6 )
{
	$noLogo = TRUE;
	$adminMenu = FALSE;
	$adminFooter = FALSE;
	$loginUrl = $baseUrl . "/admin.html";
	include( "login.php" );
}
else
{
	

	$body = "";

}
?>