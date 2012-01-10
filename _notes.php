<?php
$metaTitle = "Flator.se - Nya notes";
$numPerPage = 50;

if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/notes.html";
	include( "login_new.php" );
}
else
{
	$body = "<div id=\"center\">";
if ( count( $friendApproveList ) > 0 )
	{
	$body .= "<div id=\"divHeadSpace\"><h3 style=\"line-height: 28px\">Godkänn vänskap</h3></div>

<p>
<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-size: 12px\">";

	
		while ( list( $key, $value ) = each( $friendApproveList ) )
		{
			$q = "SELECT * FROM fl_images WHERE userId = " . (int)$friendApproveList[ $key ]["userId"] . " AND imageType = 'profileSmall'";
			$friendImage = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $friendImage ) > 0 )
			{
				$avatar = "<img src=\"" . $friendImage["imageUrl"] . "\" border=\"0\" width=\"" . $friendImage["width"] . "\" height=\"" . $friendImage["height"] . "\" />";
			}
			else
			{
				$avatar = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/person_avnatar_liten.gif\" border=\"0\" width=\"26\" height=\"29\" />";
			}

			$q = "SELECT * FROM fl_images WHERE userId = " . (int)$friendApproveList[ $key ]["userId"] . " AND imageType = 'profileMedium'";
			$guestImage = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $guestImage ) > 0 )
			{
				$mediumAvatar = $guestImage["imageUrl"];
			}
			else
			{
				$mediumAvatar = $baseUrl . "/img/symbols/gif_avatars/person_avantar_stor.gif";
			}

				// Possible date-types: Today, Yesterday, ThisYear, LastYear
				if ( date("Y-m-d", $friendApproveList[ $key ]["unixTime"] ) == date( "Y-m-d" ) )
				{
					// Message sent today
					$onlineTime = "<div class=\"email_date\">" . "Idag kl " . date( "H:i", $friendApproveList[ $key ]["unixTime"] ) . "</div>";
				}
				elseif ( date("Y-m-d", $friendApproveList[ $key ]["unixTime"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
				{
					// Message sent yesterday
					$onlineTime = "<div class=\"email_date\">" . "Ig&aring;r kl " . date( "H:i", $friendApproveList[ $key ]["unixTime"] ) . "</div>";
				}
				elseif ( date("Y", $friendApproveList[ $key ]["unixTime"] ) == date( "Y" ) )
				{
					// Message sent this year
					$onlineTime = "<div class=\"email_date\">" . date( "j M Y H:i", $friendApproveList[ $key ]["unixTime"] ) . "</div>";
				}
				else
				{
					$onlineTime = "<div class=\"email_date\">" . date( "Y-m-d H:i", $friendApproveList[ $key ]["unixTime"] ) . "</div>";
				}

			$body.= "<tr>
 	<td style=\"width: 30px; padding-bottom: 10px\" valign=\"top\"><a href=\"#noexist\" onClick=\"showImage('popupMediumImage','" . $mediumAvatar . "');\" style=\"font-weight: normal\">" . $avatar . "</a></td>
 	<td style=\"width: 305px; padding-bottom: 10px\" valign=\"top\"><a href=\"" . $baseUrl . "/user/" . $friendApproveList[ $key ]["username"] . ".html\">" . $friendApproveList[ $key ]["username"] . "</a><br />" . $onlineTime . "</td>
 	<td style=\"width: 200px; padding-bottom: 10px\" valign=\"top\"><span style=\"line-height: 19px\" onMouseOver=\"document.approveFriend" . $friendApproveList[ $key ]["userId"] . ".src='" . $baseUrl . "/img/symbols/gif_red/van.gif'\" onMouseOut=\"document.approveFriend" . $friendApproveList[ $key ]["userId"] . ".src='" . $baseUrl . "/img/symbols/gif_purple/van.gif'\"><a href=\"" . $baseUrl . "/approve_friends.html?userIds=message," . $friendApproveList[ $key ]["userId"] . "\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/van.gif\" name=\"approveFriend" . $friendApproveList[ $key ]["userId"] . "\" align=\"ABSMIDDLE\" border=\"0\" />Godkänn förfrågan om vänskap</a></span>
 	<br /><span style=\"line-height: 19px\" onMouseOver=\"document.denyFriend" . $friendApproveList[ $key ]["userId"] . ".src='" . $baseUrl . "/img/symbols/gif_red/kryss.gif'\" onMouseOut=\"document.denyFriend" . $friendApproveList[ $key ]["userId"] . ".src='" . $baseUrl . "/img/symbols/gif_purple/kryss.gif'\"><a href=\"" . $baseUrl . "/delete_friends.html?userIds=message," . $friendApproveList[ $key ]["userId"] . "\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/kryss.gif\" name=\"denyFriend" . $friendApproveList[ $key ]["userId"] . "\" align=\"ABSMIDDLE\" border=\"0\" />Neka förfrågan om vänskap</a></span></td>
 </tr>";
			$body.= "<tr>
 	<td colspan=\"4\" style=\"padding-bottom: 5px; border-top: 1px dotted #c8c8c8;\" valign=\"top\">&nbsp;</td>
 </tr>";
		}
	

	$body.= "</table>\n\n";
}




if ( count( $newWallList ) > 0 )
	{

	$body .= "	<div id=\"divHeadSpace\"><h3 style=\"line-height: 28px\">Nya meddelanden på din vägg</h3></div>
<p><table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-size: 12px\">";

	if ( count( $newWallList ) > 1 )
	{
		$body.= "<tr><td colspan=\"4\">Du har ".$newWall." nya meddelanden på din vägg.<br><a href=\"".$baseUrl."/user/".$userProfile["username"].".html\">Gå till din vägg</a></td></tr>";
	} elseif ( count( $newWallList ) > 0 )
	{
		$body.= "<tr><td colspan=\"4\">Du har ".$newWall." nytt meddelanden på din vägg.<br><a href=\"".$baseUrl."/user/".$userProfile["username"].".html\">Gå till din vägg</a></td></tr>";
	}

	$body.= "</table></p>\n\n";
	}
	
	$body .= "<div id=\"divFooterSpace\" style=\"border: 0px\">";

	$body.= "&nbsp;</div></p></form>

</div>

<div id=\"right\">";
$body.= rightMenu('notes');
$body.= "</div>";

}
?>