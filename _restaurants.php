<?php
$metaTitle = "Flator.se - Klubb/restaurang";

if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/restaurants.html";
	include( "login_new.php" );
}
else
{
	$body = "<div id=\"center\">
<form name=\"form\" style=\"margin: 0px; padding: 0px\" method=\"post\" action=\"" . $baseUrl . "/my_events.html\" onSubmit=\"document.form.submit();\">

<div id=\"divHeadSpace\">

		<div id=\"headLinks\" style=\"width: 225px\"><span onMouseOver=\"document.saveMyEvents.src='img/symbols/gif_red/datum.gif'\" onMouseOut=\"document.saveMyEvents.src='img/symbols/gif_purple/datum.gif'\"><a href=\"#noexist\" onClick=\"document.form.submit();\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/datum.gif\" name=\"saveMyEvents\" align=\"ABSMIDDLE\" border=\"0\" />Lägg till under Mina events</a></span>		</div>

&nbsp;</div>";

$q = "SELECT *, UNIX_TIMESTAMP(startDate) AS startTime, UNIX_TIMESTAMP(endDate) AS endTime FROM fl_events WHERE (eventType = 'Restaurang' OR eventType = 'Klubb') AND public = 'YES' AND deleted = 'NO' ORDER BY name ASC";
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

		if ( $eventArray[ $key ]["eventType"] == "Restaurang" )
		{
			$eventType = "Restauranger";
		}
		elseif ( $eventArray[ $key ]["eventType"] == "Klubb" )
		{
			$eventType = "Klubbar";			
		}

		$body.= "<a href=\"restaurants.html\" class=\"news_type\">" . $eventType . "/" . $eventArray[ $key ]["city"] . "</a>&nbsp;&nbsp;<span class=\"news_headline\">" . stripslashes( $eventArray[ $key ]["name"] ) . "</span><br />
<a href=\"http://maps.google.se/maps?f=q&hl=sv&q=" . urlencode( $eventArray[ $key ]["location"] . " " . $eventArray[ $key ]["city"] ) . "&z=16&iwloc=addr\" target=\"_blank\">" . $eventArray[ $key ]["location"] . "</a><br />";
		if ( strlen( $eventDate ) > 0 )
		{
			$body.= "<span class=\"news_date\">" . $eventDate . "</span><br>";
		}
		$body.= strip_tags( stripslashes( $eventArray[ $key ]["description"] ), "<br><a>" ) . " <span class=\"news_location\">" . $eventArray[ $key ]["requirements"] . "</span><!-- <nobr><a href=\"events/" . $eventArray[ $key ]["id"] . ".html\">Läs mer »</a></nobr>-->";

		$body.= "</div>";
		$body.= "</p>";
	}
}

$body.= "</form>
</p>

</div>

<div id=\"right\">";

	$body.= rightMenu('events');
	$body.= "</div>";

}
?>