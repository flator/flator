<?php
$metaTitle = "Flator.se - Vänners events";

if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/friends_events.html";
	include( "login_new.php" );
}
else
{
	$friends = array();
	unset( $friendList );
	$q = "SELECT * FROM fl_friends WHERE approved = 'YES' AND (userId = '" . $_SESSION["userId"] . "' OR friendUserId = '" . $_SESSION["userId"] . "')";
	$friendArray = $DB->GetAssoc( $q, FALSE, TRUE );
	if ( count( $friendArray ) > 0 )
	{
		while ( list( $key, $value ) = each( $friendArray ) )
		{
			if ( $friendArray[ $key ]["userId"] != (int)$_SESSION["userId"] )
			{
				$friends[ $friendArray[ $key ]["userId"] ] = $friendArray[ $key ]["userId"];
				if ( strlen( $friendList ) > 0 ) $friendList .= ",";
				$friendList.= $friendArray[ $key ]["userId"];
			}
			else
			{
				$friends[ $friendArray[ $key ]["friendUserId"] ] = $friendArray[ $key ]["friendUserId"];
				if ( strlen( $friendList ) > 0 ) $friendList .= ",";
				$friendList.= $friendArray[ $key ]["friendUserId"];
			}
		}
	}

	$body = "<div id=\"center\">
<form name=\"form\" style=\"margin: 0px; padding: 0px\" method=\"post\" action=\"" . $baseUrl . "/my_events.html\" onSubmit=\"document.form.submit();\">

<div id=\"divHeadSpace\">

		<div id=\"headLinks\" style=\"width: 225px\"><span onMouseOver=\"document.saveMyEvents.src='img/symbols/gif_red/datum.gif'\" onMouseOut=\"document.saveMyEvents.src='img/symbols/gif_purple/datum.gif'\"><a href=\"#noexist\" onClick=\"document.form.submit();\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/datum.gif\" name=\"saveMyEvents\" align=\"ABSMIDDLE\" border=\"0\" />Lägg till under Mina events</a></span>		</div>

&nbsp;</div>";

$q = "SELECT *, UNIX_TIMESTAMP(startDate) AS startTime, UNIX_TIMESTAMP(endDate) AS endTime, fl_users.username FROM fl_events LEFT JOIN fl_users ON fl_users.id = fl_events.userId WHERE userId IN (" . $friendList . ") AND (eventType = 'Event' OR eventType = '') AND public = 'YES' AND deleted = 'NO' AND UNIX_TIMESTAMP( endDate ) >= UNIX_TIMESTAMP( NOW() ) ORDER BY startDate ASC";
$eventArray = $DB->GetAssoc( $q, FALSE, TRUE );

if ( count( $eventArray ) > 0 )
{
	while ( list( $key, $value ) = each( $eventArray ) )
	{

		if ( $eventArray[ $key ]["startTime"] > 0 )
		{
			unset( $eventDate );
			if ($eventArray[ $key ]["textDate"] != "") {
				$eventDate = $eventArray[ $key ]["textDate"];

			} elseif ( date( "Y-m-d", $eventArray[ $key ]["startTime"] ) == date( "Y-m-d", $eventArray[ $key ]["endTime"] ) )
			{
				$eventDate = ucfirst( days( date( "N", $eventArray[ $key ]["startTime"] ) ) )
				 . " " . 
				 (int)date( "d", $eventArray[ $key ]["startTime"] )
				  . " " . 
				  months( date( "n", $eventArray[ $key ]["startTime"] ) )
				   . ". ";
			}
			else
			{
				$eventDate = ucfirst( days( date( "N", $eventArray[ $key ]["startTime"] ) ) )
				 . " " . 
				 (int)date( "d", $eventArray[ $key ]["startTime"] )
				  . " " . 
				  months( date( "n", $eventArray[ $key ]["startTime"] ) )
				   . ". "  . " - " . 
	 			ucfirst( days( date( "N", $eventArray[ $key ]["endTime"] ) ) )
				 . " " . 
				 (int)date( "d", $eventArray[ $key ]["endTime"] )
				  . " " . 
				  months( date( "n", $eventArray[ $key ]["endTime"] ) )
				   . ". ";
			}
		}

		$body.= "<p style=\"padding-bottom: 10px\"><div style=\"float: left; width: 10px; margin-right: 10px\"><input type=\"checkbox\" style=\"border: 0px solid #b28aa6\" name=\"eventId[]\" value=\"" . $eventArray[ $key ]["id"] . "\"></div>";

		if ( strlen( $eventArray[ $key ]["imageUrl"] ) > 0 )
		{
			$body.= "<div style=\"float: left; width: 160px; margin-right: 30px\"><img src=\"" . $eventArray[ $key ]["imageUrl"] . "\" border=\"0\" /></div><div style=\"float: left; width: 390px\">";
		}
		else
		{
			$body.= "<div style=\"float: left; width: 160px; margin-right: 30px\">&nbsp;</div><div style=\"float: left; width: 390px\">";
		}

		if ( $eventArray[ $key ]["eventType"] == "Event" )
		{
			$linkUrl = "events.html";
		}
		else
		{
			$linkUrl = "restaurants.html";
		}

		$body.= "<a href=\"" . $baseUrl . "/" . $linkUrl . "\" class=\"news_type\">" . $eventArray[ $key ]["eventType"] . "/" . $eventArray[ $key ]["city"] . "</a>&nbsp;&nbsp;<span class=\"news_headline\">" . stripslashes( $eventArray[ $key ]["name"] ) . "</span><br />
<a href=\"http://maps.google.se/maps?f=q&hl=sv&q=" . urlencode( $eventArray[ $key ]["location"] . " " . $eventArray[ $key ]["city"] ) . "&z=16&iwloc=addr\" target=\"_blank\">" . $eventArray[ $key ]["location"] . "</a><br />";
		if ( strlen( $eventDate ) > 0 )
		{
			$body.= "<span class=\"news_date\">" . $eventDate . "</span><br>";
		}
		$body.= strip_tags( stripslashes( $eventArray[ $key ]["description"] ), "<br><a>" ) . " <span class=\"news_location\">" . $eventArray[ $key ]["requirements"] . "</span><!-- <nobr><a href=\"events/" . $eventArray[ $key ]["id"] . ".html\">Läs mer »</a></nobr>--><br /><div class=\"email_date\">Upplagd av:</div> <a href=\"" . $baseUrl . "/user/" . $eventArray[ $key ]["username"] . ".html\" style=\"font-weight: normal\">" . $eventArray[ $key ]["username"] . "</a>";

		$body.= "</div>";
		$body.= "</p>";
	}
}

$body.= "
</form></p>

</div>

<div id=\"right\">";

	$body.= rightMenu('events');
	$body.= "</div>";

}
?>