<?php
$metaTitle = "Flator.se - Mina sidor - Meddelanden - Anm&auml;lning";

if ( (int)$_SESSION["rights"] < 2 )
{
	$adminFooter = FALSE;
	$loginUrl = $baseUrl . "/report.html";
	include( "login.php" );
}
else
{
	if ( $_GET["type"] == "message" )
	{
		if ( (int)$_GET["messageId"] > 0 )
		{
			$q = "SELECT * FROM fl_messages WHERE id = " . (int)$_GET["messageId"] . " AND (userId = " . (int)$_SESSION["userId"] . " OR recipentUserId = " . (int)$_SESSION["userId"] . ")";
			$mailRow = $DB->GetRow( $q, FALSE, TRUE );
			if ( (int)$mailRow["id"] > 0 )
			{
				$record = array();
				$record["insDate"] = date("Y-m-d H:i:s");
				$record["reportType"] = "message";
				$record["reportId"] = (int)$_GET["messageId"];
				$record["userId"] = (int)$_SESSION["userId"];
				$DB->AutoExecute( "fl_reports", $record, 'INSERT' ); 
			}
		}
		elseif ( $_GET["username"] != "" )
		{

				$record = array();
				$record["insDate"] = date("Y-m-d H:i:s");
				$record["reportType"] = "message";
				#$record["reportId"] = (int)$_GET["messageId"];
				$record["userId"] = (int)$_SESSION["userId"];
				$record["reason"] = "Rapport av konversation med: ".$_GET["username"];
				$DB->AutoExecute( "fl_reports", $record, 'INSERT' ); 
			
		}
	}
	header( "Location: " . $_SERVER["HTTP_REFERER"] );
}
?>