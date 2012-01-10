<?php
$metaTitle = "Flator.se - Mina sidor - Meddelanden - Utbox";
$numPerPage = 50;

if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/utbox.html";
	include( "login_new.php" );
}
else
{
	$currentLink = array();
	$q = "SELECT fl_messages.*, fl_users.username, UNIX_TIMESTAMP( fl_messages.insDate ) AS unixTime FROM fl_messages LEFT JOIN fl_users ON fl_users.id = fl_messages.recipentUserId WHERE fl_messages.senderDeleted = 'NO' AND fl_messages.userId = " . (int)$_SESSION["userId"] . " ";

	// Search inbox
	if ( strlen( $_POST["mailSearchQuery"] ) > 0 )
	{
		$q.= " AND (fl_messages.subject LIKE '%" . addslashes( $_POST["mailSearchQuery"] ) . "%' OR fl_messages.message LIKE '%" . addslashes( $_POST["mailSearchQuery"] ) . "%' OR fl_users.username LIKE '%" . addslashes( $_POST["mailSearchQuery"] ) . "%') ";
	}

	if ( $_GET["sortBy"] == "username" )
	{
		$q.= "ORDER BY fl_users.username ASC, fl_messages.insDate DESC";
		$currentLink["username"] = " class=\"current\"";
	}
	elseif ( $_GET["sortBy"] == "unRead" )
	{
		$q.= "ORDER BY fl_messages.newMessage ASC, fl_messages.insDate DESC";
		$currentLink["unRead"] = " class=\"current\"";
	}
	elseif ( $_GET["sortBy"] == "read" )
	{
		$q.= "ORDER BY fl_messages.newMessage DESC, fl_messages.insDate DESC";
		$currentLink["read"] = " class=\"current\"";
	}
	else
	{
		$q.= "ORDER BY fl_messages.insDate DESC";
		$currentLink["date"] = " class=\"current\"";
	}
	$mailArray = $DB->GetAssoc( $q, FALSE, TRUE );

#	for( $i = 0; $i < 155; $i++ )
#	{
#		$mailArray[ $i+20 ]["username"] = $i;
#	}




	$body = "<div id=\"center\">
<form name=\"form\" style=\"margin: 0px; padding: 0px\" method=\"post\" action=\"" . $baseUrl . "/delete_message.html\" onSubmit=\"confirmSubmit('Ta bort markerade meddelanden?', 'form')\">
	<div id=\"divHeadSpace\">";
	if ( count( $mailArray ) > 0 )
	{
		$body.= "		<div id=\"headLinks\" style=\"width: 225px\"><span onMouseOver=\"document.deleteMail.src='img/symbols/gif_red/radera.gif'\" onMouseOut=\"document.deleteMail.src='img/symbols/gif_purple/radera.gif'\"><a href=\"#noexist\" onClick=\"confirmSubmit('Ta bort markerade meddelanden?', 'form');\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/radera.gif\" name=\"deleteMail\" align=\"ABSMIDDLE\" border=\"0\" />Radera</a></span>		</div>";
	}
	$body.= "
	&nbsp;</div>

<p>
<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-size: 12px\">";

	if ( count( $mailArray ) > 0 )
	{
		$i = (int)$_GET["offset"];
		$i2 = 0;

		while ( list( $key, $value ) = each( $mailArray ) )
		{
			$i2++;
			if ( $i2 <= (int)$_GET["offset"] ) continue;
			if ( $i2 > ( (int)$_GET["offset"] + $numPerPage ) ) break;

			$i++;

			unset( $messageTime );
			// Possible date-types: Today, Yesterday, ThisYear, LastYear

			if ( date("Y-m-d", $mailArray[ $key ]["unixTime"] ) == date( "Y-m-d" ) )
			{
				// Message sent today
				$messageTime = "Idag kl " . date( "H:i", $mailArray[ $key ]["unixTime"] );
			}
			elseif ( date("Y-m-d", $mailArray[ $key ]["unixTime"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
			{
				// Message sent yesterday
				$messageTime = "Ig&aring;r kl " . date( "H:i", $mailArray[ $key ]["unixTime"] );
			}
			elseif ( date("Y", $mailArray[ $key ]["unixTime"] ) == date( "Y" ) )
			{
				// Message sent this year
				$messageTime = date( "j M Y H:i", $mailArray[ $key ]["unixTime"] );
			}
			else
			{
				$messageTime = date( "Y-m-d H:i", $mailArray[ $key ]["unixTime"] );
			}

			unset( $messageSnippet );
			$messageSnippet = strip_tags( $mailArray[ $key ]["message"] );
			if ( strlen( $messageSnippet ) > 60 )
			{
				$messageSnippet = substr( $messageSnippet, 0, 57 ) . "...";
			}
			
			$messageRead = " style=\"font-weight: normal\"";
			$mailIcon = "&nbsp;";

			$q = "SELECT * FROM fl_images WHERE userId = " . (int)$mailArray[ $key ]["recipentUserId"] . " AND imageType = 'profileSmall'";
			$mailImage = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $mailImage ) > 0 )
			{
				$avatar = "<img src=\"" . $baseUrl . "/user-photos/" . str_replace('http://www.flator.se/rwdx/user/', '', $mailImage["imageUrl"]) . "/profile-thumb/" . "\" border=\"0\"  />";
			}
			else
			{
				$avatar = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/person_avnatar_liten.gif\" border=\"0\" width=\"26\" height=\"29\" />";
			}

			$q = "SELECT * FROM fl_images WHERE userId = " . (int)$mailArray[ $key ]["recipentUserId"] . " AND imageType = 'profileMedium'";
			$guestImage = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $guestImage ) > 0 )
			{
				$mediumAvatar = $guestImage["imageUrl"];
			}
			else
			{
				$mediumAvatar = $baseUrl . "/img/symbols/gif_avatars/person_avantar_stor.gif";
			}

			$body.= "<tr>
 	<td style=\"width: 20px; padding-bottom: 20px\" valign=\"top\">" . $mailIcon . "</td>
 	<td style=\"width: 30px; padding-bottom: 20px\" valign=\"top\"><input type=\"checkbox\" name=\"senderId[]\" value=\"" . $mailArray[ $key ]["id"] . "\"></td>
 	<td style=\"width: 50px; padding-bottom: 20px\" valign=\"top\"><a href=\"#noexist\" onClick=\"showImage('popupMediumImage','" . $mediumAvatar . "');\" style=\"font-weight: normal\">" . $avatar . "</a></td>
 	<td style=\"width: 145px; padding-bottom: 20px\" valign=\"top\"><a href=\"" . $baseUrl . "/user/" . $mailArray[ $key ]["username"] . ".html\" style=\"font-weight: normal\">" . $mailArray[ $key ]["username"] . "</a><br /><div class=\"email_date\">" . $messageTime . "</div></td>
  	<td style=\"padding-bottom: 20px\" valign=\"top\"><a href=\"" . $baseUrl . "/mess/" . $mailArray[ $key ]["id"] . ".html?type=outbox\"" . $messageRead . ">" . $mailArray[ $key ]["subject"] . "</a><div class=\"other_link\"><a href=\"" . $baseUrl . "/mess/" . $mailArray[ $key ]["id"] . ".html?type=outbox\">" . $messageSnippet . "</a></div></td>
 </tr>";
		}
	}
	else
	{
		if ( strlen( $_POST["mailSearchQuery"] ) > 0 )
		{
			$body.= "<tr><td colspan=\"4\">Inga meddelanden matchade din sökning. (" . htmlentities( stripslashes( $_POST["mailSearchQuery"] ) ) . ")</td></tr>";
		}
		else
		{
			$body.= "<tr><td colspan=\"4\">Du har inga meddelanden i din utbox.</td></tr>";
		}
	}

	$body.= "</table>\n\n	<div id=\"divFooterSpace\">";

	// Paging
	if ( count( $mailArray ) > $numPerPage )
	{
		if ( (int)$_GET["offset"] > 0 )
		{
			$body.= "<div id=\"previous\"><a href=\"" . $baseUrl . "/inbox.html?offset=" . ( (int)$_GET["offset"] - $numPerPage ) . "&sortBy=" . (int)$_GET["sortBy"] . "\">F&ouml;reg&aring;ende sida</a></div>";
		}
		else
		{
			$body.= "<div id=\"previous\">&nbsp;</div>\n";
		}
		$body.= "<div id=\"middle\" style=\"text-align: center\"><b>" . $i2 . "</b> av <b>". count( $mailArray ) . "</b></div>\n";
		if ( $i < count( $mailArray ) )
		{
			$body.= "<div id=\"next\"><a href=\"" . $baseUrl . "/inbox.html?offset=" . $i . "&sortBy=" . (int)$_GET["sortBy"] . "\">N&auml;sta sida</a></div>";
		}
	}
	else
	{
		$body.= "<div id=\"previous\">&nbsp;</div><div id=\"middle\" style=\"text-align: center\"><b>" . count( $mailArray ) . "</b> av <b>" . count( $mailArray ) . "</b></div>\n";		
	}

	$body.= "&nbsp;</div></p></form>

</div>

<div id=\"right\">";
$body.= rightMenu('outbox');
$body.= "</div>";

}
?>