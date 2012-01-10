<?php
$metaTitle = "Flator.se - Mina sidor - Vänner";
$numPerPage = 50;

if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/friends.html";
	include( "login_new.php" );
}
else
{
	$q = "SELECT fl_friends.* FROM fl_friends WHERE fl_friends.approved = 'YES' AND ( fl_friends.userId = " . (int)$userPres["id"] . " OR  fl_friends.friendUserId = " . (int)$userPres["id"] . " )";
	$friends = $DB->GetAssoc( $q, FALSE, TRUE );
	if ( count( $friends ) > 0 )
	{
		while ( list( $key, $value ) = each( $friends ) )
		{
			if ( $friends[ $key ]["userId"] != (int)$userPres["id"] )
			{
				$friendUserId = $friends[ $key ]["userId"];
			}
			else
			{
				$friendUserId = $friends[ $key ]["friendUserId"];
			}

			if ( $page == "friends.html" )
			{
				// All friends
				$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_users WHERE id = " . (int)$friendUserId . " AND rights > 1";
				$userRow = $DB->GetRow( $q, FALSE, TRUE );
				$friends[ $key ]["username"] = $userRow["username"];
				#$friends[ $key ]["userId"] = $userRow["id"];
				$friends[ $key ]["userId"] = (int)$friendUserId;

				// Search friends
				if ( strlen( $_POST["friendSearchQuery"] ) > 0 )
				{
					if ( !eregi( $_POST["friendSearchQuery"], $friends[ $key ]["username"] ) )
					{
						unset( $friends[ $key ] );
						continue;
					}
				}

				$q = "SELECT * FROM fl_images WHERE userId = " . (int)$friendUserId . " AND imageType = 'profileSmall'";
				$profileImage = $DB->GetRow( $q, FALSE, TRUE );
				if ( count( $profileImage ) > 0 )
				{
					$avatar = "<img src=\"" . $baseUrl . "/user-photos/" . str_replace('http://www.flator.se/rwdx/user/', '', $profileImage["imageUrl"]) . "/profile-thumb/" . "\" border=\"0\"  />";

				}
				else
				{
					$avatar = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/person_avnatar_liten.gif\" border=\"0\" width=\"26\" height=\"29\" />";
				}
				$friends[ $key ]["avatar"] = $avatar;

				$q = "SELECT * FROM fl_images WHERE userId = " . (int)$friendUserId . " AND imageType = 'profileMedium'";
				$guestImage = $DB->GetRow( $q, FALSE, TRUE );
				if ( count( $guestImage ) > 0 )
				{
					$friends[ $key ]["mediumAvatar"] = $guestImage["imageUrl"];
				}
				else
				{
					$friends[ $key ]["mediumAvatar"] = $baseUrl . "/img/symbols/gif_avatars/person_avantar_stor.gif";
				}

				$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_status WHERE userId = " . (int)$friendUserId . " AND statusType = 'personalMessage' ORDER BY insDate DESC LIMIT 0,1";
				$statusRow = $DB->GetRow( $q, FALSE, TRUE );
				$friends[ $key ]["status"] = $statusRow["statusMessage"];

				$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_users_online WHERE userId = " . (int)$friendUserId . " ORDER BY insDate DESC LIMIT 0,1";
				$onlineRow = $DB->GetRow( $q, FALSE, TRUE );
				if ( ( time() - $onlineRow["unixTime"] ) < 300 && $onlineRow["unixTime"] > 0 )
				{
					$friends[ $key ]["online"] = "Online";
				}
				else
				{
					if ( $onlineRow["unixTime"] > 0 )
					{
						$friends[ $key ]["online"] = $onlineRow["unixTime"];
					}
					else
					{
						$friends[ $key ]["online"] = $userRow["unixTime"];
					}
				}
			}
			elseif ( $page == "friends_online.html" )
			{
				// Online friends
				$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_users_online WHERE userId = " . (int)$friendUserId . " ORDER BY insDate DESC LIMIT 0,1";
				$onlineRow = $DB->GetRow( $q, FALSE, TRUE );
				if ( ( time() - $onlineRow["unixTime"] ) < 300 && $onlineRow["unixTime"] > 0 )
				{
					$friends[ $key ]["online"] = "Online";
				}
				else
				{
					unset( $friends[ $key ] );
					continue;
				}

				$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_users WHERE id = " . (int)$friendUserId . " AND rights > 1";
				$userRow = $DB->GetRow( $q, FALSE, TRUE );
				$friends[ $key ]["username"] = $userRow["username"];
				#$friends[ $key ]["userId"] = $userRow["id"];
				$friends[ $key ]["userId"] = (int)$friendUserId;

				$q = "SELECT * FROM fl_images WHERE userId = " . (int)$friendUserId . " AND imageType = 'profileSmall'";
				$profileImage = $DB->GetRow( $q, FALSE, TRUE );
				if ( count( $profileImage ) > 0 )
				{
					$avatar = "<img src=\"" . $baseUrl . "/user-photos/" . str_replace('http://www.flator.se/rwdx/user/', '', $profileImage["imageUrl"]) . "/profile-thumb/" . "\" border=\"0\"  />";

				}
				else
				{
					$avatar = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/person_avnatar_liten.gif\" border=\"0\" width=\"26\" height=\"29\" />";
				}
				$friends[ $key ]["avatar"] = $avatar;

				$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_status WHERE userId = " . (int)$friendUserId . " AND statusType = 'personalMessage' ORDER BY insDate DESC LIMIT 0,1";
				$statusRow = $DB->GetRow( $q, FALSE, TRUE );
				$friends[ $key ]["status"] = $statusRow["statusMessage"];
			}
			elseif ( $page == "friends_updated.html" )
			{
				// Updated friends
				$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_status WHERE userId = " . (int)$friendUserId . " ORDER BY insDate DESC LIMIT 0,1";
				$updatedRow = $DB->GetRow( $q, FALSE, TRUE );
				if ( (int)$updatedRow["id"] < 1 )
				{
					unset( $friends[ $key ] );
					continue;
				}
				else
				{
					$friends[ $key ]["status"] = $statusRow["statusMessage"];
				}

				$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_users WHERE id = " . (int)$friendUserId . " AND rights > 1";
				$userRow = $DB->GetRow( $q, FALSE, TRUE );
				$friends[ $key ]["username"] = $userRow["username"];
				#$friends[ $key ]["userId"] = $userRow["id"];
				$friends[ $key ]["userId"] = (int)$friendUserId;

				$q = "SELECT * FROM fl_images WHERE userId = " . (int)$friendUserId . " AND imageType = 'profileSmall'";
				$profileImage = $DB->GetRow( $q, FALSE, TRUE );
				if ( count( $profileImage ) > 0 )
				{
					$avatar = "<img src=\"" . $baseUrl . "/user-photos/" . str_replace('http://www.flator.se/rwdx/user/', '', $profileImage["imageUrl"]) . "/profile-thumb/" . "\" border=\"0\"  />";
				}
				else
				{
					$avatar = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/person_avnatar_liten.gif\" border=\"0\" width=\"26\" height=\"29\" />";
				}
				$friends[ $key ]["avatar"] = $avatar;

				$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_users_online WHERE userId = " . (int)$friendUserId . " ORDER BY insDate DESC LIMIT 0,1";
				$onlineRow = $DB->GetRow( $q, FALSE, TRUE );
				if ( ( time() - $onlineRow["unixTime"] ) < 300 && $onlineRow["unixTime"] > 0 )
				{
					$friends[ $key ]["online"] = "Online";
				}
				else
				{
					if ( $onlineRow["unixTime"] > 0 )
					{
						$friends[ $key ]["online"] = $onlineRow["unixTime"];
					}
					else
					{
						$friends[ $key ]["online"] = $userRow["unixTime"];
					}
				}
			}
			elseif ( $page == "friends_common.html" )
			{
				// Common friends
				$commonFriends = array();
				$q = "SELECT fl_friends.* FROM fl_friends WHERE fl_friends.approved = 'YES' AND ( fl_friends.userId = " . (int)$_SESSION["userId"] . " OR  fl_friends.friendUserId = " . (int)$_SESSION["userId"] . " )";
				$myFriends = $DB->GetAssoc( $q, FALSE, TRUE );
				if ( count( $myFriends ) > 0 )
				{
					while ( list( $keyCommon, $valueCommon ) = each( $myFriends ) )
					{
						if ( $myFriends[ $keyCommon ]["userId"] != (int)$_SESSION["userId"] )
						{
							$myFriendUserId = $myFriends[ $keyCommon ]["userId"];
						}
						else
						{
							$myFriendUserId = $myFriends[ $keyCommon ]["friendUserId"];
						}
						$commonFriends[ $myFriendUserId ] = TRUE;
					}
				}

				if ( !$commonFriends[ $friendUserId ] )
				{
					unset( $friends[ $key ] );
					continue;
				}

				$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_users WHERE id = " . (int)$friendUserId . " AND rights > 1";
				$userRow = $DB->GetRow( $q, FALSE, TRUE );
				$friends[ $key ]["username"] = $userRow["username"];
				#$friends[ $key ]["userId"] = $userRow["id"];
				$friends[ $key ]["userId"] = (int)$friendUserId;

				$q = "SELECT * FROM fl_images WHERE userId = " . (int)$friendUserId . " AND imageType = 'profileSmall'";
				$profileImage = $DB->GetRow( $q, FALSE, TRUE );
				if ( count( $profileImage ) > 0 )
				{
					$avatar = "<img src=\"" . $baseUrl . "/user-photos/" . str_replace('http://www.flator.se/rwdx/user/', '', $profileImage["imageUrl"]) . "/profile-thumb/" . "\" border=\"0\"  />";
				}
				else
				{
					$avatar = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/person_avnatar_liten.gif\" border=\"0\" width=\"26\" height=\"29\" />";
				}
				$friends[ $key ]["avatar"] = $avatar;

				$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_status WHERE userId = " . (int)$friendUserId . " AND statusType = 'personalMessage' ORDER BY insDate DESC LIMIT 0,1";
				$statusRow = $DB->GetRow( $q, FALSE, TRUE );
				$friends[ $key ]["status"] = $statusRow["statusMessage"];

				$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_users_online WHERE userId = " . (int)$friendUserId . " ORDER BY insDate DESC LIMIT 0,1";
				$onlineRow = $DB->GetRow( $q, FALSE, TRUE );
				if ( ( time() - $onlineRow["unixTime"] ) < 300 && $onlineRow["unixTime"] > 0 )
				{
					$friends[ $key ]["online"] = "Online";
				}
				else
				{
					if ( $onlineRow["unixTime"] > 0 )
					{
						$friends[ $key ]["online"] = $onlineRow["unixTime"];
					}
					else
					{
						$friends[ $key ]["online"] = $userRow["unixTime"];
					}
				}
			}
		}
	}


	$body = "<div id=\"center\">
<form name=\"form\" style=\"margin: 0px; padding: 0px\" method=\"post\">
	<div id=\"divHeadSpace\">";
	if ( count( $friends ) > 0 )
	{

		if ( $editFriends == TRUE )
		{
					$body.= "<div id=\"headLinks\" style=\"width: 210px\"><span onMouseOver=\"document.messageMultipleFriends.src='" . $baseUrl . "/img/symbols/gif_red/skicka.gif'\" onMouseOut=\"document.messageMultipleFriends.src='" . $baseUrl . "/img/symbols/gif_purple/skicka.gif'\"><a href=\"#noexist\" onClick=\"location='" . $baseUrl . "/new_message.html?recipentUserIds=' + checkboxValues(document.form.friendUserId)\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/skicka.gif\" name=\"messageMultipleFriends\" align=\"ABSMIDDLE\" border=\"0\" />Skicka meddelande till flera</a></span></div>";
		$body.= "<div id=\"headLinks\" style=\"width: 125px\"><span onMouseOver=\"document.selectAllFriends.src='" . $baseUrl . "/img/symbols/gif_red/alla.gif'\" onMouseOut=\"document.selectAllFriends.src='" . $baseUrl . "/img/symbols/gif_purple/alla.gif'\"><a href=\"#noexist\" onClick=\"checkAll(document.form.friendUserId)\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/alla.gif\" name=\"selectAllFriends\" align=\"ABSMIDDLE\" border=\"0\" />Markera alla</a></span></div>";

			$body.= "<div id=\"headLinks\" style=\"width: 125px\"><span onMouseOver=\"document.deleteMultipleFriends.src='" . $baseUrl . "/img/symbols/gif_red/radera.gif'\" onMouseOut=\"document.deleteMultipleFriends.src='" . $baseUrl . "/img/symbols/gif_purple/radera.gif'\"><a href=\"#noexist\" OnClick=\"if(confirm('Ta bort markerade vänner?')) { location='" . $baseUrl . "/delete_friends.html?userIds=' + checkboxValues(document.form.friendUserId); } else { return false; }\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/radera.gif\" name=\"deleteMultipleFriends\" align=\"ABSMIDDLE\" border=\"0\" />Ta bort vän</a></span></div>";
		}
	}
	$body.= "
&nbsp;</div>

<p>
<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-size: 12px\">";
$body .= "<input type=\"checkbox\" style=\"display:none\" name=\"friendUserId\" value=\"xx\" checked>";
	reset( $friends );
	if ( count( $friends ) > 0 )
	{
		$i = (int)$_GET["offset"];
		$i2 = 0;

		while ( list( $key, $value ) = each( $friends ) )
		{
			$i2++;
			if ( $i2 <= (int)$_GET["offset"] ) continue;
			if ( $i2 > ( (int)$_GET["offset"] + $numPerPage ) ) break;

			$i++;

			unset( $onlineTime );
			if ( $friends[ $key ]["online"] == "Online" )
			{
				$onlineTime = "<div class=\"email_date\">Online</div>";
			}
			else
			{
				// Possible date-types: Today, Yesterday, ThisYear, LastYear
				if ( date("Y-m-d", $friends[ $key ]["online"] ) == date( "Y-m-d" ) )
				{
					// Message sent today
					$onlineTime = "<div class=\"email_date\">" . "Idag kl " . date( "H:i", $friends[ $key ]["online"] ) . "</div>";
				}
				elseif ( date("Y-m-d", $friends[ $key ]["online"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
				{
					// Message sent yesterday
					$onlineTime = "<div class=\"email_date\">" . "Ig&aring;r kl " . date( "H:i", $friends[ $key ]["online"] ) . "</div>";
				}
				elseif ( date("Y", $friends[ $key ]["online"] ) == date( "Y" ) )
				{
					// Message sent this year
					$onlineTime = "<div class=\"email_date\">" . date( "j M Y H:i", $friends[ $key ]["online"] ) . "</div>";
				}
				else
				{
					$onlineTime = "<div class=\"email_date\">" . date( "Y-m-d H:i", $friends[ $key ]["online"] ) . "</div>";
				}
			}

			$body.= "<tr>
 	<td style=\"width: 20px; padding-bottom: 10px\" valign=\"top\">";
		if ( $editFriends == TRUE )
		{
	
	$body .= "<input type=\"checkbox\" name=\"friendUserId\" value=\"" . $friends[ $key ]["userId"] . "\">";
		}
	$body .= "</td>
 	<td style=\"width: 50px; padding-bottom: 10px\" valign=\"top\"><a href=\"#noexist\" onClick=\"showImage2('popupMediumStatusImage".$key."','" . $friends[ $key ]["mediumAvatar"] . "', 'mediumStatusImage".$key."');\"  style=\"font-weight: normal\">" . $friends[ $key ]["avatar"] . "</a>";
						$body .= "<div style=\"position:relative;\"><div id=\"popupMediumStatusImage".$key."\" style=\"display: none; position:absolute;border: 2px solid #645d54; top: 0px; left: 0px; z-index: 101; background-color: #ffffff; \"><div style=\"margin: 0px;\"><div style=\"float: left; display: block;\"><a href=\"javascript:void(null)\" onclick=\"closeImage2('popupMediumStatusImage".$key."');\"><img src=\"".$baseUrl."/img/symbols/gif_avatars/person_avantar_stor.gif\" id=\"mediumStatusImage".$key."\" border=\"0\" style=\"margin: 3px;\" /></a></div></div></div></div>";
						$body .= "</td>
 	<td style=\"width: 305px; padding-bottom: 5px\" valign=\"top\"><a href=\"" . $baseUrl . "/user/" . $friends[ $key ]["username"] . ".html\">" . $friends[ $key ]["username"] . "</a> " . $friends[ $key ]["status"] . "<br />" . $onlineTime . "</td>
 	<td style=\"width: 200px; padding-bottom: 10px\" valign=\"top\"><span style=\"line-height: 19px\" onMouseOver=\"document.messageFriends" . $friends[ $key ]["id"] . ".src='" . $baseUrl . "/img/symbols/gif_red/skicka.gif'\" onMouseOut=\"document.messageFriends" . $friends[ $key ]["id"] . ".src='" . $baseUrl . "/img/symbols/gif_purple/skicka.gif'\"><a href=\"" . $baseUrl . "/new_message.html?userId=" . $friends[ $key ]["userId"] . "\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/skicka.gif\" name=\"messageFriends" . $friends[ $key ]["id"] . "\" align=\"ABSMIDDLE\" border=\"0\" />Skicka ett meddelande</a></span>
 	<br /><span style=\"line-height: 19px\" onMouseOver=\"document.seeFriends" . $friends[ $key ]["id"] . ".src='" . $baseUrl . "/img/symbols/gif_red/van.gif'\" onMouseOut=\"document.seeFriends" . $friends[ $key ]["id"] . ".src='" . $baseUrl . "/img/symbols/gif_purple/van.gif'\"><a href=\"" . $baseUrl . "/friends/" . $friends[ $key ]["username"] . ".html\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/van.gif\" name=\"seeFriends" . $friends[ $key ]["id"] . "\" align=\"ABSMIDDLE\" border=\"0\" />Se " . $friends[ $key ]["username"] . "s vänner</a></span></td>
 </tr>";
			$body.= "<tr>
 	<td colspan=\"4\" style=\"padding: 0px; border-top: 1px dotted #c8c8c8;line-height:2px;font-size:2px;height:10px;\" valign=\"top\">&nbsp;</td>
 </tr>";
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
	if ( count( $friends ) > $numPerPage )
	{
		if ( (int)$_GET["offset"] > 0 )
		{
			$body.= "<div id=\"previous\"><a href=\"" . $baseUrl . "/" . $page . "?offset=" . ( (int)$_GET["offset"] - $numPerPage ) . "&sortBy=" . (int)$_GET["sortBy"] . "\">F&ouml;reg&aring;ende sida</a></div>";
		}
		else
		{
			$body.= "<div id=\"previous\">&nbsp;</div>\n";
		}
		$body.= "<div id=\"middle\" style=\"text-align: center\"><b>" . $i2 . "</b> av <b>". count( $friends ) . "</b></div>\n";
		if ( $i < count( $friends ) )
		{
			$body.= "<div id=\"next\"><a href=\"" . $baseUrl . "/" . $page . "?offset=" . $i . "&sortBy=" . (int)$_GET["sortBy"] . "\">N&auml;sta sida</a></div>";
		}
	}
	else
	{
		$body.= "<div id=\"previous\">&nbsp;</div><div id=\"middle\" style=\"text-align: center\"><b>" . count( $friends ) . "</b> av <b>" . count( $friends ) . "</b></div>\n";		
	}

	$body.= "&nbsp;</div></p></form>

</div>

<div id=\"right\">";
if ( $editFriends == TRUE )
{
	$body.= rightMenu('friends');
}
else
{
	$body.= rightMenu('userFriends');
}
$body.= "</div>";

}
?>