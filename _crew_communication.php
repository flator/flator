<?php
$metaTitle = "Flator.se - Hem";

if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/crew_communication.html";
	include( "login_new.php" );
}
else
{
	if ( $_SESSION["demo"] != TRUE ) {
	$record = array();
	$record["seenLatestCrewMsg"] = 'YES';
	$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = '.$userProfile["id"] );
	}
	$body = "<div id=\"center\">


<div id=\"divHeadSpace\">&nbsp;</div>";







$q = "SELECT *,  UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_shouts WHERE  active = 'YES' ORDER BY id DESC";
$shoutArray = $DB->GetAssoc( $q, FALSE, TRUE );

if ( count( $shoutArray ) > 0 )
{
	while ( list( $key, $value ) = each( $shoutArray ) )
	{
				// Possible date-types: Today, Yesterday, ThisYear, LastYear
		if ( date("Y-m-d", $shoutArray[ $key ]["unixTime"] ) == date( "Y-m-d" ) )
		{
			// Message sent today
			$onlineTime = "<div class=\"email_date\">" . "Idag kl " . date( "H:i", $shoutArray[ $key ]["unixTime"] ) . "</div>";
		}
		elseif ( date("Y-m-d", $shoutArray[ $key ]["unixTime"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
		{
			// Message sent yesterday
			$onlineTime = "<div class=\"email_date\">" . "Ig&aring;r kl " . date( "H:i", $shoutArray[ $key ]["unixTime"] ) . "</div>";
		}
		elseif ( date("Y", $shoutArray[ $key ]["unixTime"] ) == date( "Y" ) )
		{
			// Message sent this year
			$onlineTime = "<div class=\"email_date\">" . date( "j M Y H:i", $shoutArray[ $key ]["unixTime"] ) . "</div>";
		}
		else
		{
			$onlineTime = "<div class=\"email_date\">" . date( "Y-m-d H:i", $shoutArray[ $key ]["unixTime"] ) . "</div>";
		}

		$body.= "<p style=\"padding-bottom: 10px\">";

		if ( strlen( $shoutArray[ $key ]["imagePath"] ) > 0 )
		{
			$body.= "<div style=\"float: left; width: 160px; margin-right: 30px\"><a href=\"" . $shoutArray[ $key ]["link"] . "\"><img src=\"" . $baseUrl . $shoutArray[ $key ]["imagePath"] . "\" border=\"0\" /></a></div><div style=\"float: left; width: 410px\">";
		}
		else
		{
			$body.= "<div style=\"float: left; width: 160px; margin-right: 30px\">&nbsp;</div><div style=\"float: left; width: 410px\">";
		}

		$body.= "<a href=\"" . $shoutArray[ $key ]["link"] . "\" class=\"news_type\">" . stripslashes($shoutArray[ $key ]["subject"]) . "</a>&nbsp;&nbsp;<span class=\"news_headline\">" . stripslashes( $shoutArray[ $key ]["subject2"] ) . "</span><br />".$onlineTime."".stripslashes( $shoutArray[ $key ]["text"] )."";

		$body.= "</div>";
		$body.= "</p>";
	}
}










$body.= "
</p>

</div>

<div id=\"right\">";

	$body.= rightMenu('frontpage');
	$body.= "</div>";

}
?>