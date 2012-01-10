<?php
$metaTitle = "Flator.se - Mina sidor - Meddelanden - Ta bort meddelanden";

if ( (int)$_SESSION["rights"] < 2 )
{
	$adminFooter = FALSE;
	$loginUrl = $baseUrl . "/inbox.html";
	include( "login.php" );
}
else
{
	if ( count( $_POST["recipientId"] ) > 0  && $_SESSION["demo"] != TRUE )
	{
		while ( list( $key, $value ) = each( $_POST["recipientId"] ) )
		{

				$record = array();
				$record["deleted"] = "YES";
				$DB->AutoExecute( "fl_messages", $record, 'UPDATE', "userId = " . (int)$value . " AND recipentUserId = " . (int)$_SESSION["userId"] ); 
			
				$record = array();
				$record["senderDeleted"] = "YES";
				$DB->AutoExecute( "fl_messages", $record, 'UPDATE', "recipentUserId = " . (int)$value . " AND userId = " . (int)$_SESSION["userId"] ); 
			
		}
	}
	elseif ( count( $_POST["senderId"] ) > 0  && $_SESSION["demo"] != TRUE )
	{
		while ( list( $key, $value ) = each( $_POST["senderId"] ) )
		{
			$q = "SELECT * FROM fl_messages WHERE id = " . (int)$value . " AND userId = " . (int)$_SESSION["userId"];
			$mailRow = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $mailRow ) > 0 )
			{
				$record = array();
				$record["senderDeleted"] = "YES";
				$DB->AutoExecute( "fl_messages", $record, 'UPDATE', 'id = ' . (int)$value ); 
			}
		}
	}
	elseif ( (int)$_GET["messageId"] > 0  && $_SESSION["demo"] != TRUE )
	{
		if ( $_GET["returnTo"] == "inbox" )
		{
			$q = "SELECT * FROM fl_messages WHERE id = " . (int)$_GET["messageId"] . " AND recipentUserId = " . (int)$_SESSION["userId"];
			$mailRow = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $mailRow ) > 0 )
			{
				$record = array();
				$record["deleted"] = "YES";
				if ( $mailRow["userId"] == (int)$_SESSION["userId"] ) $record["senderDeleted"] = "YES";
				$DB->AutoExecute( "fl_messages", $record, 'UPDATE', 'id = ' . (int)$_GET["messageId"] ); 
			}
			header( "Location: " . $baseUrl . "/inbox.html" );
			exit();
		}
		elseif ( $_GET["returnTo"] == "outbox"  && $_SESSION["demo"] != TRUE )
		{
			$q = "SELECT * FROM fl_messages WHERE id = " . (int)$_GET["messageId"] . " AND userId = " . (int)$_SESSION["userId"];
			$mailRow = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $mailRow ) > 0 )
			{
				$record = array();
				$record["senderDeleted"] = "YES";
				if ( $mailRow["recipentUserId"] == (int)$_SESSION["userId"] ) $record["deleted"] = "YES";
				$DB->AutoExecute( "fl_messages", $record, 'UPDATE', 'id = ' . (int)$_GET["messageId"] ); 
			}
			header( "Location: " . $baseUrl . "/outbox.html" );
			exit();
		}
	}
	header( "Location: " . $_SERVER["HTTP_REFERER"] );
}
?>