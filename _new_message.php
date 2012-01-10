<?php
$metaTitle = "Flator.se - Mina sidor - Meddelanden - Skapa nytt meddelande";
$numPerPage = 50;

if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/new_message.html";
	include( "login_new.php" );
}
else
{
	$validRecipentArr = array();
	unset( $recipentFriendList );
	if ( (int)$_GET["userId"] > 0 )
	{
		$q = "SELECT * FROM fl_users WHERE rights > 1 AND id = " . (int)$_GET["userId"];
#echo $q;
		$userDetails = $DB->GetRow( $q, FALSE, TRUE );
		if ( (int)$userDetails["id"] < 1)
		{
			unset( $_GET["userId"] );
		}
		else
		{
			$recipentFriendList.= "<a href=\"" . $baseUrl . "/user/" . $userDetails["username"] . ".html\">" . $userDetails["username"] . "</a>";

			$validRecipentArr[] = $userDetails["id"];
		}
	}

	if ( strlen( $_GET["recipentUserIds"] ) > 0)
	{
		$recipentFriendsArr = array();
		$_GET["recipentUserIds"] = str_replace( "message,", "", $_GET["recipentUserIds"] );
		$recipentFriendsArr = explode( ",", $_GET["recipentUserIds"] );
		$q = "SELECT * FROM fl_users WHERE rights > 1 AND id IN (" . addslashes( implode( ",", $recipentFriendsArr ) ) . ") ORDER BY username ASC";
#		echo $q;
		$row = $DB->GetAssoc( $q, FALSE, TRUE );
		if ( count( $row ) > 0 )
		{
			while ( list( $key, $value ) = each( $row ) )
			{
				$validRecipentArr[] = $row[ $key ]["id"];

				if ( strlen( $recipentFriendList ) > 0 )
				{
					$recipentFriendList.= ", ";
				}
				$recipentFriendList.= "<a href=\"" . $baseUrl . "/user/" . $row[ $key ]["username"] . ".html\">" . $row[ $key ]["username"] . "</a>";
			}
		}
	}

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

	unset( $message );
	unset( $thankyou );
	if ( $_POST  && $_SESSION["demo"] != TRUE )
	{
		if ( !$friends[ $_POST["recipentUserId"] ] && count( $validRecipentArr ) < 1 )
		{
			$message.= "<li>Du måste ange en <b>vän</b> att skicka meddelandet till.</li>\n";
		}

		if ( strlen( strip_tags( stripslashes( $_POST["subject"] ) ) ) < 1 ) $message.= "<li>Du måste ange en <b>rubrik</b>.</li>\n";
		if ( strlen( stripslashes( $_POST["message"] ) ) < 1 ) $message.= "<li>Du måste ange ett <b>meddelande</b>.</li>\n";

		if ( strlen( $message ) < 1 )
		{
			if ( count( $validRecipentArr ) > 0 )
			{
				while ( list( $key, $value ) = each( $validRecipentArr ) )
				{
					$record = array();
					$record["insDate"] = date("Y-m-d H:i:s");
					$record["newMessage"] = "YES";
					$record["userId"] = $_SESSION["userId"];
					$record["recipentUserId"] = $value;
					$record["subject"] = strip_tags( stripslashes( $_POST["subject"] ) );
					$record["message"] = stripslashes( $_POST["message"] );
					$record["deleted"] = "NO";
					$record["senderDeleted"] = "NO";
					$DB->AutoExecute( "fl_messages", $record, 'INSERT' ); 

					$thankyou = "<li>Meddelandet har skickats till " . $recipentFriendList . "!</li>\n";
				}
			}
			else
			{
				$record = array();
				$record["insDate"] = date("Y-m-d H:i:s");
				$record["newMessage"] = "YES";
				$record["userId"] = $_SESSION["userId"];
				$record["recipentUserId"] = $_POST["recipentUserId"];
				$record["subject"] = strip_tags( stripslashes( $_POST["subject"] ) );
				$record["message"] = stripslashes( $_POST["message"] );
				$record["deleted"] = "NO";
				$record["senderDeleted"] = "NO";
				$DB->AutoExecute( "fl_messages", $record, 'INSERT' ); 

				$thankyou = "<li>Meddelandet har skickats till <b>" . $friends[ $_POST["recipentUserId"] ]["username"] . "</b>!</li>\n";
			}
			$_POST = array();
		}
	}


	$body = "<div id=\"center\">
	<div id=\"divHeadSpace\">&nbsp;</div>

<p>
<form method=\"post\" style=\"margin: 0px; padding: 0px\" name=\"form\">";

	if ( strlen( $message ) > 0 )
	{
		$body.= "<div id=\"error\" style=\"margin-bottom: 35px;\"><ul class=\"errorList\">" . $message . "</ul></div>";
	}
	elseif ( strlen( $thankyou ) > 0 )
	{
		$body.= "<div id=\"thankyou\" style=\"margin-bottom: 35px;\"><ul class=\"errorList\">" . $thankyou . "</ul></div>";
	}

	$body.= "<p><div id=\"messageText\">Till</div>";

	if ( strlen( $recipentFriendList ) > 0 )
	{
		$body.= "<div style=\"float: left; margin-bottom: 20px\">" . $recipentFriendList . "</div>";
	}
	elseif ( count( $friends ) > 0 )
	{
		$body.= "<div id=\"messageTo\"><select name=\"recipentUserId\"><option value=\"\">--</option>";
		while ( list( $key, $value ) = each( $friends ) )
		{
			$selected = ( $_POST["recipentUserId"] == $friends[ $key ]["id"] ) ? " selected":"";
			$body.= "\t<option value=\"" . $friends[ $key ]["id"] . "\"" . $selected . ">" . htmlentities( stripslashes( $friends[ $key ]["username"] ) ) . "</option>\n";
		}
		$body.= "</select></div></p>";
	}
	else
	{
		$body.= "<div style=\"float: left; margin-bottom: 20px\"><i>Du har inga vänner att skicka meddelanden till ännu. :(</i></div></p>";		
	}

	$body.= "
<p><div id=\"messageText\">Rubrik</div>
<div id=\"messageSubject\"><input type=\"text\" name=\"subject\" value=\"" . strip_tags( stripslashes( $_POST["subject"] ) ) . "\" /></div></p>

<p><div id=\"messageText\">Mess</div>
<div style=\"float: left; margin-bottom: 20px\"><textarea name=\"message\" style=\"height: 200px; width: 484px\">" . stripslashes( $_POST["message"] ) . "</textarea></div></p>

<p><div style=\"display:block; float: right; margin-right: 11px\"><span onMouseOver=\"document.sendMail.src='img/symbols/gif_red/skicka.gif'\" onMouseOut=\"document.sendMail.src='img/symbols/gif_purple/skicka.gif'\"><nobr><a href=\"#noexist\" onClick=\"document.form.submit();\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/skicka.gif\" name=\"sendMail\" align=\"ABSMIDDLE\" border=\"0\" />Skicka</a></nobr></span></div></p>

</form>
</p>

</div>

<div id=\"right\">";
$body.= rightMenu('new_message');
$body.= "</div>";

}
?>