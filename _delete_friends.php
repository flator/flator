<?php
$metaTitle = "Flator.se - Mina sidor - Meddelanden - Ta bort vänner";

if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/friends.html";
	include( "login_new.php" );
}
else
{
	if ( strlen( $_GET["userIds"] ) > 0 && $_SESSION["demo"] != TRUE )
	{
		$_GET["userIds"] = str_replace( "message,", "", $_GET["userIds"] );
		$friendsArr = explode( ",", $_GET["userIds"] );

		$q = "DELETE FROM fl_friends WHERE userId = " . (int)$_SESSION["userId"] . " AND friendUserId IN (" . addslashes( implode( ",", $friendsArr ) ) . ")";
#echo $q;
		$DB->Execute( $q );
		$q = "DELETE FROM fl_friends WHERE friendUserId = " . (int)$_SESSION["userId"] . " AND userId IN (" . addslashes( implode( ",", $friendsArr ) ) . ")";
#echo $q;
		$DB->Execute( $q );
	}
	header( "Location: " . $_SERVER["HTTP_REFERER"] );
}
?>