<?php
$metaTitle = "Flator.se - Mina sidor - Meddelanden - Inbox";
$numPerPage = 10;

if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/inbox.html";
	include( "login_new.php" );
}
else
{
	$currentLink = array();
	$limitQuery = " LIMIT ".((int)$_GET["offset"] > 0 ? (int)$_GET["offset"].', '.$numPerPage : $numPerPage);
	$q = "SELECT fl_messages.*, 
(CASE WHEN fl_messages.userId != '" . (int)$_SESSION["userId"] . "' 
 THEN fl_messages.userId ELSE fl_messages.recipentUserId END) as realOpponent, MAX( fl_messages.id ) AS maxId FROM fl_messages WHERE ((fl_messages.userId = " . (int)$_SESSION["userId"] . " AND fl_messages.senderDeleted = 'NO' AND fl_messages.recipentUserId != " . (int)$_SESSION["userId"].") OR (fl_messages.recipentUserId = " . (int)$_SESSION["userId"] . " AND fl_messages.deleted = 'NO' AND fl_messages.userId != " . (int)$_SESSION["userId"].")) ";
	

	#$q = "SELECT fl_messages.*, MAX(fl_messages.id) as maxId, fl_users.username, UNIX_TIMESTAMP( fl_messages.insDate ) AS unixTime FROM fl_messages LEFT JOIN fl_users ON fl_users.id = fl_messages.userId WHERE fl_messages.deleted = 'NO' AND fl_messages.recipentUserId = " . (int)$_SESSION["userId"] . " ";

	// Search inbox
	if ( strlen( $_POST["mailSearchQuery"] ) > 0 )
	{
		$q.= " AND (fl_messages.subject LIKE '%" . addslashes( $_POST["mailSearchQuery"] ) . "%' OR fl_messages.message LIKE '%" . addslashes( $_POST["mailSearchQuery"] ) . "%') ";
	}
$q .= " GROUP BY realOpponent ";
	if ( $_GET["sortBy"] == "username" )
	{
		$q.= "ORDER BY fl_users.username ASC, fl_messages.insDate DESC";
		$currentLink["username"] = " class=\"current\"";
	}
	elseif ( $_GET["sortBy"] == "unRead" )
	{
		$q.= "ORDER BY fl_messages.newMessage DESC, fl_messages.insDate DESC";
		$currentLink["unRead"] = " class=\"current\"";
	}
	elseif ( $_GET["sortBy"] == "read" )
	{
		$q.= "ORDER BY fl_messages.newMessage DESC, fl_messages.insDate DESC";
		$currentLink["read"] = " class=\"current\"";
	}
	else
	{
		$q.= "ORDER BY maxId DESC";
		$currentLink["date"] = " class=\"current\"";
	}
	#echo $q."<BR />";
	$qCount = "SELECT COUNT(id) FROM (".$q.") as f";
	$mailArray = $DB->GetAssoc( $q.$limitQuery, FALSE, TRUE );
	$countResult = $DB->GetRow( $qCount, FALSE, TRUE );

#	for( $i = 0; $i < 155; $i++ )
#	{
#		$mailArray[ $i+20 ]["username"] = $i;
#	}


#print_r($mailArray);

	$body = "<div id=\"center\">
<form name=\"form\" style=\"margin: 0px; padding: 0px\" method=\"post\" action=\"" . $baseUrl . "/delete_message.html\" onSubmit=\"confirmSubmit('Ta bort markerade konversationer?', 'form')\">
	<div id=\"divHeadSpace\">";
	if ( count( $mailArray ) > 0 )
	{
		$body.= "		<div id=\"headLinks\" style=\"width: 225px\"><span onMouseOver=\"document.deleteMail.src='img/symbols/gif_red/radera.gif'\" onMouseOut=\"document.deleteMail.src='img/symbols/gif_purple/radera.gif'\"><a href=\"#noexist\" onClick=\"confirmSubmit('Ta bort markerade konversationer?', 'form');\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/radera.gif\" name=\"deleteMail\" align=\"ABSMIDDLE\" border=\"0\" />Radera</a></span>		</div>";
	}
	$body.= "
	&nbsp;</div>

<p>
<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-size: 12px\">";

	if ( count( $mailArray ) > 0 )
	{
$printed = 0;
		$shownUsers = array();
		while ( list( $key, $value ) = each( $mailArray ) )
		{

			$q = "SELECT fl_messages.*, fl_users.username, UNIX_TIMESTAMP( fl_messages.insDate ) AS unixTime FROM fl_messages LEFT JOIN fl_users ON fl_users.id = " . (int)$mailArray[ $key ]["realOpponent"]." WHERE ((fl_messages.userId = " . (int)$_SESSION["userId"] . " AND fl_messages.senderDeleted = 'NO' AND fl_messages.recipentUserId = " . (int)$mailArray[ $key ]["realOpponent"].") OR (fl_messages.recipentUserId = " . (int)$_SESSION["userId"] . " AND fl_messages.deleted = 'NO' AND fl_messages.userId = " . (int)$mailArray[ $key ]["realOpponent"].")) ORDER BY ID DESC LIMIT 1";
			#echo $q."<BR />";
			$rowMessage = $DB->GetRow( $q, FALSE, TRUE );
			#if ($rowMessage["username"] == "") continue;

			unset( $messageTime );
			// Possible date-types: Today, Yesterday, ThisYear, LastYear

			if ( date("Y-m-d", $rowMessage["unixTime"] ) == date( "Y-m-d" ) )
			{
				// Message sent today
				$messageTime = "Idag kl " . date( "H:i", $rowMessage["unixTime"] );
			}
			elseif ( date("Y-m-d", $rowMessage["unixTime"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
			{
				// Message sent yesterday
				$messageTime = "Ig&aring;r kl " . date( "H:i", $rowMessage["unixTime"] );
			}
			elseif ( date("Y", $rowMessage["unixTime"] ) == date( "Y" ) )
			{
				// Message sent this year
				$messageTime = date( "j M Y H:i", $rowMessage["unixTime"] );
			}
			else
			{
				$messageTime = date( "Y-m-d H:i", $rowMessage["unixTime"] );
			}

			if ((int)$rowMessage["userId"] == (int)$_SESSION["userId"]) {
				$rowMessage["userId"] = $rowMessage["recipentUserId"];
				$rowMessage["message"] = "Du svarade: ".$rowMessage["message"];
			}


			unset( $messageSnippet );
			$messageSnippet = strip_tags( $rowMessage["message"] );
			if ( strlen( $messageSnippet ) > 60 )
			{
				$messageSnippet = substr( $messageSnippet, 0, 57 ) . "...";
			}
			
			unset( $messageRead );
			unset( $mailIcon );
			if ( $rowMessage["newMessage"] == "NO" )
			{
				$messageRead = " style=\"font-weight: normal\"";
				$mailIcon = "&nbsp;";
			}
			else
			{
				$mailIcon = "<img src=\"" . $baseUrl . "/img/symbols/gif_purple/mejl_som_ar_nytt.gif\" border=\"0\" align=\"ABSMIDDLE\" />";
			}
			if ( $rowMessage["recipentReplied"] == "YES" )
			{
				$mailIcon = "<img src=\"" . $baseUrl . "/img/symbols/gif_purple/mejl_man_svarat_pa.gif\" border=\"0\" align=\"ABSMIDDLE\" />";
			}
			

			$q = "SELECT * FROM fl_images WHERE userId = " . (int)$rowMessage["userId"] . " AND imageType = 'profileSmall'";
			$mailImage = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $mailImage ) > 0 )
			{
				$avatar = "<img src=\"" . $baseUrl . "/user-photos/" . str_replace('http://www.flator.se/rwdx/user/', '', $mailImage["imageUrl"]) . "/profile-thumb/" . "\" border=\"0\"  />";

			}
			else
			{
				$avatar = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/person_avnatar_liten.gif\" border=\"0\" width=\"26\" height=\"29\" />";
			}

			$q = "SELECT * FROM fl_images WHERE userId = " . (int)$rowMessage["userId"] . " AND imageType = 'profileMedium'";
			$guestImage = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $guestImage ) > 0 )
			{
				$mediumAvatar = $guestImage["imageUrl"];
			}
			else
			{
				$mediumAvatar = $baseUrl . "/img/symbols/gif_avatars/person_avantar_stor.gif";
			}
if ($rowMessage["username"] != "") {
			$body.= "<tr>
 	<td style=\"width: 20px; padding-bottom: 20px\" valign=\"top\">" . $mailIcon . "</td>
 	<td style=\"width: 30px; padding-bottom: 20px\" valign=\"top\"><input type=\"checkbox\" name=\"recipientId[]\" value=\"" . (int)$rowMessage["userId"] . "\"></td>
 	<td style=\"width: 50px; padding-bottom: 20px\" valign=\"top\"><a href=\"#noexist\" onClick=\"showImage('popupMediumImage','" . $mediumAvatar . "');\" style=\"font-weight: normal\">" . $avatar . "</a></td>
 	<td style=\"width: 145px; padding-bottom: 20px\" valign=\"top\"><a href=\"" . $baseUrl . "/user/" . $rowMessage["username"] . ".html\" style=\"font-weight: normal\">" . $rowMessage["username"] . "</a><br /><div class=\"email_date\">" . $messageTime . "</div></td>
  	<td style=\"padding-bottom: 20px\" valign=\"top\"><a href=\"" . $baseUrl . "/konv/" . $rowMessage["username"] . ".html\"" . $messageRead . ">" . $rowMessage["subject"] . "</a><div class=\"other_link\"><a href=\"" . $baseUrl . "/konv/" . $rowMessage["username"] . ".html\">" . $messageSnippet . "</a></div></td>
 </tr>";
} else {
			$body.= "<tr>
 	<td style=\"width: 20px; padding-bottom: 20px\" valign=\"top\"></td>
 	<td style=\"width: 30px; padding-bottom: 20px\" valign=\"top\"><input type=\"checkbox\" name=\"recipientId[]\" value=\"" . (int)$rowMessage["userId"] . "\"></td>
 	<td style=\"width: 50px; padding-bottom: 20px\" valign=\"top\"><a href=\"#noexist\" onClick=\"showImage('popupMediumImage','" . $mediumAvatar . "');\" style=\"font-weight: normal\">" . $avatar . "</a></td>
 	<td style=\"width: 145px; padding-bottom: 20px\" valign=\"top\">Borttagen medlem<br /><div class=\"email_date\">" . $messageTime . "</div></td>
  	<td style=\"padding-bottom: 20px\" valign=\"top\">" . $rowMessage["subject"] . "<div class=\"other_link\">" . $messageSnippet . "</div></td>
 </tr>";
}

 $printed++;
		}
	}
	else
	{
		if ( strlen( $_POST["mailSearchQuery"] ) > 0 )
		{
			$body.= "<tr><td colspan=\"4\">Inga meddelanden matchade din sökning. (" . htmlentities( stripslashes( $_POST["mailSearchQuery"] ) ) . ")<br /><br /></td></tr>";
		}
		else
		{
			$body.= "<tr><td colspan=\"4\">Du har inga meddelanden i din inbox.<br /><br /></td></tr>";
		}
	}

	$body.= "</table>\n\n	<div id=\"divFooterSpace\">";

	
	$body .= pagingButtons($countResult[0], $numPerPage, (int)$_GET["offset"], $printed,  $baseUrl . "/inbox.html?sortBy=" . $_GET["sortBy"] );


	$body.= "&nbsp;</div></p></form>

</div>

<div id=\"right\">";
$body.= rightMenu('inbox');
$body.= "</div>";

}
?>