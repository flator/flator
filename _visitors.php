<?php
$metaTitle = "Flator.se - Mina sidor - Besökare";
$numPerPage = 50;

if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/visitors.html";
	include( "login_new.php" );
}
else
{
	$currentLink = array();

	if ( $_GET["sortBy"] == "username" )
	{
		$q = "SELECT fl_visitors.*, UNIX_TIMESTAMP(fl_visitors.insDate) AS unixTime, fl_users.username, fl_users.insDate AS joinedDate FROM fl_visitors LEFT JOIN fl_users ON fl_users.id = fl_visitors.visitorUserId WHERE fl_visitors.userId = " . (int)$_SESSION["userId"] . " ORDER BY fl_users.username ASC";
		$visitors = $DB->CacheGetAssoc( 3*60, $q, FALSE, TRUE );
		$currentLink["username"] = " class=\"current\"";
	}
	elseif ( !$_GET["sortBy"] )
	{
		$q = "SELECT fl_visitors.*, UNIX_TIMESTAMP(fl_visitors.insDate) AS unixTime, fl_users.username, fl_users.insDate AS joinedDate FROM fl_visitors LEFT JOIN fl_users ON fl_users.id = fl_visitors.visitorUserId WHERE fl_visitors.userId = " . (int)$_SESSION["userId"] . " ORDER BY fl_visitors.insDate DESC";
		$visitors = $DB->CacheGetAssoc( 3*60, $q, FALSE, TRUE );
		$currentLink["date"] = " class=\"current\"";
	}
	elseif ( $_GET["sortBy"] == "visits" )
	{
		$q = "SELECT fl_visitors.*, UNIX_TIMESTAMP(fl_visitors.insDate) AS unixTime, fl_users.username, fl_users.insDate AS joinedDate, COUNT(*) AS noVisits FROM fl_visitors LEFT JOIN fl_users ON fl_users.id = fl_visitors.visitorUserId WHERE fl_visitors.userId = " . (int)$_SESSION["userId"] . " GROUP BY fl_visitors.visitorUserId ORDER BY noVisits DESC";
		$visitors = $DB->CacheGetAssoc( 3*60, $q, FALSE, TRUE );
		$currentLink["visits"] = " class=\"current\"";
	}

	if ( count( $visitors ) > 0 )
	{
		while ( list( $key, $value ) = each( $visitors ) )
		{
			$q = "SELECT * FROM fl_images WHERE userId = " . (int)$visitors[ $key ]["visitorUserId"] . " AND imageType = 'profileSmall'";
			$profileImage = $DB->CacheGetRow( 20*60, $q, FALSE, TRUE );
			if ( count( $profileImage ) > 0 )
			{
				$avatar = "<img src=\"" . $baseUrl . "/user-photos/" . str_replace('http://www.flator.se/rwdx/user/', '', $profileImage["imageUrl"]) . "/profile-thumb/" . "\" border=\"0\"  />";

			}
			else
			{
				$avatar = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/person_avnatar_liten.gif\" border=\"0\" width=\"26\" height=\"29\" />";
			}
			$visitors[ $key ]["avatar"] = $avatar;

			$q = "SELECT * FROM fl_images WHERE userId = " . (int)$visitors[ $key ]["visitorUserId"] . " AND imageType = 'profileMedium'";
			$guestImage = $DB->CacheGetRow( 20*60, $q, FALSE, TRUE );
			if ( count( $guestImage ) > 0 )
			{
				$visitors[ $key ]["mediumAvatar"] = $guestImage["imageUrl"];
			}
			else
			{
				$visitors[ $key ]["mediumAvatar"] = $baseUrl . "/img/symbols/gif_avatars/person_avantar_stor.gif";
			}

			$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_status WHERE userId = " . (int)$visitors[ $key ]["visitorUserId"] . " AND statusType = 'personalMessage' ORDER BY insDate DESC LIMIT 0,1";
			$statusRow = $DB->CacheGetRow( 3*60, $q, FALSE, TRUE );
			$visitors[ $key ]["status"] = $statusRow["statusMessage"];
		}
	}

	$body = "<div id=\"center\">
	<div id=\"divHeadSpace\">&nbsp;</div>

<p>
<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-size: 12px\">";

	reset( $visitors );
	if ( count( $visitors ) > 0 )
	{
		$i = (int)$_GET["offset"];
		$i2 = 0;

		while ( list( $key, $value ) = each( $visitors ) )
		{
			$i2++;
			if ( $i2 <= (int)$_GET["offset"] ) continue;
			if ( $i2 > ( (int)$_GET["offset"] + $numPerPage ) ) break;

			$i++;

			unset( $onlineTime );
			// Possible date-types: Today, Yesterday, ThisYear, LastYear
			if ( date("Y-m-d", $visitors[ $key ]["unixTime"] ) == date( "Y-m-d" ) )
			{
				// Message sent today
				$onlineTime = "<div class=\"email_date\">Bes&ouml;kte dig senast: " . "Idag kl " . date( "H:i", $visitors[ $key ]["unixTime"] ) . "</div>";
			}
			elseif ( date("Y-m-d", $visitors[ $key ]["unixTime"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
			{
				// Message sent yesterday
				$onlineTime = "<div class=\"email_date\">Bes&ouml;kte dig senast: " . "Ig&aring;r kl " . date( "H:i", $visitors[ $key ]["unixTime"] ) . "</div>";
			}
			elseif ( date("Y", $visitors[ $key ]["unixTime"] ) == date( "Y" ) )
			{
				// Message sent this year
				$onlineTime = "<div class=\"email_date\">Bes&ouml;kte dig senast: " . date( "j M Y H:i", $visitors[ $key ]["unixTime"] ) . "</div>";
			}
			else
			{
				$onlineTime = "<div class=\"email_date\">Bes&ouml;kte dig senast: " . date( "Y-m-d H:i", $visitors[ $key ]["unixTime"] ) . "</div>";
			}

			$body.= "<tr>
<!-- 	<td style=\"width: 20px; padding-bottom: 10px\" valign=\"top\"><input type=\"checkbox\" style=\"border: 1px solid #b28aa6\" name=\"friendUserId\" value=\"" . $visitors[ $key ]["userId"] . "\"></td>-->
 	<td style=\"width: 50px; padding-bottom: 10px\" valign=\"top\"><a href=\"javascript:void(null)\" onClick=\"showImage2('popupMediumImage".$key."','" . $visitors[ $key ]["mediumAvatar"] . "', 'mediumProfileImage".$key."');\" style=\"font-weight: normal\">" . $visitors[ $key ]["avatar"] . "</a></td>
 	<td style=\"width: 305px; padding-bottom: 10px\" valign=\"top\"><a href=\"" . $baseUrl . "/user/" . $visitors[ $key ]["username"] . ".html\">" . $visitors[ $key ]["username"] . "</a> " . stripslashes($visitors[ $key ]["status"]) . "<br />" . $onlineTime;
			if ( $visitors[ $key ]["noVisits"] > 0 )
			{
				$body.= "<div class=\"email_date\" style=\"display: inline\">Antal bes&ouml;k totalt: " . number_format( $visitors[ $key ]["noVisits"], 0, ",", " " ) . "</div>";
			}
 			$body.= "<div style=\"position:relative\"><div id=\"popupMediumImage".$key."\" style=\"display: none; position:absolute;border: 2px solid #645d54; top: 0px; left: 0px; z-index: 101; background-color: #ffffff; \"><div style=\"margin: 0px\"><div style=\"float: left; display: block\"><a href=\"javascript:void(null)\" onclick=\"closeImage2('popupMediumImage".$key."');\"><img src=\"".$baseUrl."/img/symbols/gif_avatars/person_avantar_stor.gif\" id=\"mediumProfileImage".$key."\" border=\"0\" style=\"margin: 3px\" /></a></div></div></div></div></td>
 	<td style=\"width: 200px; padding-bottom: 10px\" valign=\"top\"><span style=\"line-height: 19px\" onMouseOver=\"document.messageFriends" . $visitors[ $key ]["id"] . ".src='" . $baseUrl . "/img/symbols/gif_red/skicka.gif'\" onMouseOut=\"document.messageFriends" . $visitors[ $key ]["id"] . ".src='" . $baseUrl . "/img/symbols/gif_purple/skicka.gif'\"><a href=\"" . $baseUrl . "/new_message.html?userId=" . (int)$visitors[ $key ]["visitorUserId"] . "\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/skicka.gif\" name=\"messageFriends" . $visitors[ $key ]["id"] . "\" align=\"ABSMIDDLE\" border=\"0\" />Skicka ett meddelande</a></span>
 	<br /><span style=\"line-height: 19px\" onMouseOver=\"document.seeFriends" . $visitors[ $key ]["id"] . ".src='" . $baseUrl . "/img/symbols/gif_red/van.gif'\" onMouseOut=\"document.seeFriends" . $visitors[ $key ]["id"] . ".src='" . $baseUrl . "/img/symbols/gif_purple/van.gif'\"><a href=\"" . $baseUrl . "/friends/" . $visitors[ $key ]["username"] . ".html\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/van.gif\" name=\"seeFriends" . $visitors[ $key ]["id"] . "\" align=\"ABSMIDDLE\" border=\"0\" />Se " . $visitors[ $key ]["username"] . "s vänner</a></span></td>
 </tr>";
			$body.= "<tr>
 	<td colspan=\"4\" style=\"padding-bottom: 5px; border-top: 1px dotted #c8c8c8;\" valign=\"top\">&nbsp;</td>
 </tr>";
		}
	}
	else
	{
		$body.= "<tr><td colspan=\"4\">Du har inte haft några besökare ännu.</td></tr>";
	}

	$body.= "</table>\n\n	<div id=\"divFooterSpace\" style=\"border: 0px\">";

	// Paging
	if ( count( $visitors ) > $numPerPage )
	{
		if ( (int)$_GET["offset"] > 0 )
		{
			$body.= "<div id=\"previous\"><a href=\"" . $baseUrl . "/visitors.html?offset=" . ( (int)$_GET["offset"] - $numPerPage ) . "&sortBy=" . (int)$_GET["sortBy"] . "\">F&ouml;reg&aring;ende sida</a></div>";
		}
		else
		{
			$body.= "<div id=\"previous\">&nbsp;</div>\n";
		}
		$body.= "<div id=\"middle\" style=\"text-align: center\"><b>" . $i2 . "</b> av <b>". count( $visitors ) . "</b></div>\n";
		if ( $i < count( $visitors ) )
		{
			$body.= "<div id=\"next\"><a href=\"" . $baseUrl . "/visitors.html?offset=" . $i . "&sortBy=" . (int)$_GET["sortBy"] . "\">N&auml;sta sida</a></div>";
		}
	}
	else
	{
		$body.= "<div id=\"previous\">&nbsp;</div><div id=\"middle\" style=\"text-align: center\"><b>" . count( $visitors ) . "</b> av <b>" . count( $visitors ) . "</b></div>\n";		
	}

	$body.= "&nbsp;</div></p></form>

</div>

<div id=\"right\">";
$body.= rightMenu('visitors');
$body.= "</div>";

}
?>