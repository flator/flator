<?php
$metaTitle = "Flator.se - Topplistor - Nya bilder";
$numPerPage = 50;

if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/nya_bilder.html";
	include( "login_new.php" );
}
else
{

	$currentLink = array();

		$q = "SELECT fl_images.*, UNIX_TIMESTAMP(fl_images.insDate) AS unixTime, fl_users.username FROM fl_images LEFT JOIN fl_users ON fl_users.id = fl_images.userId WHERE imageType = 'albumPhoto' ORDER BY unixTime DESC LIMIT 100";
		$albums = $DB->GetAssoc( $q, FALSE, TRUE );
	

	if ( count( $albums ) > 0 )
	{
		while ( list( $key, $value ) = each( $albums ) )
		{

				$avatar = "<img src=\"http://www.flator.se/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $albums[ $key ]["serverLocation"])) . "/small/\" border=\"0\" width=\"61\" height=\"61\" />";
			
			$albums[ $key ]["avatar"] = $avatar;
		}
	}


	$body = "<div id=\"center\">

<form name=\"form\" style=\"margin: 0px; padding: 0px\" method=\"post\">
	";
			$body.= "


<div id=\"divHeadSpace\" style=\"border: 0px; line-height: 10px\">&nbsp;</div><div style=\"float: left; \"><div style=\"padding-top: 6px; padding-bottom: 4px;border:none; border-bottom: 1px dotted #c8c8c8; width:592px; margin-bottom:10px;\" width=\"595px\"><h3>De 30 senaste bilderna</h3></div></div>";

$body .= "
<p>
<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-size: 12px;margin-top:0px;\">";

	reset( $albums );
	$printed = 0;
	if ( count( $albums ) > 0 )
	{
		$i = (int)$_GET["offset"];
		$i2 = 0;

		while ( list( $key, $value ) = each( $albums ) )
		{
			$i2++;
			if ( $i2 <= (int)$_GET["offset"] ) continue;
			if ( $i2 > ( (int)$_GET["offset"] + $numPerPage ) ) break;

			$i++;

			unset( $onlineTime );
			// Possible date-types: Today, Yesterday, ThisYear, LastYear
			if ( date("Y-m-d", $albums[ $key ]["unixTime"] ) == date( "Y-m-d" ) )
			{
				// Message sent today
				$onlineTime = "<div class=\"email_date\">" . "Idag kl " . date( "H:i", $albums[ $key ]["unixTime"] ) . "</div>";
			}
			elseif ( date("Y-m-d", $albums[ $key ]["unixTime"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
			{
				// Message sent yesterday
				$onlineTime = "<div class=\"email_date\">" . "Ig&aring;r kl " . date( "H:i", $albums[ $key ]["unixTime"] ) . "</div>";
			}
			elseif ( date("Y", $albums[ $key ]["unixTime"] ) == date( "Y" ) )
			{
				// Message sent this year
				$onlineTime = "<div class=\"email_date\">" . date( "j M Y H:i", $albums[ $key ]["unixTime"] ) . "</div>";
			}
			else
			{
				$onlineTime = "<div class=\"email_date\">" . date( "Y-m-d H:i", $albums[ $key ]["unixTime"] ) . "</div>";
			}
			
			if ($albums[ $key ]["name"] == "") { $albums[ $key ]["name"] = "<i>Inget namn</i>"; }
			$body.= "<tr>

 	<td style=\"width: 30px; padding-bottom: 10px; padding-right: 10px\" valign=\"top\"><a href=\"" . $baseUrl . "/media/photos/" . $key . ".html\" style=\"font-weight: normal\">" . $albums[ $key ]["avatar"] . "</a></td>
 	<td style=\"width: 140px;padding-bottom: 10px\" valign=\"top\"><a href=\"" . $baseUrl . "/media/photos/" . $key . ".html\">" . stripslashes($albums[ $key ]["name"]) . "</a><br />" . $onlineTime . "
  <div class=\"email_date\">Av <a href=\"" . $baseUrl . "/user/" . stripslashes($albums[ $key ]["username"]) . ".html\">" . stripslashes($albums[ $key ]["username"]) . "</a>";
  



  $body .= "</div>
 	</td>
  	<td style=\"padding-bottom: 10px\" valign=\"top\">" . stripslashes($albums[ $key ]["description"]);
	
	
$body .= "</td>
 </tr>";
			$body.= "<tr>
 	<td colspan=\"4\" style=\"padding-bottom: 0px; border-top: 1px dotted #c8c8c8;\" valign=\"top\">&nbsp;</td>
 </tr>";
 $printed++;
		}
	}
	else
	{
		if ( strlen( $_POST["friendSearchQuery"] ) > 0 )
		{
			$body.= "<tr><td colspan=\"4\">Inga vänner matchade din sökning. (" . htmlentities( stripslashes( $_POST["friendSearchQuery"] ) ) . ")</td></tr>";
		}
		else
		{
			if ( $page == "friends.html" )
			{
				$body.= "<tr><td colspan=\"4\">Inga vänner ännu.</td></tr>";
			}
			elseif ( $page == "friends_updated.html" )
			{
				$body.= "<tr><td colspan=\"4\">Inga nyligen uppdaterade vänner.</td></tr>";
			}
			elseif ( $page == "friends_online.html" )
			{
				$body.= "<tr><td colspan=\"4\">Inga vänner online.</td></tr>";
			}
			elseif ( $page == "friends_common.html" )
			{
				$body.= "<tr><td colspan=\"4\">Inga gemensamma vänner.</td></tr>";
			}
		}
	}

	$body.= "</table>\n\n	<div id=\"divFooterSpace\" style=\"border: 0px\">";

	// Paging
	if ( count( $albums ) > $numPerPage )
	{
		if ( (int)$_GET["offset"] > 0 )
		{
			$body.= "<div id=\"previous\"><a href=\"" . $baseUrl . "/" . $page . "?offset=" . ( (int)$_GET["offset"] - $numPerPage ) . "&sortBy=" . (int)$_GET["sortBy"] . "\">F&ouml;reg&aring;ende sida</a></div>";
		}
		else
		{
			$body.= "<div id=\"previous\">&nbsp;</div>\n";
		}
		$body.= "<div id=\"middle\" style=\"text-align: center\"><b>" . (int)$printed . "</b> av <b>". count( $albums ) . "</b></div>\n";
		if ( $i < count( $albums ) )
		{
			$body.= "<div id=\"next\"><a href=\"" . $baseUrl . "/" . $page . "?offset=" . $i . "&sortBy=" . (int)$_GET["sortBy"] . "\">N&auml;sta sida</a></div>";
		}
	}
	else
	{
		$body.= "<div id=\"previous\">&nbsp;</div><div id=\"middle\" style=\"text-align: center\"><b>" . (int)$printed . "</b> av <b>" . count( $albums ) . "</b></div>\n";		
	}

	$body.= "&nbsp;</div></p></form>

</div>

<div id=\"right\">";

	$body.= rightMenu('topLists');
$body.= "</div>";

}
?>