<?php
$metaTitle = "Flator.se - Mina sidor - Meddelanden - Godkänn vänner";

if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/notes.html";
	include( "login_new.php" );
}
else
{

#	$DB->debug = TRUE;

	if ( strlen( $_GET["userIds"] ) > 0 && $_SESSION["demo"] != TRUE )
	{
		$_GET["userIds"] = str_replace( "message,", "", $_GET["userIds"] );
		$friendsArr = explode( ",", $_GET["userIds"] );

		if ( count( $friendsArr ) > 0 )
		{
			while ( list( $key, $value ) = each( $friendsArr ) )
			{
				$record = array();
				$record["approved"] = "YES";
				$DB->AutoExecute( "fl_friends", $record, 'UPDATE', 'userId = ' . (int)$value . ' AND friendUserId = ' . (int)$_SESSION["userId"] );

				$q = "SELECT * FROM fl_users WHERE id = " . (int)$value . "";
				$friendData = $DB->GetRow( $q, FALSE, TRUE );
				if ( count( $friendData ) > 0 )
				{
						$record = array();
						$record["insDate"] = date("Y-m-d H:i:s");
						$record["userid"] = (int)$_SESSION["userId"];
						
						$record["statusMessage"] = "Blev vän med: <a href=\"http://www.flator.se/user/".$friendData["username"].".html\">".$friendData["username"]."</a>";
						$record["mostRecent"] = "NO";
						$record["statusType"] = "newFriend";
						$DB->AutoExecute( "fl_status", $record, 'INSERT');

						$record = array();
						$record["insDate"] = date("Y-m-d H:i:s");
						$record["userid"] = (int)$friendData["id"];
						
						$record["statusMessage"] = "Blev vän med: <a href=\"http://www.flator.se/user/".$userProfile["username"].".html\">".$userProfile["username"]."</a>";
						$record["mostRecent"] = "NO";
						$record["statusType"] = "newFriend";
						$DB->AutoExecute( "fl_status", $record, 'INSERT');

						$guestImage["imageUrl"];
				}

			}
		}

		$q = "DELETE FROM fl_friends WHERE userId = " . (int)$_SESSION["userId"] . " AND friendUserId IN (" . addslashes( implode( ",", $friendsArr ) ) . ")";
#echo $q;
		$DB->Execute( $q );
	}
	header( "Location: " . $_SERVER["HTTP_REFERER"] );
}
?>