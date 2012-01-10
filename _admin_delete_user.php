<?php
$metaTitle = "Flator.se > Ta bort användare";

if ( (int)$_SESSION["rights"] < 6 )
{
	$adminFooter = FALSE;
	$loginUrl = $baseUrl . "/admin_delete_user.html";
	include( "login.php" );
}
else
{
	if ( (int)$_GET["userId"] > 0 )
	{
		$q = "DELETE FROM fl_users WHERE id = " . (int)$_GET["userId"];
		$DB->Execute( $q );

		$q = "DELETE FROM fl_albums WHERE userId = " . (int)$_GET["userId"];
		$DB->Execute( $q );

		$q = "DELETE FROM fl_blog WHERE userId = " . (int)$_GET["userId"];
		$DB->Execute( $q );

		$q = "DELETE FROM fl_comments WHERE userId = " . (int)$_GET["userId"];
		$DB->Execute( $q );

		$q = "DELETE FROM fl_flirts WHERE senderUserId = " . (int)$_GET["userId"];
		$DB->Execute( $q );

		$q = "DELETE FROM fl_flirts WHERE recipientUserId = " . (int)$_GET["userId"];
		$DB->Execute( $q );

		$q = "DELETE FROM fl_friends WHERE friendUserId = " . (int)$_GET["userId"];
		$DB->Execute( $q );

		$q = "DELETE FROM fl_friends WHERE userId = " . (int)$_GET["userId"];
		$DB->Execute( $q );

		$q = "DELETE FROM fl_guestbook WHERE userId = " . (int)$_GET["userId"];
		$DB->Execute( $q );

		$q = "DELETE FROM fl_images WHERE userId = " . (int)$_GET["userId"];
		$DB->Execute( $q );

		$q = "DELETE FROM fl_visitors WHERE userId = " . (int)$_GET["userId"];
		$DB->Execute( $q );

		$q = "DELETE FROM fl_visitors WHERE visitorUserId = " . (int)$_GET["userId"];
		$DB->Execute( $q );

		$q = "DELETE FROM fl_email_log WHERE recipientUserId = " . (int)$_GET["userId"];
		$DB->Execute( $q );

		$q = "DELETE FROM fl_login_log WHERE userId = " . (int)$_GET["userId"];
		$DB->Execute( $q );

		header( "Location: " . $_SERVER["HTTP_REFERER"] );
	}
	else
	{
		$message = "Ett användar ID måste anges.";
	}

	$body = "
<div id=\"content\">
	<div class=\"contentdiv\">

<h2>Ta bort användare</h2>
";

if ( strlen( $message ) > 0 ) $body.= "<div id=\"error\">" . $message . "</div>\n";

}

?>