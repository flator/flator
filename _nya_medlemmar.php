<?php
$metaTitle = "Flator.se - Topplistor - Nya medlemmar";
$numPerPage = 50;

if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/nya_medlemmar.html";
	include( "login_new.php" );
}
else
{

	$currentLink = array();


		$q = "SELECT fl_users.*, UNIX_TIMESTAMP(fl_users.insDate) AS unixTime  FROM fl_users WHERE fl_users.rights > 1 ORDER BY id DESC LIMIT 0, 30";

	
	
#echo $q;
		
#	}
	
	$searchResult = $DB->CacheGetAssoc( 5*60, $q, FALSE, TRUE );
	



	$body = "<div id=\"center\">

<form name=\"form\" style=\"margin: 0px; padding: 0px\" method=\"post\">
	";
			$body.= "


<div id=\"divHeadSpace\" style=\"border: 0px; line-height: 10px\">&nbsp;</div><div style=\"float: left; \"><div style=\"padding-top: 6px; padding-bottom: 4px;border:none; border-bottom: 1px dotted #c8c8c8; width:592px; margin-bottom:10px;\" width=\"595px\"><h3>De 30 senaste medlemmarna</h3></div></div>";

$body .= "
<p>
<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-size: 12px;margin-top:0px;\">";
$printed = 0;
	if ( count( $searchResult ) > 0 )
	{
		$i = (int)$_GET["offset"];
		$i2 = 0;
		
		while ( list( $key, $value ) = each( $searchResult ) )
		{
			$i2++;
			if ( $i2 <= (int)$_GET["offset"] ) continue;
			if ( $i2 > ( (int)$_GET["offset"] + $numPerPage ) ) break;

			$i++;

			$q = "SELECT * FROM fl_images WHERE userId = " . (int)$searchResult[ $key ]["id"] . " AND imageType = 'profileSmall'";
			$mailImage = $DB->CacheGetRow( 20*60, $q, FALSE, TRUE );
			if ( count( $mailImage ) > 0 )
			{
				$avatar = "<img src=\"" . $mailImage["imageUrl"] . "\" border=\"0\" width=\"" . $mailImage["width"] . "\" height=\"" . $mailImage["height"] . "\" />";
			}
			else
			{
				$avatar = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/person_avnatar_liten.gif\" border=\"0\" width=\"26\" height=\"29\" />";
			}

			$q = "SELECT * FROM fl_images WHERE userId = " . (int)$searchResult[ $key ]["id"] . " AND imageType = 'profileMedium'";
			$guestImage = $DB->GetRow( 20*60, $q, FALSE, TRUE );
			if ( count( $guestImage ) > 0 )
			{
				$mediumAvatar = $guestImage["imageUrl"];
			}
			else
			{
				$mediumAvatar = $baseUrl . "/img/symbols/gif_avatars/person_avantar_stor.gif";
			}

			$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_status WHERE userId = " . (int)$searchResult[ $key ]["id"] . " AND statusType = 'personalMessage' ORDER BY insDate DESC LIMIT 0,1";
			
			$statusRow = $DB->GetRow( $q, FALSE, TRUE );
			$searchResult[ $key ]["status"] = $statusRow["statusMessage"];

			$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_users_online WHERE userId = " . (int)$searchResult[ $key ]["id"] . " ORDER BY insDate DESC LIMIT 0,1";
			$onlineRow = $DB->GetRow( $q, FALSE, TRUE );
			if ( ( time() - $onlineRow["unixTime"] ) < 900 && $onlineRow["unixTime"] > 0 )
			{
				$searchResult[ $key ]["online"] = "Online";
			}
			else
			{
				if ( $onlineRow["unixTime"] > 0 )
				{
					$searchResult[ $key ]["online"] = $onlineRow["unixTime"];
				}
				else
				{
					$searchResult[ $key ]["online"] = "never";
				}
			}			

			unset( $onlineTime );
			if ( $searchResult[ $key ]["online"] == "Online" )
			{
				$onlineTime = "<div class=\"email_date\">Online</div>";
			} elseif ( $searchResult[ $key ]["online"] == "never" )
			{
				$onlineTime = "<div class=\"email_date\">Aldrig inloggad</div>";
			}
			else
			{
				// Possible date-types: Today, Yesterday, ThisYear, LastYear
				if ( date("Y-m-d", $searchResult[ $key ]["online"] ) == date( "Y-m-d" ) )
				{
					// Message sent today
					$onlineTime = "<div class=\"email_date\">Senast inloggad: " . "Idag kl " . date( "H:i", $searchResult[ $key ]["online"] ) . "</div>";
				}
				elseif ( date("Y-m-d", $searchResult[ $key ]["online"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
				{
					// Message sent yesterday
					$onlineTime = "<div class=\"email_date\">Senast inloggad: " . "Ig&aring;r kl " . date( "H:i", $searchResult[ $key ]["online"] ) . "</div>";
				}
				elseif ( date("Y", $searchResult[ $key ]["online"] ) == date( "Y" ) )
				{
					// Message sent this year
					$onlineTime = "<div class=\"email_date\">Senast inloggad: " . date( "j M Y H:i", $searchResult[ $key ]["online"] ) . "</div>";
				}
				else
				{
					$onlineTime = "<div class=\"email_date\">Senast inloggad: " . date( "Y-m-d H:i", $searchResult[ $key ]["online"] ) . "</div>";
				}
			}
if ((int)$_SESSION["rights"] > 1) {
$body.= "<tr>
 	<td style=\"width: 60px; padding-bottom: 30px;\" valign=\"top\"><a href=\"javascript:void(null)\" onClick=\"showImage2('popupMediumImage".$key."','" . $mediumAvatar . "', 'mediumProfileImage".$key."');\" style=\"font-weight: normal;\">" . $avatar . "</a></td>
 	<td style=\"padding-bottom: 30px;\" valign=\"top\"><a href=\"" . $baseUrl . "/user/" . $searchResult[ $key ]["username"] . ".html\">" . $searchResult[ $key ]["username"] . "</a> " . stripslashes($searchResult[ $key ]["status"]) . "<br />" . $onlineTime;
	$age = $searchResult[ $key ]["currAge"];


	$city = $cities[$searchResult[ $key ]["cityId"]]["city"];
	$body .= "<div class=\"email_date\">";
	if ((int)$age > 0 && strlen($city) > 0) {
	$body .= $age." år, ".$city."<br />";
	} elseif ((int)$age > 0) {
	$body .= $age." år<br />";
	} elseif (strlen($city) > 0) {
	$body .= "".$city."<br />";
	}
	$body .= "</div>";
	
	$body .= "<div style=\"position:relative;\"><div id=\"popupMediumImage".$key."\" style=\"display: none; position:absolute;border: 2px solid #645d54; top: 0px; left: 0px; z-index: 101; background-color: #ffffff; \"><div style=\"margin: 0px;\"><div style=\"float: left; display: block;\"><a href=\"javascript:void(null)\" onclick=\"closeImage2('popupMediumImage".$key."');\"><img src=\"".$baseUrl."/img/symbols/gif_avatars/person_avantar_stor.gif\" id=\"mediumProfileImage".$key."\" border=\"0\" style=\"margin: 3px;\" /></a></div></div></div></div></td>
 </tr>";
} else {
$body.= "<tr>
 	<td style=\"width: 60px; padding-bottom: 30px;\" valign=\"top\"><a href=\"#noexist\" onClick=\"showImage('popupMediumImage','" . $mediumAvatar . "');\" style=\"font-weight: normal;\">" . $avatar . "</a></td>
 	<td style=\"padding-bottom: 30px;\" valign=\"top\"><a href=\"" . $baseUrl . "/user/" . $searchResult[ $key ]["username"] . ".html\">" . $searchResult[ $key ]["username"] . "</a> " . $searchResult[ $key ]["status"] . "<br />" . $onlineTime . "</td>
 </tr>";
}
			
 $printed++;
		}
	}
	else
	{
		$body.= "<tr><td colspan=\"4\">Inga flator matchade din sökning. (" . htmlentities( stripslashes( $_REQUEST["SearchQuery"] ) ) . ")</td></tr>";
	}

	$body.= "</table>\n\n	<div id=\"divFooterSpace\" style=\"border: 0px;\">";

	// Paging
	if ( count( $searchResult ) > $numPerPage )
	{
		if ( (int)$_GET["offset"] > 0 )
		{
			$body.= "<div id=\"previous\"><a href=\"" . $baseUrl . "/search.html?offset=" . ( (int)$_GET["offset"] - $numPerPage ) . "&order=" . $_GET["order"] . "&SearchQuery=" . $_REQUEST["SearchQuery"] . "\">F&ouml;reg&aring;ende sida</a></div>";
		}
		else
		{
			$body.= "<div id=\"previous\">&nbsp;</div>\n";
		}
		$body.= "<div id=\"middle\" style=\"text-align: center;\"><b>" . $printed . "</b> av <b>". count( $searchResult ) . "</b></div>\n";
		if ( $i < count( $searchResult ) )
		{
			$body.= "<div id=\"next\"><a href=\"" . $baseUrl . "/search.html?offset=" . $i . "&order=" . $_GET["order"] . "&SearchQuery=" . $_REQUEST["SearchQuery"] . "\">N&auml;sta sida</a></div>";
		}
	}
	else
	{
		$body.= "<div id=\"previous\">&nbsp;</div><div id=\"middle\" style=\"text-align: center;\"><b>" .  $printed  . "</b> av <b>" . count( $searchResult ) . "</b></div>\n";		
	}

	$body.= "&nbsp;</div></p></form>

</div>

<div id=\"right\">";

	$body.= rightMenu('topLists');
$body.= "</div>";

}
?>