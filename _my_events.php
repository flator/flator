<?php
$metaTitle = "Flator.se - Mina events";

if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/my_events.html";
	include( "login_new.php" );
}
else
{
	if ( $_POST  && $_SESSION["demo"] != TRUE )
	{
		if ( count( $_POST["eventId"] ) > 0 )
		{
			while ( list( $key, $value ) = each( $_POST["eventId"] ) )
			{
				$record = array();
				$record["insDate"] = date( "Y-m-d H:i:s" );
				$record["eventId"] = $value;
				$record["userId"] = $_SESSION["userId"];
				$DB->AutoExecute( "fl_event_subscribers", $record, 'INSERT' );

				$q = "SELECT * FROM fl_events where id = ".$value;
				$addedeventArray = $DB->GetAssoc( $q, FALSE, TRUE );
				if ( count( $addedeventArray ) > 0 )
				{
					while ( list( $key2, $value2 ) = each( $addedeventArray ) )
					{
							$record = array();
							$record["insDate"] = date("Y-m-d H:i:s");
							$record["userId"] = (int)$_SESSION["userId"];
							$record["statusMessage"] = "Lade till event \"<a href=\"".$baseUrl."/events.html\">".trim($addedeventArray[$key2]["name"])."</a>\" till sina events.";
							//echo $record["statusMessage"];
							$record["statusType"] = "addedEvent";
							$DB->AutoExecute( "fl_status", $record, 'INSERT' ); 
					}
				}


			}
		}

		if ( count( $_POST["deleteEventId"] ) > 0 )
		{
			while ( list( $key, $value ) = each( $_POST["deleteEventId"] ) )
			{
				$query = "DELETE FROM fl_event_subscribers where eventId = ".$value." AND userId = ".(int)$userProfile["id"]."";
		    	$DB->autoExecute( $query );				///////////////////////////////////////////////////////////////////////////////

			}
		}

		if ( strlen( $_POST["name"] ) > 0 && strlen( $_POST["city"] ) > 0 )
		{
			$_POST["startDate"] = $_POST["startYear"] . "-" . $_POST["startMonth"] . "-" . $_POST["startDay"] . " " . $_POST["startHour"] . ":" . $_POST["startMinute"] . ":00";
			$_POST["endDate"] = $_POST["endYear"] . "-" . $_POST["endMonth"] . "-" . $_POST["endDay"] . " " . $_POST["endHour"] . ":" . $_POST["endMinute"] . ":00";

#		$DB->debug = TRUE;
			$record = array();
			$record["eventType"] = addslashes( $_POST["eventType"] );
			$record["name"] = addslashes( $_POST["name"] );
			$record["location"] = addslashes( $_POST["location"] );
			$record["postalAddress"] = addslashes( $_POST["postalAddress"] );
			$record["city"] = addslashes( $_POST["city"] );
			$record["startDate"] = addslashes( $_POST["startDate"] );
			$record["endDate"] = addslashes( $_POST["endDate"] );
			$record["description"] = addslashes( $_POST["description"] );
			$record["requirements"] = addslashes( $_POST["requirements"] );
			$record["public"] ="NO";
			$record["deleted"] = "NO";

			if ( $_GET["eventId"] > 0 )
			{
				$DB->AutoExecute( "fl_events", $record, 'UPDATE', 'id = ' . (int)$_GET["eventId"] ); 
			}
			else
			{
				if ( $_POST["public"] == "YES" )
				{
					$record["applyPublic"] = "YES";
					$record["applyPublicDate"] = date( "Y-m-d H:i:s" );
				}

				$record["insDate"] = date( "Y-m-d H:i:s");
				$record["userId"] = $_SESSION["userId"];
				$DB->AutoExecute( "fl_events", $record, 'INSERT' ); 

				$_GET["eventId"] = $DB->Insert_ID();
			}

			if ( $_FILES["image"]["name"] )
			{
				$dir = $serverRoot."/rwdx/user";

				$validImageTypes = array( "image/jpg" => "jpg",
										  "image/gif" => "gif",
										  "image/png" => "png" );

				$imageInfo = getimagesize( $_FILES['image']['tmp_name'] );

#				if ( $validImageTypes[ $imageInfo["mime"] ] )
#				{
					// Create unique image-name
					$unique = "event-" . time() . "-" . (int)$_GET["eventId"];
					$imageName = $unique.substr($_FILES["image"]["name"], -4, 4);

					move_uploaded_file($_FILES['image']['tmp_name'], $dir . "/tmp" . $imageName);
					createthumb( $dir . "/tmp" . $imageName, $dir . "/" . $imageName, 160, 300 );
					unlink( $dir . "/tmp" . $imageName );
					$imageInfo = getimagesize( $dir . "/" . $imageName );

					$record = array();
					$record["imageUrl"] = $baseUrl . "/rwdx/user/" . $imageName;
					$record["serverLocation"] = $dir . "/" . $imageName;
					$DB->AutoExecute( "fl_events", $record, 'UPDATE', 'id = ' . $_GET["eventId"] );
#				}
#				else
#				{
#					$error.= "<li>Felaktigt <b>bildformat</b>. Endast bilder av typen: jpg, gif eller png kan användas.</li>\n";
#				}
			}

		}
		elseif ( $_POST )
		{
			$message = "Du måste ange korrekt namn och stad/ort.";
		}
		else
		{
			$q = "SELECT * FROM fl_events WHERE id = " . (int)$_GET["eventId"];
			$row = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $row ) > 0 )
			{
				$_POST["eventType"] = $row["eventType"];
				$_POST["name"] = $row["name"];
				$_POST["location"] = $row["location"];
				$_POST["postalAddress"] = $row["postalAddress"];
				$_POST["city"] = $row["city"];
				$_POST["startDate"] = $row["startDate"];
				$_POST["endDate"] = $row["endDate"];
				$_POST["description"] = $row["description"];
				$_POST["requirements"] = $row["requirements"];
				$_POST["public"] = $row["public"];
				$_POST["deleted"] = $row["deleted"];
			}
		}
	}

	$body = "<div id=\"center\">
