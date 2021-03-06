<?php
$metaTitle = "Flator.se - Mina sidor - Meddelanden - Visa meddelande";
$numPerPage = 50;

if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/message.html";
	include( "login_new.php" );
}
else
{
	$friendArr = array();
	$friends = array();
	$q = "SELECT * FROM fl_friends WHERE userId = " . (int)$_SESSION["userId"] . " OR friendUserId = " . (int)$_SESSION["userId"] . " AND approved = 'YES'";
	$row = $DB->GetAssoc( $q, FALSE, TRUE );
	if ( count( $row ) > 0 )
	{
		while ( list( $key, $value ) = each( $row ) )
		{
			if ( $row[ $key ]["userId"] != (int)$_SESSION["userId"] )
			{
				$friendArr[] = $row[ $key ]["userId"];
			}
			if ( $row[ $key ]["friendUserId"] != (int)$_SESSION["userId"] )
			{
				$friendArr[] = $row[ $key ]["friendUserId"];
			}
		}
	}
	if ( count( $friendArr ) > 0 )
	{
		$friendList = implode( ",", $friendArr );

		$q = "SELECT * FROM fl_users WHERE id IN (" . addslashes( $friendList ) . ") AND rights > 1 AND username != '' ORDER BY username ASC";
		$friends = $DB->GetAssoc( $q, FALSE, TRUE );
	}

	unset( $error );
	unset( $thankyou );
	if ( $_POST  && $_SESSION["demo"] != TRUE )
	{
		if ( (int)$_POST["recipentUserId"] < 1 ) $error.= "<li>Du m�ste ange en <b>v�n</b> att skicka meddelandet till.</li>\n";
		if ( strlen( strip_tags( stripslashes( $_POST["subject"] ) ) ) < 1 ) $error.= "<li>Du m�ste ange en <b>rubrik</b>.</li>\n";

		if ( strlen( stripslashes( $_POST["message"] ) ) < 1 ) $error.= "<li>Du m�ste ange ett <b>meddelande</b>.</li>\n";

		if ( strlen( $error ) < 1 )
		{
			$record = array();

			// Reply to a previous message?
			if ( (int)$_POST["origMessageId"] > 0 )
			{
				$q = "SELECT * FROM fl_messages WHERE (userId = " . (int)$_SESSION["userId"] . " OR recipentUserId = " . (int)$_SESSION["userId"] . ") AND id = " . (int)$_POST["origMessageId"];
				$origMessage = $DB->GetRow( $q, FALSE, TRUE );
#echo $q;
			}

			$record["insDate"] = date("Y-m-d H:i:s");
			$record["newMessage"] = "YES";
			$record["userId"] = $_SESSION["userId"];
			$record["recipentUserId"] = $_POST["recipentUserId"];
			$record["subject"] = strip_tags( stripslashes( $_POST["subject"] ) );
			$record["message"] = stripslashes( $_POST["message"] );
			$record["deleted"] = "NO";
			$record["senderDeleted"] = "NO";
			if ( (int)$origMessage["id"] > 0 )
			{
				$record["origMessageId"] = stripslashes( $_POST["origMessageId"] );
			}
			$DB->AutoExecute( "fl_messages", $record, 'INSERT' ); 

			$record = array();
			$record["recipentReplied"] = "YES";
			$DB->AutoExecute( "fl_messages", $record, 'UPDATE', 'id = ' . (int)$_GET["messageId"] ); 

			$thankyou = "<li>Meddelandet har skickats till <b>" . $friends[ $_POST["recipentUserId"] ]["username"] . "</b>!</li>\n";
			$_POST = array();

			$q = "SELECT fl_messages.*, fl_users.username, UNIX_TIMESTAMP( fl_messages.insDate ) AS unixTime FROM fl_messages LEFT JOIN fl_users ON fl_users.id = fl_messages.userId WHERE ((fl_messages.userId = " . (int)$_SESSION["userId"] . " AND fl_messages.senderDeleted = 'NO') OR (fl_messages.recipentUserId = " . (int)$_SESSION["userId"] . " AND fl_messages.deleted = 'NO')) AND fl_messages.id = " . (int)$DB->Insert_ID();
			$message = $DB->GetRow( $q, FALSE, TRUE );
#			if ( (int)$message["origMessageId"] > 0 )
#			{
#				$message = getMessage( $message["origMessageId"], $_GET["messageId"], $_SESSION["userId"] );
#			}
#			else
#			{
#				$message = getMessage( $_GET["messageId"], $DB->Insert_ID(), $_SESSION["userId"] );
#			}
		}
	}

	$body = "<div id=\"center\">
	<div id=\"divHeadSpace\" style=\"margin-top: 12px\"><h3 style=\"margin-left: 195px; line-height: 24px;\">" . $message["subject"] . "</h3></div>";

	if ( strlen( $error ) > 0 )
	{
		$body.= "<div id=\"error\" style=\"margin-bottom: 35px;\"><ul class=\"errorList\">" . $error . "</ul></div>";
	}
	elseif ( strlen( $thankyou ) > 0 )
	{
		$body.= "<div id=\"thankyou\" style=\"margin-bottom: 35px;\"><ul class=\"errorList\">" . $thankyou . "</ul></div>";
	}

	$thread = array();

	if ( (int)$message["id"] > 0 )
	{
		if ( $message["newMessage"] == "YES" && $_GET["type"] != "outbox"  && $_SESSION["demo"] != TRUE )
		{
			$record = array();
			$record["newMessage"] = "NO";
			$DB->AutoExecute( "fl_messages", $record, 'UPDATE', 'id = ' . (int)$message["id"] . ' AND recipentUserId = ' . (int)$_SESSION["userId"] );

			if ( (int)$unReadMessages > 0 ) $unReadMessages--;
		}

		$thread[ $message["insDate"] ][] = $message;
		if ( (int)$message["origMessageId"] < 1 ) $message["origMessageId"] = $message["id"];
		$origMessageId = $message["origMessageId"];

		$q = "SELECT fl_messages.*, fl_users.username, UNIX_TIMESTAMP( fl_messages.insDate ) AS unixTime FROM fl_messages LEFT JOIN fl_users ON fl_users.id = fl_messages.userId WHERE ((fl_messages.userId = " . (int)$_SESSION["userId"] . " AND fl_messages.senderDeleted = 'NO') OR (fl_messages.recipentUserId = " . (int)$_SESSION["userId"] . " AND fl_messages.deleted = 'NO')) AND (fl_messages.id = " . (int)$origMessageId . " OR fl_messages.origMessageId = " . (int)$origMessageId . ") AND fl_messages.id != " . (int)$message["id"];
#echo $q;
		$rowMessage = $DB->GetAssoc( $q, FALSE, TRUE );
		if ( count( $rowMessage ) > 0 )
		{
			while ( list( $key, $value ) = each( $rowMessage ) )
			{
				$thread[ $rowMessage[ $key ]["insDate"] ][] = $rowMessage[ $key ];
			}
		}
		ksort( $thread );

		unset( $recipentUserId );
		if ( count( $thread ) > 0 )
		{
			while ( list( $date, $trash ) = each( $thread ) )
			{
				if ( count( $thread[ $date ] ) > 0 )
				{
					while ( list( $key, $trash ) = each( $thread[ $date ] ) )
					{
						unset( $messageTime );
						// Possible date-types: Today, Yesterday, ThisYear, LastYear

						if ( date("Y-m-d", $thread[ $date ][ $key ]["unixTime"] ) == date( "Y-m-d" ) )
						{
							// Message sent today
							$messageTime = "Idag kl " . date( "H:i", $thread[ $date ][ $key ]["unixTime"] );
						}
						elseif ( date("Y-m-d", $thread[ $date ][ $key ]["unixTime"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
						{
							// Message sent yesterday
							$messageTime = "Ig&aring;r kl " . date( "H:i", $thread[ $date ][ $key ]["unixTime"] );
						}
						elseif ( date("Y", $thread[ $date ][ $key ]["unixTime"] ) == date( "Y" ) )
						{
							// Message sent this year
							$messageTime = date( "j M Y H:i", $thread[ $date ][ $key ]["unixTime"] );
						}
						else
						{
							$messageTime = date( "Y-m-d H:i", $thread[ $date ][ $key ]["unixTime"] );
						}

						$q = "SELECT * FROM fl_images WHERE userId = " . (int)$thread[ $date ][ $key ]["userId"] . " AND imageType = 'profileSmall'";
						$mailImage = $DB->GetRow( $q, FALSE, TRUE );
						if ( count( $mailImage ) > 0 )
						{
							$avatar = "<img src=\"" . $mailImage["imageUrl"] . "\" border=\"0\" width=\"" . $mailImage["width"] . "\" height=\"" . $mailImage["height"] . "\" />";
						}
						else
						{
							$avatar = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/person_avnatar_liten.gif\" border=\"0\" width=\"26\" height=\"29\" />";
						}

						$q = "SELECT * FROM fl_images WHERE userId = " . (int)$thread[ $date ][ $key ]["userId"] . " AND imageType = 'profileMedium'";
						$guestImage = $DB->GetRow( $q, FALSE, TRUE );
						if ( count( $guestImage ) > 0 )
						{
							$mediumAvatar = $guestImage["imageUrl"];
						}
						else
						{
							$mediumAvatar = $baseUrl . "/img/symbols/gif_avatars/person_avantar_stor.gif";
						}

						$body.= "<p>
<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-size: 12px; border-bottom: 1px dotted #c8c8c8;\">";
						$body.= "<tr>
 	<td style=\"width: 50px; padding-bottom: 20px\" valign=\"top\"><a href=\"#noexist\" onClick=\"showImage('popupMediumImage','" . $mediumAvatar . "');\" style=\"font-weight: normal\">" . $avatar . "</a></td>
 	<td style=\"width: 145px; padding-bottom: 20px\" valign=\"top\"><a href=\"" . $baseUrl . "/user/" . $thread[ $date ][ $key ]["username"] . ".html\" style=\"font-weight: normal\">" . $thread[ $date ][ $key ]["username"] . "</a><br /><div class=\"email_date\">" . $messageTime . "</div></td>
  	<td style=\"padding-bottom: 20px\">" . stripslashes( $thread[ $date ][ $key ]["message"] ) . "</div></td>
 </tr>";
						$body.= "</table></p>";

						if ( $thread[ $date ][ $key ]["userId"] != $_SESSION["userId"] )
						{
							$recipentUserId = $thread[ $date ][ $key ]["userId"];
							$recipentUsername = $thread[ $date ][ $key ]["username"];
						}
						if ( (int)$origMessageId < 1 ) $origMessageId = $thread[ $date ][ $key ]["id"];
					}
				}
			}
		}
		if ( (int)$recipentUserId < 1 ) $recipentUserId = $_SESSION["userId"];
		if ( strlen( $recipentUsername ) < 1 )
		{
			$recipentUsername = $userProfile["username"];
		}

		$body.= "<form method=\"post\" style=\"margin: 0px; padding: 0px\" name=\"form\">
			 <input type=\"hidden\" name=\"origMessageId\" value=\"" . $origMessageId . "\" />
			 <input type=\"hidden\" name=\"subject\" value=\"" . $message["subject"] . "\" />
			 <input type=\"hidden\" name=\"recipentUserId\" value=\"" . $recipentUserId . "\" />\n
<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-size: 12px; border-bottom: 1px dotted #c8c8c8;\">
<tr>
 	<td style=\"width: 195px; padding-bottom: 20px; padding-top:10px;\" valign=\"top\">Mess</td>
  	<td style=\"padding-bottom: 20px; padding-top:10px; padding-right: 10px;\"><textarea name=\"message\" style=\"border: 2px solid #aa567a; height: 200px; width: 100%;\"></textarea></td>
 </tr>
</table>

<p><div style=\"display:block; float: right; margin-right: 11px\"><span onMouseOver=\"document.sendMail.src='" . $baseUrl . "/img/symbols/gif_red/skicka.gif'\" onMouseOut=\"document.sendMail.src='" . $baseUrl . "/img/symbols/gif_purple/skicka.gif'\"><nobr><a href=\"#noexist\" onClick=\"document.form.submit();\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/skicka.gif\" name=\"sendMail\" align=\"ABSMIDDLE\" border=\"0\" />Svara " . $recipentUsername . "</a></nobr></span></div></p>
</form>
			 ";
	}
	$body.= "</div>

<div id=\"right\">";
$body.= rightMenu('read_message');
$body.= "</div>";

}
?>