<form name=\"form\" style=\"margin: 0px; padding: 0px\" method=\"post\" action=\"" . $baseUrl . "/my_events.html\" onSubmit=\"document.form.submit();\">

<div id=\"divHeadSpace\">

		<div id=\"headLinks\" style=\"width: 225px\"><span onMouseOver=\"document.deleteEvent.src='img/symbols/gif_red/radera.gif'\" onMouseOut=\"document.deleteEvent.src='img/symbols/gif_purple/radera.gif'\"><a href=\"#noexist\" onClick=\"document.form.submit();\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/radera.gif\" name=\"deleteEvent\" align=\"ABSMIDDLE\" border=\"0\" />Ta bort</a></span>&nbsp;&nbsp;&nbsp;<span onMouseOver=\"document.newEvent.src='img/symbols/gif_red/typ_av_event.gif'\" onMouseOut=\"document.newEvent.src='img/symbols/gif_purple/typ_av_event.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupNewEvent');\" style=\"font-weight: normal; line-height: 22px\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/typ_av_event.gif\" name=\"newEvent\" align=\"ABSMIDDLE\" border=\"0\" />Skapa nytt event</a></span></div>

&nbsp;</div>";

unset( $eventList );
$eventList = "0";
$q = "SELECT * FROM fl_event_subscribers WHERE userId = '" . $_SESSION["userId"] . "'";
$subscribeArray = $DB->GetAssoc( $q, FALSE, TRUE );
if ( count( $subscribeArray ) > 0 )
{
	while ( list( $key, $value ) = each( $subscribeArray ) )
	{
		if ( strlen( $eventList ) > 0 ) $eventList .= ",";
		$eventList.= $subscribeArray[ $key ]["eventId"];
	}
}

//$q = "SELECT *, UNIX_TIMESTAMP(startDate) AS startTime, UNIX_TIMESTAMP(endDate) AS endTime, fl_users.username FROM fl_events LEFT JOIN fl_users ON fl_users.id = fl_events.userId WHERE deleted = 'NO' AND UNIX_TIMESTAMP( endDate ) >= UNIX_TIMESTAMP( NOW() ) AND (userId = '" . (int)$_SESSION["userId"] . "' OR fl_events.id IN (" . $eventList . ")) ORDER BY startDate ASC";
$q = "SELECT *, UNIX_TIMESTAMP(startDate) AS startTime, UNIX_TIMESTAMP(endDate) AS endTime, fl_users.username, fl_events.id as eventId FROM fl_events LEFT JOIN fl_users ON fl_users.id = fl_events.userId WHERE deleted = 'NO' AND (userId = '" . (int)$_SESSION["userId"] . "' OR fl_events.id IN (" . $eventList . ")) ORDER BY startDate ASC";

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

		$body.= "<p style=\"padding-bottom: 10px\"><div style=\"float: left; width: 10px; margin-right: 10px\"><input type=\"checkbox\" style=\"border: 0px solid #b28aa6\" name=\"deleteEventId[]\" value=\"" . $eventArray[ $key ]["eventId"] . "\"></div>";

		if ( strlen( $eventArray[ $key ]["imageUrl"] ) > 0 )
		{
		//echo $eventArray[ $key ]["imageUrl"];
		$body.= "<div style=\"float: left; width: 160px; margin-right: 30px\"><img src=\"" . $eventArray[ $key ]["imageUrl"] . "\" border=\"0\" /></div><div style=\"float: left; width: 390px\">";
		}
		else
		{
			$body.= "<div style=\"float: left; width: 580px\">";
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
		$body.= strip_tags( stripslashes( $eventArray[ $key ]["description"] ), "<br><a>" ) . " <span class=\"news_location\">" . $eventArray[ $key ]["requirements"] . "</span><!-- <nobr><a href=\"events/" . $eventArray[ $key ]["id"] . ".html\">Läs mer »</a></nobr>-->";
		if ( strlen( $eventArray[ $key ]["username"] ) > 0 )
		{
			$body.= "<br /><div class=\"email_date\" style=\"display: inline\">Upplagd av:</div> <a href=\"" . $baseUrl . "/rwdx/user/" . $eventArray[ $key ]["username"] . ".html\" style=\"font-weight: normal\">" . $eventArray[ $key ]["username"] . "</a>";
		}

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