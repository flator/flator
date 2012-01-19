<?php
if ( (int)$_SESSION["rights"] < 2 )
{
	$publicMenu = TRUE;
	$memberMenu = FALSE;
	$loginUrl = $baseUrl . "/presentation.html";
	include( "login_new.php" );
}
else
{
	unset( $error );




	if ( $_POST  && $_SESSION["demo"] != TRUE )
	{
		if ( $_POST["type"] == "addFriend" )
		{
			if ( !isCurrentFriend ( (int)$_SESSION["userId"], $userPres["id"], "NO" ) )
			{
				$record = array();
				$record["insDate"] = date("Y-m-d H:i:s");
				$record["userId"] = (int)$_SESSION["userId"];
				$record["friendUserId"] = (int)$userPres["id"];
				$record["relationship"] = addslashes( $_POST["relationship"] );
				$record["approved"] = "NO";
				$DB->AutoExecute( "fl_friends", $record, 'INSERT' ); 
				$_POST = array();
			}
			$thankoyu = "<li>En förfrågan har skickats till <b>" . stripslashes( $_GET["username"] ) . "</b>.</li>\n";
		}
		elseif ( $_POST["type"] == "profileImage" )
		{
#			$DB->debug = TRUE;

			if ( $_FILES["image"]["name"] )
			{
				$dir = "/var/www/flator.se/rwdx/user"; 

				$validImageTypes = array( "image/jpg" => "jpg",
										  "image/gif" => "gif",
										  "image/png" => "png" );

				$imageInfo = getimagesize( $_FILES['image']['tmp_name'] );

#				if ( $validImageTypes[ $imageInfo["mime"] ] )
#				{
					$record = array();
					$record["imageType"] = "otherProfileSmall";
					$DB->AutoExecute( "fl_images", $record, 'UPDATE', "userId = " . (int)$_SESSION["userId"] . " AND imageType = 'profileSmall'" );

					$record = array();
					$record["imageType"] = "otherProfileMedium";
					$DB->AutoExecute( "fl_images", $record, 'UPDATE', "userId = " . (int)$_SESSION["userId"] . " AND imageType = 'profileMedium'" );

					$record = array();
					$record["imageType"] = "otherProfileLarge";
					$DB->AutoExecute( "fl_images", $record, 'UPDATE', "userId = " . (int)$_SESSION["userId"] . " AND imageType = 'profileLarge'" );

					// Create unique image-name
					$unique = time() . "-" . (int)$_SESSION["userId"];

					$largeImage = $unique.substr($_FILES["image"]["name"], -4, 4);
					$mediumImage = $unique."m".substr($_FILES["image"]["name"], -4, 4);
					$smallImage = $unique."s".substr($_FILES["image"]["name"], -4, 4);
					move_uploaded_file($_FILES['image']['tmp_name'], $dir . "/" . $largeImage);
		
					$record = array();
					$record["insDate"] = date("Y-m-d H:i:s");
					$record["userId"] = (int)$_SESSION["userId"];
					$record["imageType"] = "profileLarge";
					$record["width"] = $imageInfo[0];
					$record["height"] = $imageInfo[1];
					$record["imageUrl"] = $baseUrl . "/rwdx/user/" . $largeImage;
					$record["serverLocation"] = $dir . "/" . $largeImage;
					$DB->AutoExecute( "fl_images", $record, 'INSERT' ); 

					// Medium image
					createthumb( $dir . "/" . $largeImage, $dir . "/" . $mediumImage, 200, 300 );
					$imageInfo = getimagesize( $dir . "/" . $mediumImage );

					$record = array();
					$record["insDate"] = date("Y-m-d H:i:s");
					$record["userId"] = (int)$_SESSION["userId"]; 
					$record["imageType"] = "profileMedium";
					$record["width"] = $imageInfo[0];
					$record["height"] = $imageInfo[1];
					$record["imageUrl"] = $baseUrl . "/rwdx/user/" . $mediumImage;
					$record["serverLocation"] = $dir . "/" . $mediumImage;
					$DB->AutoExecute( "fl_images", $record, 'INSERT' );

					// Medium image
					createthumb( $dir . "/" . $largeImage, $dir . "/" . $smallImage, 45, 100 );
					$imageInfo = getimagesize( $dir . "/" . $smallImage );

					$record = array();
					$record["insDate"] = date("Y-m-d H:i:s");
					$record["userId"] = (int)$_SESSION["userId"];
					$record["imageType"] = "profileSmall";
					$record["width"] = $imageInfo[0];
					$record["height"] = $imageInfo[1];
					$record["imageUrl"] = $baseUrl . "/rwdx/user/" . $smallImage;
					$record["serverLocation"] = $dir . "/" . $smallImage;
					$DB->AutoExecute( "fl_images", $record, 'INSERT' );
#				}
#				else
#				{
#					$error.= "<li>Felaktigt <b>bildformat</b>. Endast bilder av typen: jpg, gif eller png kan användas.</li>\n";
#				}
			}

#			$thankoyu = "<li>En förfrågan har skickats till <b>" . stripslashes( $_GET["username"] ) . "</b>.</li>\n";
		} elseif ( $_POST["type"] == "sendFlirt" )
		{
			
				$record = array();
				$record["insDate"] = date("Y-m-d H:i:s");
				$record["flirt"] = addslashes( $_POST["flirt"] );
				$record["message"] = addslashes( $_POST["message"] );
				$record["senderUserId"] = (int)$_SESSION["userId"];
				$record["recipientUserId"] = (int)$userPres["id"];
				$record["seen"] = "NO";
				$DB->AutoExecute( "fl_flirts", $record, 'INSERT' ); 
				$_POST = array();
			
			$thankoyu = "<li>Din flört skickades till <b>" . stripslashes( $_GET["username"] ) . "</b>.</li>\n";
		}
		elseif ( $_POST["type"] == "wall" )
		{
			if ( strlen( stripslashes( $_POST["message"] ) ) < 1 ) $error.= "<li>Du måste ange ett <b>meddelande</b>.</li>\n";

			if ( strlen( $error ) < 1 )
			{
				$record = array();
				$record["insDate"] = date("Y-m-d H:i:s");
				$record["newMessage"] = "YES";
				$record["userId"] = (int)$_SESSION["userId"];
				$record["recipentUserId"] = (int)$userPres["id"];
				$record["message"] = stripslashes( $_POST["message"] );
				$record["deleted"] = "NO";
				$DB->AutoExecute( "fl_guestbook", $record, 'INSERT' ); 
				$_POST = array();
			}
		}
		elseif ( $_POST["type"] == "wallAnswer" )
		{
			if ( strlen( stripslashes( $_POST["message"] ) ) < 1 ) $error.= "<li>Du måste ange ett <b>meddelande</b>.</li>\n";

			if ( strlen( $error ) < 1 )
			{
				$record = array();
				$record["insDate"] = date("Y-m-d H:i:s");
				$record["newMessage"] = "YES";
				$record["userId"] = (int)$_SESSION["userId"];
				$record["recipentUserId"] = (int)$_POST["userId"];
				$record["message"] = stripslashes( $_POST["message"] );
				$record["deleted"] = "NO";
				$DB->AutoExecute( "fl_guestbook", $record, 'INSERT' ); 
				$thankoyu = "Ditt svar har skickats till <a href=\"" . $baseUrl . "/user/" . stripslashes($_POST["userName"]) . ".html\">".stripslashes($_POST["userName"])."</a>";
				$_POST = array();
			}
		}
	}

	if ( !$editPresentation && $userProfile["visible"] == "YES"  && $_SESSION["demo"] != TRUE )
	{
		$q = "SELECT * FROM fl_visitors WHERE userId = " . (int)$userPres["id"] . " ORDER BY insDate DESC LIMIT 0,1";
		$lastVisitor = $DB->GetRow( $q, FALSE, TRUE );
		if ( $lastVisitor["visitorUserId"] != (int)$_SESSION["userId"] )
		{
#echo "loggar besök";
			$record = array();
			$record["insDate"] = date("Y-m-d H:i:s");
			$record["visitorUserId"] = (int)$_SESSION["userId"];
			$record["userId"] = (int)$userPres["id"];
			$DB->AutoExecute( "fl_visitors", $record, 'INSERT' ); 
		}
	}

#	$q = "SELECT * FROM fl_images WHERE userId = " . (int)$userPres["id"] . " AND imageType = 'profileMedium'";
#	$profileImage = $DB->GetRow( $q, FALSE, TRUE );
#	if ( count( $profileImage ) > 0 )
#	{
#		$avatar = "<img src=\"" . $profileImage["imageUrl"] . "\" border=\"0\" width=\"" . $profileImage["width"] . "\" height=\"" . $profileImage["height"] . "\" />";
#	}
#	else
#	{
#		$avatar = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/person_avantar_stor.gif\" border=\"0\" width=\"167\" height=\"191\" />";
#	}
	$q = "SELECT * FROM fl_images WHERE userId = " . (int)$userPres["id"] . " AND imageType = 'profileMedium'";
	$profileImage = $DB->GetRow( $q, FALSE, TRUE );
	if ( count( $profileImage ) > 0 )
	{
		$avatar = "<img src=\"" . $baseUrl . "/user-photos/" . str_replace('http://dev.flator.se/rwdx/user/', '', $profileImage["imageUrl"]) . "/profile/\" />";
	}
	else
	{
		$avatar = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/person_avantar_stor.gif\" width=\"167\" height=\"181\" />";

	}
	$profileAvatar = $avatar;

	unset( $recentStatus );
	unset( $recentDate );
	$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_status WHERE userId = " . (int)$userPres["id"] . " AND statusType = 'personalMessage' ORDER BY insDate DESC LIMIT 0,1";
	$userStatus = $DB->CacheGetAssoc( 5, $q, FALSE, TRUE );
	if ( count( $userStatus ) > 0 )
	{
		while ( list( $key, $value ) = each( $userStatus ) )
		{
			if ( strlen( $recentStatus ) < 1 )
			{
				
				$recentStatus = truncate(stripslashes($userStatus[ $key ]["statusMessage"]), 25, "..", TRUE, TRUE);

				$recentDate = $userStatus[ $key ]["unixTime"];
			}
		}
	}

	unset( $statusTime );
	if ( strlen( $recentStatus ) < 1 )
	{
		if ( $editPresentation == TRUE )
		{
			$recentStatus = "<a href=\"#noexist\" onClick=\"getContent('change_status.php?target=statusMessage');\" style=\"font-weight: normal\">Du har inte angett någon status</a>";
		}
		else
		{
			$recentStatus = "Har inte angett någon status";
		}
	}
	else
	{
		if ( $editPresentation == TRUE )
		{
			$recentStatus = "<a href=\"#noexist\" onClick=\"getContent('change_status.php?target=statusMessage');\" style=\"font-weight: normal\">" . stripslashes( $recentStatus ) . "</a>";
		}
		else
		{
			$recentStatus = $recentStatus;
		}

		// Possible date-types: Whiting minute, Within our, Today, Yesterday, ThisYear, LastYear

		if ( (time() - $recentDate) < 120 )
		{
			// Status updated within minute
			$statusTime = "för 1 minut sedan";
		}
		elseif ( (time() - $recentDate) < 3600 )
		{
			// Status updated within hour
			$statusTime = ceil((time() - $recentDate)/60);
			$statusTime = "för " . $statusTime . " minuter sedan";
		}
		elseif ( date("Y-m-d", $recentDate ) == date( "Y-m-d" ) )
		{
			// Status updated today
			$statusTime = "idag " . date( "H:i", $recentDate );
		}
		elseif ( date("Y-m-d", $recentDate ) == date( "Y-m-d", ( time() - 86400 ) ) )
		{
			// Status updated yesterday
			$statusTime = "ig&aring;r " . date( "H:i", $recentDate );
		}
		elseif ( date("Y", $recentDate ) == date( "Y" ) )
		{
			// Status updated this year
			$statusTime = date( "j M Y H:i", $recentDate );
		}
		else
		{
			$statusTime = date( "Y-m-d H:i", $recentDate );
		}

		$statusTime = "<br /><div class=\"email_date\" style=\"display:inline\">Uppdaterat " . $statusTime . "</div>";
	}

	$body = "<div id=\"center\">

<div id=\"divHeadSpace\" style=\"border: 0px; line-height: 10px\">&nbsp;</div>

<div style=\"float: left; width: 200px; margin-right: 30px\">";
$q = "SELECT * FROM fl_images WHERE imageType = 'albumPhoto' AND userId = ".(int)$userPres["id"];
		$images = $DB->CacheGetAssoc( 30, $q, FALSE, TRUE );
if ( $editPresentation == TRUE )
{
	$body.= "<div style=\"margin-bottom: 0x; margin-top: 30px\">" . $avatar ."</div>\n";
	$body.= "<div style=\"border-bottom: 1px dotted #c8c8c8; margin-top:5px; padding-bottom:5px;\"><span onMouseOver=\"document.newPP_onpres.src='" . $baseUrl . "/img/symbols/gif_red/ladda_upp_bild.gif'\" onMouseOut=\"document.newPP_onpres.src='" . $baseUrl . "/img/symbols/gif_purple/ladda_upp_bild.gif'\"><a href=\"http://dev.flator.se/media/".stripslashes( $userPres["username"] ).".html\" style=\"font-weight: normal; line-height: 22px\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/ladda_upp_bild.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"newPP_onpres\" /><a href=\"#noexist\" onClick=\"showPopup('popupProfileImage');\" style=\"font-weight: normal; line-height: 22px\">&nbsp;&nbsp;Byt profilbild</a></span></div>";
	if (count($images) > 0) {
	$body .= "<div style=\"border-bottom: 1px dotted #c8c8c8; margin-top:5px; padding-bottom:5px;\"><span onMouseOver=\"document.myPictures_onpres.src='" . $baseUrl . "/img/symbols/gif_red/bild.gif'\" onMouseOut=\"document.myPictures_onpres.src='" . $baseUrl . "/img/symbols/gif_purple/bild.gif'\"><a href=\"http://dev.flator.se/media/".stripslashes( $userPres["username"] ).".html\" style=\"font-weight: normal; line-height: 22px\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/bild.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"myPictures_onpres\" />&nbsp;&nbsp;Se fler av mina bilder</a></span></div>";
	}
}
else
{
	




	
	$body.= "<div style=\"margin-bottom: 0x; margin-top: 30px\">" . $avatar ."</div>";

	$lastOnlineTime = convert_datetime($userPres["lastVisibleOnline"]);
	if ($lastOnlineTime > (time() - 900) && $userPres["videoChat"] == "YES") {
 		$body .= "<div style=\"border-bottom: 1px dotted #c8c8c8; margin-top:5px; padding-bottom:5px;\"><span onMouseOver=\"document.chatInvite_onpres.src='" . $baseUrl . "/img/symbols/gif_red/chat.gif'\" onMouseOut=\"document.chatInvite_onpres.src='" . $baseUrl . "/img/symbols/gif_purple/chat.gif'\"><a href=\"#noexist\" onclick=\"showPopup('popupChatInvite');\" style=\"font-weight: normal; line-height: 22px\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/chat.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"chatInvite_onpres\" />&nbsp;&nbsp;Bjud in till videochatt</a></span></div>";

		$body .= "<div id=\"popupChatInvite\" class=\"popup\" style=\"display: none\">
					<div id=\"divHeadSpace\" style=\"border-top: 0px; border-bottom: 1px dotted #c8c8c8; margin: 4px; margin-left: 20px; margin-right: 20px;\">

						<div style=\"float: left; display: block\"><h3>Bjud in till videochatt</h3></div>
						<div style=\"float: right; display: block\"><a href=\"#\" onclick=\"closePopup('popupChatInvite');\"><img src=\"".$baseUrl."/img/kryss_edit.gif\" name=\"closeVCInvite\" border=\"0\" onMouseOver=\"document.closeVCInvite.src='".$baseUrl."/img/kryss_edit_red.gif'\" onMouseOut=\"document.closeVCInvite.src='".$baseUrl."/img/kryss_edit.gif'\" style=\"margin: 10px\"></a></div>

					&nbsp;</div>
<div style=\"display: inline; float: left; padding-left: 20px; padding-right: 20px;\">
					<p>Om du väljer att bjuda in användaren ".stripslashes( $userPres["username"] )." till videochatten kommer en förfrågan att dyka upp hos ".stripslashes( $userPres["username"] )." om att du vill videochatta och du kommer att hamna i videochatten där du får vänta på att ".stripslashes( $userPres["username"] )." skall logga in om hon har valt att tacka ja till din förfrågan. <br /><br />Observera att om ".stripslashes( $userPres["username"] )." inte just nu är inloggad på sajten kommer hon inte att kunna svara på din förfrågan, och du kommer inte att få information om detta i videochatten, inte heller om personen tackar nej till din förfrågan kommer det att visas.<br /><br /><strong>Om inget fönster öppnas måste du inaktivera din popup-blockerare för att komma åt videochatten!</strong></p>

										<span onMouseOver=\"document.inviteVideoChat.src='".$baseUrl."/img/symbols/gif_red/skicka.gif'\" onMouseOut=\"document.inviteVideoChat.src='".$baseUrl."/img/symbols/gif_purple/skicka.gif'\"><nobr><a href=\"".$baseUrl."/invite_videochat.html?user=".stripslashes( $userPres["username"] )."\"><img src=\"".$baseUrl."/img/symbols/gif_purple/skicka.gif\" name=\"inviteVideoChat\" style=\"vertical-align:middle;\" border=\"0\">Skicka inbjudan till ".stripslashes( $userPres["username"] )."</a></nobr></span>
<br /><br />
</div>

					
			
					<div style=\"float:none;\"></div><br><br><br><br>

					</div>";
	}
	if (count($images) > 0) {
	$body .= "<div style=\"border-bottom: 1px dotted #c8c8c8; margin-top:5px; padding-bottom:5px;\"><span onMouseOver=\"document.myPictures_onpres.src='" . $baseUrl . "/img/symbols/gif_red/bild.gif'\" onMouseOut=\"document.myPictures_onpres.src='" . $baseUrl . "/img/symbols/gif_purple/bild.gif'\"><a href=\"http://dev.flator.se/media/".stripslashes( $userPres["username"] ).".html\" style=\"font-weight: normal; line-height: 22px\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/bild.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"myPictures_onpres\" />&nbsp;&nbsp;Se fler av mina bilder</a></span></div>";
	}
}
$images = array();
if ($editPresentation == FALSE) {
		$body.= "<div style=\"border-bottom: 1px dotted #c8c8c8; margin-top:5px; padding-bottom:5px;\"><span onMouseOver=\"document.sendMessUser_onpres.src='" . $baseUrl . "/img/symbols/gif_red/skicka.gif'\" onMouseOut=\"document.sendMessUser_onpres.src='" . $baseUrl . "/img/symbols/gif_purple/skicka.gif'\"><a href=\"" . $baseUrl . "/konv/" . stripslashes($userPres["username"]) . ".html\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/skicka.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sendMessUser_onpres\" />&nbsp;&nbsp;Skicka mess</a></span></div>";
}
		if (( isCurrentFriend ( (int)$_SESSION["userId"], (int)$userPres["id"] ) == FALSE ) && ($editPresentation == FALSE))
		{
			$body.= "<div style=\"border-bottom: 1px dotted #c8c8c8; margin-top:5px; padding-bottom:5px;\"><span onMouseOver=\"document.becomeFriend_onpres.src='" . $baseUrl . "/img/symbols/gif_red/van.gif'\" onMouseOut=\"document.becomeFriend_onpres.src='" . $baseUrl . "/img/symbols/gif_purple/van.gif'\"><a href=\"#noexist\" onclick=\"showPopup('popupAddFriend');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/van.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"becomeFriend_onpres\" />&nbsp;&nbsp;Bli vän med</a></span></div>";
		}

if ($editPresentation == FALSE) {
		$body.= "<div style=\"border-bottom: 1px dotted #c8c8c8; margin-top:5px; padding-bottom:5px;\"><span onMouseOver=\"document.sendFlirt_onpres.src='" . $baseUrl . "/img/symbols/gif_red/skicka_flort.gif'\" onMouseOut=\"document.sendFlirt_onpres.src='" . $baseUrl . "/img/symbols/gif_purple/skicka_flort.gif'\"><a href=\"#noexist\" onClick=\"showPopup('popupSendFlirt');\" style=\"font-weight: normal\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/skicka_flort.gif\" border=\"0\" style=\"vertical-align:middle;\" name=\"sendFlirt_onpres\" />&nbsp;&nbsp;Skicka flört</a></span></div>";
}








	$body.= "<p>


<div class=\"news_headline\" style=\"display:inline\">" . stripslashes( $userPres["username"] ) . "</div><br />
<div id=\"statusMessage\" style=\"display:inline\">" . $recentStatus . $statusTime . "</div></p>

<p>";

	if ( (int)$userPres["currAge"]  > 0  )
	{
		$body.= "<div class=\"email_date\" style=\"clear: both; float: left; width: 80px\">Ålder</div><div style=\"float: left; width: 120px\">" . stripslashes( $userPres["currAge"] ) . " år</div>\n";
	}
	if ( (int)$userPres["cityId"]  > 0 || $editPresentation == TRUE )
	{
		$body.= "<div class=\"email_date\" style=\"clear: both; float: left; width: 80px\">Stad</div><div style=\"float: left; width: 120px\">" . stripslashes( $cities[$userPres["cityId"]]["city"] ) . "</div>\n";
	}
	if ( strlen( $userPres["relationship"] ) > 0 || $editPresentation == TRUE )
	{
		$body.= "<div class=\"email_date\" style=\"clear: both; float: left; width: 80px\">Relation</div><div style=\"float: left; width: 120px\">" . stripslashes( $userPres["relationship"] ) . "</div>\n";
	}
	if ( strlen( $userPres["lookingFor"] ) > 0 || $editPresentation == TRUE )
	{
		$body.= "<div class=\"email_date\" style=\"clear: both; float: left; width: 80px\">Letar efter</div><div style=\"float: left; width: 120px\">" . stripslashes( $userPres["lookingFor"] ) . "</div>\n";
	}
	if ( strlen( $userPres["attitude"] ) > 0 || $editPresentation == TRUE )
	{
		$body.= "<div class=\"email_date\" style=\"clear: both; float: left; width: 80px\">Attityd</div><div style=\"float: left; width: 120px\">" . stripslashes( $userPres["attitude"] ) . "</div>\n";
	}
	if ( strlen( $userPres["hobby"] ) > 0 || $editPresentation == TRUE )
	{
		$body.= "<div class=\"email_date\" style=\"clear: both; float: left; width: 80px\">Hobby</div><div style=\"float: left; width: 120px\">" . stripslashes( $userPres["hobby"] ) . "</div>\n";
	}
	if ( strlen( $userPres["housing"] ) > 0 || $editPresentation == TRUE )
	{
		$body.= "<div class=\"email_date\" style=\"clear: both; float: left; width: 80px\">Boende</div><div style=\"float: left; width: 120px\">" . stripslashes( $userPres["housing"] ) . "</div>\n";
	}
	if ( strlen( $userPres["politics"] ) > 0 || $editPresentation == TRUE )
	{
		$body.= "<div class=\"email_date\" style=\"clear: both; float: left; width: 80px\">Politik</div><div style=\"float: left; width: 120px\">" . stripslashes( $userPres["politics"] ) . "</div>\n";
	}
	if ( strlen( $userPres["hair"] ) > 0 || $editPresentation == TRUE )
	{
		$body.= "<div class=\"email_date\" style=\"clear: both; float: left; width: 80px\">Hår</div><div style=\"float: left; width: 120px\">" . stripslashes( $userPres["hair"] ) . "</div>\n";
	}
	if ( strlen( $userPres["drinks"] ) > 0 || $editPresentation == TRUE )
	{
		$body.= "<div class=\"email_date\" style=\"clear: both; float: left; width: 80px\">Dricker</div><div style=\"float: left; width: 120px\">" . stripslashes( $userPres["drinks"] ) . "</div>\n";
	}
	if ( strlen( $userPres["sexlife"] ) > 0 || $editPresentation == TRUE )
	{
		$body.= "<div class=\"email_date\" style=\"clear: both; float: left; width: 80px\">Sexliv</div><div style=\"float: left; width: 120px\">" . stripslashes( $userPres["sexlife"] ) . "</div>\n";
	}
	if ( strlen( $userPres["personalCodeNumber"] ) > 0 )
	{
		$userPres["personalCodeNumber"] = str_replace( "-", "", $userPres["personalCodeNumber"] );
		$userPres["personalCodeNumber"] = str_replace( "+", "", $userPres["personalCodeNumber"] );
		if ( strlen( $userPres["personalCodeNumber"] ) == 10 )
		{
			$birthDay = (int)substr( $userPres["personalCodeNumber"], 4, 2 );
			$birthMonth = strtolower( months( (int)substr( $userPres["personalCodeNumber"], 2, 2 ) ) );
			$birthYear = "19" . substr( $userPres["personalCodeNumber"], 0, 2 );
		}
		elseif ( strlen( $userPres["personalCodeNumber"] ) == 12 )
		{
			$birthDay = (int)substr( $userPres["personalCodeNumber"], 6, 2 );
			$birthMonth = strtolower( months( (int)substr( $userPres["personalCodeNumber"], 4, 2 ) ) );
			$birthYear = substr( $userPres["personalCodeNumber"], 0, 4 );
		}
		elseif ( strlen( $userPres["personalCodeNumber"] ) == 8 )
		{
			$birthDay = (int)substr( $userPres["personalCodeNumber"], 6, 2 );
			$birthMonth = strtolower( months( (int)substr( $userPres["personalCodeNumber"], 4, 2 ) ) );
			$birthYear = substr( $userPres["personalCodeNumber"], 0, 4 );
		}

		$body.= "<div class=\"email_date\" style=\"clear: both; float: left; width: 80px\">F&ouml;dd</div><div style=\"float: left; width: 120px\">" . $birthDay . " " . $birthMonth . ", " . $birthYear . "</div>\n";
	}
	if ($editPresentation == TRUE) {
	$body .= "<a style=\"float: left; margin-top:5px;\" href=\"".$baseUrl."/my_account.html\">Fyll i eller ändra uppgifter</a>";
	}
		if ( strlen( $userPres["presText"] ) > 0 || $editPresentation == TRUE )
	{
		$body.= "<div class=\"email_date\" style=\"clear: both; float: left; width: 100%; border-bottom: 1px dotted #c8c8c8; margin-top:20px;margin-bottom:20px;\">&nbsp;</div><br><p class=\"presText\">" . stripslashes( $userPres["presText"] ) . "</p>\n";
	}



	$body.= "</p>
</div>
<div style=\"float: left; width: 370px;\">";

	if ( strlen( $thankoyu ) > 0 )
	{
		$body.= "<div id=\"thankyou\" style=\"margin-bottom: 35px;\"><ul class=\"errorList\">" . $thankoyu . "</ul></div>";
	}

	if ( strlen( $_SESSION["invitationStatus"] ) > 0 )
	{
		$body.= "<div id=\"thankyou\" style=\"margin-bottom: 35px;\"><ul class=\"errorList\">" . $_SESSION["invitationStatus"] . "</ul></div>";

		if ($_SESSION["invitationSent"] == TRUE) {
			$body.= "<script type=\"text/javascript\">

window.open('http://dev.flator.se/videochatt/','videochat','width=800,height=620');
</script>
";
		}


		
		$_SESSION["invitationStatus"] = "";
	}

	$body.= "<div class=\"section_headline\" style=\"padding-top: 10px; padding-bottom: 3px;border:none; border-bottom: 1px dotted #c8c8c8; margin-bottom:10px;\">H&auml;ndelser</div>";

	$commentedPhotos = array();
	if ($_GET["s"] == "full") {
	$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_status WHERE userId = " . (int)$userPres["id"] . " and statusType != 'newPhoto' AND (insDate > DATE_SUB(NOW(), INTERVAL 30 DAY)) ORDER BY insDate DESC ";
	$statusMax = 9999;
	} else {
	$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_status WHERE userId = " . (int)$userPres["id"] . " and statusType != 'newPhoto' ORDER BY insDate DESC LIMIT 0,50";
	$statusMax = 10;
	}
	$userStatus = $DB->CacheGetAssoc( 5, $q, FALSE, TRUE );
	if ( count( $userStatus ) > 0 )
	{
		$iStatus = 0;
		$body .= "<table border=\"0\" width=\"100%\" cellspacing=\"0px\" cellpadding=\"0px\">";
		while ( list( $key, $value ) = each( $userStatus ) )
		{
			if ($iStatus == $statusMax) {
			break;
			}
			$displayDelete = "yes";
			unset( $eventDate );
			if ( date("Y-m-d", $userStatus[ $key ]["unixTime"] ) == date( "Y-m-d" ) )
			{
				// Event updated today
				$eventDate = "idag " . date( "H:i", $userStatus[ $key ]["unixTime"] );
			}
			elseif ( date("Y-m-d", $userStatus[ $key ]["unixTime"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
			{
				// Event updated yesterday
				$eventDate = "ig&aring;r " . date( "H:i", $userStatus[ $key ]["unixTime"] );
			}
			elseif ( date("Y", $userStatus[ $key ]["unixTime"] ) == date( "Y" ) )
			{
				// Event updated this year
				$eventDate = date( "d", $userStatus[ $key ]["unixTime"] ) . " " . strtolower( months( (int)date( "m", $userStatus[ $key ]["unixTime"] ) ) ) . ", " . date( "H:i", $userStatus[ $key ]["unixTime"] );
			}
			else
			{
				$eventDate = date( "d", $userStatus[ $key ]["unixTime"] ) . " " . strtolower( months( (int)date( "m", $userStatus[ $key ]["unixTime"] ) ) ) . " " . date( "Y, H:i", $userStatus[ $key ]["unixTime"] );
			}
			if ($userStatus[ $key ]["statusType"] == "personalMessage") {
			$userStatus[ $key ]["statusMessage"] = "<span class=\"email_date\">Status:</span> ".substr(stripslashes($userStatus[ $key ]["statusMessage"]), 0, 238);

			$q = "SELECT fl_comments.*, UNIX_TIMESTAMP(fl_comments.insDate) AS unixTime, fl_users.username FROM fl_comments LEFT JOIN fl_users ON fl_users.id = fl_comments.userId WHERE fl_comments.contentId = " . (int)$userStatus[ $key ]["id"] . " and fl_comments.type = 'statusComment' ORDER BY insDate DESC";
			$userStatusComments [ $key ] = $DB->CacheGetAssoc( 30, $q, FALSE, TRUE );
			}
			if ($userStatus[ $key ]["statusType"] == "blogEntry") {

			$userStatus[ $key ]["statusMessage"] = str_replace("Nytt blogginlägg:", "<span class=\"email_date\">Nytt blogginlägg:</span>", $userStatus[ $key ]["statusMessage"]);

			if (strpos($userStatus[ $key ]["statusMessage"], 'html"></a>') > 1) {
				$userStatus[ $key ]["statusMessage"] = str_replace('html"></a>', 'html">Ingen rubrik</a>', $userStatus[ $key ]["statusMessage"]);

			}
			}
			if ($userStatus[ $key ]["statusType"] == "blogComment") {
			$userStatus[ $key ]["statusMessage"] = str_replace("Kommenterade blogginlägg:", "<span class=\"email_date\">Kommenterade blogginlägg:</span>", $userStatus[ $key ]["statusMessage"]);
			}
			if ($userStatus[ $key ]["statusType"] == "newFriend") {
			$userStatus[ $key ]["statusMessage"] = str_replace("Blev vän med:", "<span class=\"email_date\">Blev vän med:</span>", $userStatus[ $key ]["statusMessage"]);
			}
			if ($userStatus[ $key ]["statusType"] == "addedEvent") {
			$userStatus[ $key ]["statusMessage"] = str_replace("Lade till event", "<span class=\"email_date\">Lade till event:</span>", $userStatus[ $key ]["statusMessage"]);
			}



			if ($userStatus[ $key ]["statusType"] == "photoComment") {
				$regex = '/media\/photos\/(.+?)\.html/';
				$match = array();
				preg_match($regex,$userStatus[ $key ]["statusMessage"],$match);
				if (strlen($match[1]) > 0) {
				$userStatus[ $key ]["photoId"] = $match[1];
				
				}

			if (in_array($userStatus[ $key ]["photoId"], $commentedPhotos)) {
			continue;
			}
			$q = "SELECT fl_images.*, UNIX_TIMESTAMP(fl_images.insDate) AS unixTime,  fl_albums.name AS albumName,  fl_users.username AS username FROM fl_images LEFT JOIN fl_albums ON fl_images.albumId = fl_albums.id LEFT JOIN fl_users ON fl_users.id = fl_images.userId WHERE fl_images.id = '" . $userStatus[ $key ]["photoId"] . "'";
			$commentedPhoto = $DB->GetRow( $q, FALSE, TRUE );
			if (count($commentedPhoto) < 1) {
			continue;
			}
			unset( $onlineTime );
			// Possible date-types: Today, Yesterday, ThisYear, LastYear
			if ( date("Y-m-d", $commentedPhoto["unixTime"] ) == date( "Y-m-d" ) )
			{
				// Message sent today
				$onlineTime = "" . "Idag " . date( "H:i", $commentedPhoto["unixTime"] ) . "";
			}
			elseif ( date("Y-m-d", $commentedPhoto["unixTime"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
			{
				// Message sent yesterday
				$onlineTime = "" . "Ig&aring;r " . date( "H:i", $commentedPhoto["unixTime"] ) . "";
			}
			elseif ( date("Y", $commentedPhoto["unixTime"] ) == date( "Y" ) )
			{
				// Message sent this year
				$onlineTime = "" . date( "j M Y", $commentedPhoto["unixTime"] ) . "";
			}
			else
			{
				$onlineTime = "" . date( "Y-m-d", $commentedPhoto["unixTime"] ) . "";
			}

			$mediumAvatar = "http://dev.flator.se/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $commentedPhoto["serverLocation"])) . "/large/";

			$avatar = "<img src=\"http://dev.flator.se/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $commentedPhoto["serverLocation"])) . "/small-blog/\" border=\"0\" style=\"float:left;\" align=\"left\"/>";
			


			$currentcommentedPhoto = "<div style=\"float:left; margin-right:5px; border: 1px dotted #c8c8c8;padding:4px; \"><a href=\"#noexist\" onClick=\"showImage2('popupMediumCommentedImage".$key."','" . $mediumAvatar . "', 'mediumCommentedImage".$key."');\">".$avatar."</a></div>";

















			$commentedPhotos[] = $userStatus[ $key ]["photoId"];
			 

			if (strlen($commentedPhoto["name"]) > 0) {
				if (strlen($commentedPhoto["name"]) > 15) {
					$commentedPhoto["name"] = substr(strip_tags($commentedPhoto["name"]), 0, 13).".."; }
			} else {
				$commentedPhoto["name"] = "<i>Inget namn</i>";
			}


			$userStatus[ $key ]["statusMessage"] = '<a href=\"http://dev.flator.se/media/photos/'.$commentedPhoto["id"].'.html\"><i>'.$commentedPhoto["name"].'</i></a><span class="email_date"> av </span><a href=\"http://dev.flator.se/user/'.stripslashes($commentedPhoto["username"]).'.html\">'.$commentedPhoto["username"].'</a> <span class="email_date">uppladdad '.$onlineTime.'</span><br><span class="email_date">Bild ur albumet</span> "<a href="http://dev.flator.se/media/album/'.$commentedPhoto["albumId"].'.html">'.$commentedPhoto["albumName"].'</a>"';
	
			$userStatus[ $key ]["statusMessage"] .= "<div style=\"position:relative;\"><div id=\"popupMediumCommentedImage".$key."\" style=\"display: none; position:absolute;border: 2px solid #645d54; top: 0px; left: 0px; z-index: 101; background-color: #ffffff; \"><div style=\"margin: 0px;\"><div style=\"float: left; display: block;\"><a href=\"javascript:void(null)\" onclick=\"closeImage2('popupMediumCommentedImage".$key."');\"><img src=\"".$baseUrl."/img/symbols/gif_avatars/person_avantar_stor.gif\" id=\"mediumCommentedImage".$key."\" border=\"0\" style=\"margin: 3px;\" /></a></div></div></div></div>";


			$q = "SELECT fl_comments.*, UNIX_TIMESTAMP(fl_comments.insDate) AS unixTime, fl_users.username FROM fl_comments LEFT JOIN fl_users ON fl_users.id = fl_comments.userId WHERE fl_comments.contentId = " . (int)$userStatus[ $key ]["photoId"] . " and fl_comments.type = 'photoComment' ORDER BY insDate DESC";
			$userStatusComments [ $key ] = $DB->CacheGetAssoc( 30, $q, FALSE, TRUE );
			if (count($userStatusComments[ $key ]) < 1) {
			continue;
			}
			}

			
			if ($userStatus[ $key ]["statusType"] == "tagStatus") {

			$q = "SELECT fl_images.*, UNIX_TIMESTAMP(fl_images.insDate) AS unixTime,  fl_albums.name AS albumName,  fl_users.username AS username FROM fl_images LEFT JOIN fl_albums ON fl_images.albumId = fl_albums.id LEFT JOIN fl_users ON fl_users.id = fl_images.userId WHERE fl_images.id = '" . $userStatus[ $key ]["photoIds"] . "'";
			$commentedPhoto = $DB->GetRow( $q, FALSE, TRUE );
			if (count($commentedPhoto) < 1) continue;

			if ((int)$userStatus[ $key ]["tagId"] > 0) {
			$q = "SELECT *  FROM `fl_tags` WHERE `id` = '" . $userStatus[ $key ]["tagId"] . "' AND `targetId` = '" . $userStatus[ $key ]["userId"] . "'";
			$confirmTags = $DB->GetRow( $q, FALSE, TRUE );
			if (count($confirmTags) < 1) continue;
			}

			unset( $onlineTime );
			// Possible date-types: Today, Yesterday, ThisYear, LastYear
			if ( date("Y-m-d", $commentedPhoto["unixTime"] ) == date( "Y-m-d" ) )
			{
				// Message sent today
				$onlineTime = "" . "Idag " . date( "H:i", $commentedPhoto["unixTime"] ) . "";
			}
			elseif ( date("Y-m-d", $commentedPhoto["unixTime"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
			{
				// Message sent yesterday
				$onlineTime = "" . "Ig&aring;r " . date( "H:i", $commentedPhoto["unixTime"] ) . "";
			}
			elseif ( date("Y", $commentedPhoto["unixTime"] ) == date( "Y" ) )
			{
				// Message sent this year
				$onlineTime = "" . date( "j M Y", $commentedPhoto["unixTime"] ) . "";
			}
			else
			{
				$onlineTime = "" . date( "Y-m-d", $commentedPhoto["unixTime"] ) . "";
			}

			$mediumAvatar = "http://dev.flator.se/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $commentedPhoto["serverLocation"])) . "/large/";

			$avatar = "<img src=\"http://dev.flator.se/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $commentedPhoto["serverLocation"])) . "/small-blog/\" border=\"0\" style=\"float:left;\" align=\"left\"/>";
			


			$currentcommentedPhoto = "<div style=\"float:left; margin-right:5px; border: 1px dotted #c8c8c8;padding:4px; \"><a href=\"#noexist\" onClick=\"showImage2('popupMediumCommentedImage".$key."','" . $mediumAvatar . "', 'mediumCommentedImage".$key."');\">".$avatar."</a></div>";
			 

			if (strlen($commentedPhoto["name"]) > 0) {
				if (strlen($commentedPhoto["name"]) > 15) {
					$commentedPhoto["name"] = substr(strip_tags($commentedPhoto["name"]), 0, 13).".."; }
			} else {
				$commentedPhoto["name"] = "<i>Inget namn</i>";
			}


			$userStatus[ $key ]["statusMessage"] = '<span class=\"email_date\">Blev taggad i bilden</span> <a href=\"http://dev.flator.se/media/photos/'.$commentedPhoto["id"].'.html\"><i>'.$commentedPhoto["name"].'</i></a> <span class="email_date">från albumet</span> "<a href="http://dev.flator.se/media/album/'.$commentedPhoto["albumId"].'.html">'.$commentedPhoto["albumName"].'</a>"<span class="email_date"> av </span><a href=\"http://dev.flator.se/user/'.stripslashes($commentedPhoto["username"]).'.html\">'.$commentedPhoto["username"].'</a>';
	
			$userStatus[ $key ]["statusMessage"] .= "<div style=\"position:relative;\"><div id=\"popupMediumCommentedImage".$key."\" style=\"display: none; position:absolute;border: 2px solid #645d54; top: 0px; left: 0px; z-index: 101; background-color: #ffffff; \"><div style=\"margin: 0px;\"><div style=\"float: left; display: block;\"><a href=\"javascript:void(null)\" onclick=\"closeImage2('popupMediumCommentedImage".$key."');\"><img src=\"".$baseUrl."/img/symbols/gif_avatars/person_avantar_stor.gif\" id=\"mediumCommentedImage".$key."\" border=\"0\" style=\"margin: 3px;\" /></a></div></div></div></div>";

			}




if ($userStatus[ $key ]["statusType"] == "forumEntry") {

			$q = "SELECT fl_forum_threads.*, fl_forum_cat.shortname FROM fl_forum_threads LEFT JOIN fl_forum_cat ON fl_forum_threads.catId = fl_forum_cat.id WHERE fl_forum_threads.id = '" . (int)$userStatus[ $key ]["statusMessage"] . "'";
			$forumThreadEntry = $DB->GetRow( $q, FALSE, TRUE );
			if (count($forumThreadEntry) < 1) continue;

			if ($forumThreadEntry["newThread"] == "YES") {
				$userStatus[ $key ]["statusMessage"] = '<span class="email_date">Skapade en ny forumtråd:</span> <a href="'.$baseUrl.'/forum/'.$forumThreadEntry["shortname"].'/'.$forumThreadEntry["slug"].'.html\">'.$forumThreadEntry["headline"].'</a>.';
			} else {
				$q = "SELECT fl_forum_threads.* FROM fl_forum_threads WHERE id = '" . (int)$forumThreadEntry["threadId"] . "'";
				$forumThreadEntry_base = $DB->GetRow( $q, FALSE, TRUE );
				if (count($forumThreadEntry_base) < 1) continue;
				$forumThreadEntry["headline"] = $forumThreadEntry_base["headline"];
				$userStatus[ $key ]["statusMessage"] = '<span class="email_date">Skrev ett inlägg i forumtråden:</span> <a href="'.$baseUrl.'/forum/'.$forumThreadEntry["shortname"].'/'.$forumThreadEntry["slug"].'.html\">'.$forumThreadEntry["headline"].'</a>.';

			}



	


			}





			if ($userStatus[ $key ]["statusType"] == "newPhotosUploaded") {
			$symbol = '<img src="http://dev.flator.se/img/symbols/gif_purple/bild.gif" style="vertical-align:top;margin-top:3px;" border="0">';
			} elseif ($userStatus[ $key ]["statusType"] == "personalMessage") {
			$symbol = '<img src="http://dev.flator.se/img/symbols/gif_purple/logga_in.gif" style="vertical-align:top;margin-top:3px;" border="0">';
			} elseif ($userStatus[ $key ]["statusType"] == "newFriend") {
			$symbol = '<img src="http://dev.flator.se/img/symbols/gif_purple/van.gif" style="vertical-align:top;margin-top:3px;" border="0">';
			} elseif ($userStatus[ $key ]["statusType"] == "blogEntry") {
			$symbol = '<img src="http://dev.flator.se/img/symbols/gif_purple/blogg.gif" style="vertical-align:top;margin-top:3px;" border="0">';
			} elseif ($userStatus[ $key ]["statusType"] == "blogComment") {
			$symbol = '<img src="http://dev.flator.se/img/symbols/gif_purple/lamna_kommentar.gif" style="vertical-align:top;margin-top:3px;" border="0">';
			} elseif ($userStatus[ $key ]["statusType"] == "addedEvent") {
			$symbol = '<img src="http://dev.flator.se/img/symbols/gif_purple/typ_av_event.gif" style="vertical-align:top;margin-top:3px;" border="0">';
			} elseif ($userStatus[ $key ]["statusType"] == "photoComment") {
			$symbol = '<img src="http://dev.flator.se/img/symbols/gif_purple/bild.gif" style="vertical-align:top;margin-top:6px;"  border="0">';
			//$symbol = $currentcommentedPhoto;
			} elseif ($userStatus[ $key ]["statusType"] == "tagStatus") {
			$symbol = '<img src="http://dev.flator.se/img/symbols/gif_purple/tagga2.gif" style="vertical-align:top;margin-top:6px;" border="0">';
			} elseif ($userStatus[ $key ]["statusType"] == "forumEntry") {
			$symbol = '<img src="http://dev.flator.se/img/symbols/gif_purple/grupp.gif" style="vertical-align:top;margin-top:3px;" border="0">';
			} else {
			$symbol = "";
			}

			 
	

			if ($userStatus[ $key ]["statusType"] == "newPhotosUploaded" && $userStatus[ $key ]["photoIds"] != "") {
			

					$q = "SELECT fl_images.*, UNIX_TIMESTAMP(fl_images.insDate) AS unixTime, fl_users.username, fl_users.insDate AS joinedDate FROM fl_images LEFT JOIN fl_users ON fl_users.id = fl_images.userId WHERE fl_images.id IN (".$userStatus[ $key ]["photoIds"].") ORDER BY fl_images.insDate ASC";

						$albumPhotos = $DB->CacheGetAssoc( 30, $q, FALSE, TRUE );
						if ( count( $albumPhotos ) > 0 )
						{
								if ( count( $albumPhotos ) > 1) {
								$photoString = "bilder / filmer"; 
							} else {
									$photoString = "bild / film";
							}
										$body .= "<tr><td style=\"vertical-align:top;\" width=\"30px\" valign=\"top\">".$symbol."</td><td style=\"\" width=\"300px\">";

							$body.= "<span class=\"presStatus\"> <span class=\"status_history\"><span class=\"email_date\">Laddade upp:</span> " . count( $albumPhotos ) . " ".$photoString.".</span> <span class=\"email_date\">" . $eventDate . "</span>\n";

									$body .= "<div style=\"float:left; background: url('http://dev.flator.se/img/meny_pil_gif.gif') no-repeat 7px 0px; padding-top:10px; margin-top:3px; margin-bottom:5px;\"><div style=\"float:left; padding-top:5px; padding-left:5px; padding-bottom:5px;margin-right:10px; margin-top:0px; border: 1px dotted #c8c8c8; max-width:200px;\">";

									$albumPhotosString = "";
									$i = 1;
							while ( list( $key2, $value2 ) = each( $albumPhotos ) )
							{
							
								$hoverAction = " onMouseOver=\"document.getElementById( 'hover".$key2."').style.display='block'\" onMouseOut=\"document.getElementById( 'hover".$key2."').style.display='none';\"";
								if ( strlen( $albumPhotos[ $key2 ]["serverLocation"] ) > 0 )
								{	
									$thumbcss = "<div class=\"blog_thumbs_hoverImage\" style=\"display:none\" id=\"hover".$key2."\"></div>";
									$marginBetween = "4px";
									$removeThumb = "";
									

									//$body .= '<a href="http://dev.flator.se/media/photos/'.$albumPhotos[ $key2 ]["id"].'.html">';
									if (($i % 4) == 0) {
									$body .= "<div class=\"blog_thumbs_Image\" OnClick=\"location.href='http://dev.flator.se/media/photos/".$albumPhotos[ $key2 ]["id"].".html';\" style=\"background: transparent url(http://dev.flator.se/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $albumPhotos[ $key2 ]["serverLocation"])) . "/small-blog/) no-repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; margin-right:5px; margin-bottom:".$marginBetween.";\"".$hoverAction.">".$thumbcss."</div>".$removeThumb."<br>";
									} else {
									$body .= "<div class=\"blog_thumbs_Image\" OnClick=\"location.href='http://dev.flator.se/media/photos/".$albumPhotos[ $key2 ]["id"].".html';\" style=\"background: transparent url(http://dev.flator.se/user-photos/" . urlencode(str_replace($usedImagesServerPaths, "", $albumPhotos[ $key2 ]["serverLocation"])) . "/small-blog/) no-repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;margin-right:5px; margin-bottom:".$marginBetween.";\"".$hoverAction.">".$thumbcss."</div>".$removeThumb."";
									}
									$body .= '</a>';
								}
							}
							
						$body .= "</div></div><div style=\"clear:both; margin:0px;padding:0px;\"></div>";
							$body .= "</span>";
						} else {
						$displayDelete = "no";
						continue;
						}
		
			} else {
							$body .= "<tr><td style=\"vertical-align:top;\" width=\"30px\" valign=\"top\">".$symbol."</td><td style=\"\" width=\"300px\">";

				if ($userStatus[ $key ]["statusType"] == "photoComment") {
					$body.= "<span class=\"presStatus\">".$currentcommentedPhoto." <span class=\"status_commentedPhoto\">" . stripslashes( $userStatus[ $key ]["statusMessage"] ) . "</span> \n";
				} elseif ($userStatus[ $key ]["statusType"] == "tagStatus") {
					$body.= "<span class=\"presStatus\">".$currentcommentedPhoto." <span class=\"status_commentedPhoto\">" . stripslashes( $userStatus[ $key ]["statusMessage"] ) . "</span> <span class=\"email_date\">" . $eventDate . "</span>\n";					
				} else {
				$body.= "<span class=\"presStatus\"> <span class=\"status_history\">" . stripslashes( $userStatus[ $key ]["statusMessage"] ) . "</span> <span class=\"email_date\">" . $eventDate . "</span>\n";
				}


			if (count($userStatusComments[$key]) > 0) {
				$body .= "<div style=\"float:left; background: url('http://dev.flator.se/img/meny_pil_gif.gif') no-repeat 0px 0px; padding-top:8px;margin-left:0px; margin-top:5px; \" id=\"statusComment".$key."\" >";
				while ( list( $key3, $value3 ) = each( $userStatusComments[$key] ) )
					{
					$q = "SELECT * FROM fl_images WHERE userId = " . (int)$userStatusComments[$key][ $key3 ]["userId"] . " AND imageType = 'profileSmall'";
					$guestImage = $DB->GetRow( $q, FALSE, TRUE );
					if ( count( $guestImage ) > 0 )
					{
						#$avatar = "<img src=\"" . $guestImage["imageUrl"] . "\" border=\"0\" width=\"" . $guestImage["width"] . "\" height=\"" . $guestImage["height"] . "\" style=\"margin-bottom:8px; margin-left:4px;margin-top:8px; margin-right:5px;\" />";
						$avatar = "<img src=\"" . $baseUrl . "/user-photos/" . str_replace('http://dev.flator.se/rwdx/user/', '', $guestImage["imageUrl"]) . "/profile-small/\" style=\"margin-bottom:8px; margin-left:4px;margin-top:8px; margin-right:5px;\" />";

					}
					else
					{
						$avatar = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/person_avnatar_liten.gif\" border=\"0\" width=\"26\" height=\"29\" style=\"margin-bottom:8px; margin-left:4px;margin-top:8px; margin-right:5px;\" />";
					}

					$q = "SELECT * FROM fl_images WHERE userId = " . (int)$userStatusComments[$key][ $key3 ]["userId"] . " AND imageType = 'profileMedium'";
					$guestImage = $DB->GetRow( $q, FALSE, TRUE );
					if ( count( $guestImage ) > 0 )
					{
						#$mediumAvatar = $guestImage["imageUrl"];
						$mediumAvatar = "" . $baseUrl . "/user-photos/" . str_replace('http://dev.flator.se/rwdx/user/', '', $guestImage["imageUrl"]) . "/profile/";
					}
					else
					{
						$mediumAvatar = $baseUrl . "/img/symbols/gif_avatars/person_avantar_stor.gif";
					}


					unset( $wallDate );
					if ( date("Y-m-d", $userStatusComments[$key][ $key3 ]["unixTime"] ) == date( "Y-m-d" ) )
					{
						// Event updated today
						$wallDate = "idag " . date( "H:i", $userStatusComments[$key][ $key3 ]["unixTime"] );
					}
					elseif ( date("Y-m-d", $userStatusComments[$key][ $key3 ]["unixTime"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
					{
						// Event updated yesterday
						$wallDate = "ig&aring;r " . date( "H:i", $userStatusComments[$key][ $key3 ]["unixTime"] );
					}
					elseif ( date("Y", $userStatusComments[$key][ $key3 ]["unixTime"] ) == date( "Y" ) )
					{
						// Event updated this year
						$wallDate = date( "d", $userStatusComments[$key][ $key3 ]["unixTime"] ) . " " . strtolower( months( (int)date( "m", $userStatusComments[$key][ $key3 ]["unixTime"] ) ) ) . ", " . date( "H:i", $userStatusComments[$key][ $key3 ]["unixTime"] );
					}
					else
					{
						$wallDate = date( "d", $userStatusComments[$key][ $key3 ]["unixTime"] ) . " " . strtolower( months( (int)date( "m", $userStatusComments[$key][ $key3 ]["unixTime"] ) ) ) . " " . date( "Y, H:i", $userStatusComments[$key][ $key3 ]["unixTime"] );
					}
					
					$body .= "<table width=\"310px\" border=\"0\" cellpadding=\"0px\" cellspacing=\"0px\" style=\"margin-left:0px; z-index:50; border: 1px dotted #c8c8c8; margin-top:0px;padding-top:0px; border-bottom:0px;\">";
					$body .= "<tr style=\" width:100%;\">";
					$body .= "<td width=\"45px\" valign=\"top\"><center><a href=\"#noexist\" onClick=\"showImage2('popupMediumStatusImage".$key."','" . $mediumAvatar . "', 'mediumStatusImage".$key."');\" style=\"font-weight: normal\">" . $avatar . "</a></center>";
						$body .= "<div style=\"position:relative;\"><div id=\"popupMediumStatusImage".$key."\" style=\"display: none; position:absolute;border: 2px solid #645d54; top: 0px; left: 0px; z-index: 101; background-color: #ffffff; \"><div style=\"margin: 0px;\"><div style=\"float: left; display: block;\"><a href=\"javascript:void(null)\" onclick=\"closeImage2('popupMediumStatusImage".$key."');\"><img src=\"".$baseUrl."/img/symbols/gif_avatars/person_avantar_stor.gif\" id=\"mediumStatusImage".$key."\" border=\"0\" style=\"margin: 3px;\" /></a></div></div></div></div>";
						$body .= "</td>";
					$body .= "<td width=\"350px\" valign=\"top\" style=\"font-size:12px;overflow:hidden;line-height:17px;padding-top:8px;\"><a href=\"" . $baseUrl . "/user/" . $userStatusComments[$key][ $key3 ]["username"] . ".html\">" . $userStatusComments[$key][ $key3 ]["username"] . "</a> <span class=\"email_date\">" . $wallDate . "</span><br />" . $userStatusComments[$key][ $key3 ]["comment"]."";
				
					$body .= "</td>";
					if ($userPres[ "id" ] == (int)$userProfile["id"] ||  (int)$userProfile["id"] == (int)$userStatusComments[$key][ $key3 ]["userId"]) {
					$body .= "<td style=\"text-align:right;padding-top:7px;\" valign=\"top\">";
					$body .= "<a href=\"#noexist\" class=\"deleteLink\" OnClick=\"if(confirm('Ta bort denna kommentar?')) { location.search='?do=deleteStatusComment&statusId=" . $userStatusComments[$key][ $key3 ]["id"] ."'; } else { return false; }\"><img src=\"".$baseUrl."/img/symbols/gif_purple/kryss_litet.png\" border=\"0\" width=\"8px\" height=\"8px\" style=\"margin-right:4px\" name=\"deleteStatusCommentImg".$key."\" onMouseOver=\"document.deleteStatusCommentImg".$key.".src='".$baseUrl."/img/symbols/gif_red/kryss_litet.png'\" onMouseOut=\"document.deleteStatusCommentImg".$key.".src='".$baseUrl."/img/symbols/gif_purple/kryss_litet.png'\"></a>";
					$body .= "</td>";
					}
					
					$body .= "</tr>";
					$body .= "<tr>";
					
					$body .= "</tr>";
					$body .= "</table>";

					$body .= "";




					}

					$body .= "<table width=\"310px\" border=\"0\" cellpadding=\"0px\" cellspacing=\"4px\" style=\"margin-left:0px; border: 1px dotted #c8c8c8; margin-top:0px;padding:0px; background-color:#C8C8C8;\">";
					$body .= "<tr style=\" width:100%;\">";
					if ($userStatus[ $key ]["statusType"] == "personalMessage") {
						$newCommentType = "statusComment";
						$statusId = $userStatus[ $key ]["id"];
					}
					if ($userStatus[ $key ]["statusType"] == "photoComment") {
						$newCommentType = "photoComment";
						$statusId = $userStatus[ $key ]["photoId"];
					}
					$body .= "<td width=\"100%\" valign=\"top\" style=\"font-size:12px; background-color:#fff;\" class=\"commentBox\">
					<form method=\"POST\"  style=\"margin: 0px; padding: 0px\">
					<input type=\"hidden\" name=\"type\" value=\"".$newCommentType."\">
					<input type=\"hidden\" name=\"statusId\" value=\"" . $statusId ."\">
					<input type=\"text\" class=\"txtSearch\" name=\"comment\"  value=\"Skriv en kommentar\" onfocus=\"changeValueTemp(this);\" onblur=\"changeValueTemp(this);\" style=\"width: 250px;color:#A1A199;  font-size:12px; margin-top:1px;\" />
<input type=\"submit\" name=\"Skicka\" value=\"\" class=\"btnSearch\" /></form></td>";
					$body .= "</tr>";
					$body .= "</table>";



				} else {

					if ($userStatus[ $key ]["statusType"] == "personalMessage") {
					
					$body .= "<a href=\"#noexist\" class=\"commentLink\" onClick=\"document.getElementById('writeComment".$key."').style.display='none';document.getElementById('statusComment".$key."').style.display='block';return false\" id=\"writeComment".$key."\">Kommentera</a>";

					}
				}

				$body .= "<br></span>";
			}

			$body .= "</td>";
			
			if ($userPres[ "id" ] == (int)$userProfile["id"] && $displayDelete != "no") {
			$body .= "<td style=\"text-align:right;padding-top:7px;\" valign=\"top\">";
			$body .= "<a href=\"#noexist\" class=\"deleteLink\" OnClick=\"if(confirm('Ta bort denna händelse?')) { location.search='?do=deleteHistory&statusId=" . $userStatus[ $key ]["id"] ."'; } else { return false; }\"><img src=\"".$baseUrl."/img/symbols/gif_purple/kryss_litet.png\" border=\"0\" width=\"8px\" height=\"8px\" name=\"deleteStatusImg".$key."\" onMouseOver=\"document.deleteStatusImg".$key.".src='".$baseUrl."/img/symbols/gif_red/kryss_litet.png'\" onMouseOut=\"document.deleteStatusImg".$key.".src='".$baseUrl."/img/symbols/gif_purple/kryss_litet.png'\"></a>";
			$body .= "</td>";
			}
			
			if ($userStatus[ $key ]["statusType"] == "personalMessage") { 
				
					$body .= "<tr><td colspan=\"3\"><div style=\" background: url('http://dev.flator.se/img/meny_pil_gif.gif') no-repeat 7px 2px; padding-top:0px;display:none; \" id=\"statusComment".$key."\" ><table width=\"370px\" border=\"0\" cellpadding=\"0px\" cellspacing=\"4px\" style=\"margin-left:0px; border: 1px dotted #c8c8c8; margin-top:10px;padding:0px; background-color:#C8C8C8;\">";
					$body .= "<tr style=\" width:100%;\">";
					$body .= "<td width=\"100%\" valign=\"top\" style=\"font-size:12px; background-color:#fff;\" class=\"commentBox\">
					<form method=\"POST\"  style=\"margin: 0px; padding: 0px\">
					<input type=\"hidden\" name=\"type\" value=\"statusComment\">
					<input type=\"hidden\" name=\"statusId\" value=\"" . $userStatus[ $key ]["id"] ."\">
					<input type=\"text\" class=\"txtSearch\" name=\"comment\"  value=\"Skriv en kommentar\" onfocus=\"changeValueTemp(this);\" onblur=\"changeValueTemp(this);\" style=\"width: 310px;color:#A1A199; font-size:12px; margin-top:1px;\" />
<input type=\"submit\" name=\"Skicka\" value=\"\" class=\"btnSearch\" /></form></td>";
					$body .= "</tr>";
					$body .= "</table></div></td></tr>";
			}

			
			$body .= "</tr>";
			$body .= "<tr><td colspan=\"1\" style=\"height:11px;font-size:6px; line-height: 6px;\" height=\"4px\">&nbsp;</td></tr>";
			$iStatus++;
		}
		$body .= "</table>";
	} else {
	$body .= "<i>Du har inte gjort något här på Flator.se än.. Sätt igång och sprid lite glädje!</i>";
	}
	$body .= "<table width=\"100%\" border=\"0\" style=\"clear:both; border-top: 1px dotted #c8c8c8;margin-top:3px;margin-bottom:4px;\"><tr><td></td></tr></table>";
	if ($_GET["s"] == "full") {
$body.= "\n
<div id=\"showLatestMonth\" onMouseOver=\"document.showLatest.src='" . $baseUrl . "/img/symbols/gif_red/handelser.gif'\" onMouseOut=\"document.showLatest.src='" . $baseUrl . "/img/symbols/gif_purple/handelser.gif'\" style=\"text-transform: none;font-size:12px;float:right;\"><nobr><a href=\"" . $baseUrl . "/user/".stripslashes($userPres["username"]).".html\" style=\"font-weight:normal;\" class=\"presLink\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/handelser.gif\" name=\"showLatest\" style=\"vertical-align:middle;\" border=\"0\" /> Visa 10 senaste</a></nobr></div>";
	} else {
$body.= "\n
<div id=\"showLatestMonth\" onMouseOver=\"document.showLatest.src='" . $baseUrl . "/img/symbols/gif_red/handelser.gif'\" onMouseOut=\"document.showLatest.src='" . $baseUrl . "/img/symbols/gif_purple/handelser.gif'\" style=\"text-transform: none;font-size:12px;float:right;\"><nobr><a href=\"" . $baseUrl . "/user/".stripslashes($userPres["username"]).".html?s=full\" style=\"font-weight:normal;\" class=\"presLink\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/handelser.gif\" name=\"showLatest\" style=\"vertical-align:middle;\" border=\"0\" /> Visa senaste månaden</a></nobr></div>";
	}

	$body.= "
<br><br><br>
<div style=\"font-weight: bold; text-transform: uppercase; color: #645d54; font-size: 14px;float:left;\">V&auml;ggen</div> <div id=\"writeWall\" onMouseOver=\"document.writeWall1.src='" . $baseUrl . "/img/symbols/gif_red/annonser_erbjudanden.gif'\" onMouseOut=\"document.writeWall1.src='" . $baseUrl . "/img/symbols/gif_purple/annonser_erbjudanden.gif'\" style=\"text-transform: none;font-size:12px;float:right;\"><nobr><a href=\"#\" style=\"font-weight:normal;\" onClick=\"document.getElementById('writeWall').style.display='none';document.getElementById('wallForm').style.display='block';return false\" class=\"presLink\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/annonser_erbjudanden.gif\" name=\"writeWall1\" style=\"vertical-align:middle;margin-bottom:2px;\" border=\"0\" /> Skriv på väggen</a></nobr></div><br><table width=\"100%\" border=\"0\" style=\"clear:both; border-top: 1px dotted #c8c8c8;margin-top:3px;margin-bottom:10px;\"><tr><td></td></tr></table>";
	
	if ( strlen( $error ) > 0 )
	{
		$body.= "<div id=\"error\" style=\"margin-bottom: 35px;\"><ul class=\"errorList\">" . $error . "</ul></div>";
	}

	$body.= "<form id=\"wallForm\" method=\"post\" style=\"margin: 0px; padding: 0px; display: none\" name=\"form\">
<input type=\"hidden\" name=\"type\" value=\"wall\">
<p>Skriv meddelande:<br /><div style=\"float: left; margin-bottom: 20px\"><textarea name=\"message\" style=\"height: 40px; width: 370px;\"></textarea></div></p>

<p><div style=\"display:block; float: right; margin-right: 11px\"><span onMouseOver=\"document.writeGuestbook.src='" . $baseUrl . "/img/symbols/gif_red/skicka.gif'\" onMouseOut=\"document.writeGuestbook.src='" . $baseUrl . "/img/symbols/gif_purple/skicka.gif'\"><nobr><a href=\"#noexist\" onClick=\"document.form.submit();\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/skicka.gif\" name=\"writeGuestbook\" style=\"vertical-align:middle;\" border=\"0\" />Skicka</a></nobr></span></div></p>
<br><br></form>";
	
	if ($_GET["w"] == "full") {
	$q = "SELECT fl_guestbook.*, fl_users.username, UNIX_TIMESTAMP( fl_guestbook.insDate ) AS unixTime FROM fl_guestbook LEFT JOIN fl_users ON fl_users.id = fl_guestbook.userId WHERE recipentUserId = " . (int)$userPres["id"] . " AND deleted = 'NO' ORDER BY insDate DESC";
	$statusMax = 9999;
	} else {
	$q = "SELECT fl_guestbook.*, fl_users.username, UNIX_TIMESTAMP( fl_guestbook.insDate ) AS unixTime FROM fl_guestbook LEFT JOIN fl_users ON fl_users.id = fl_guestbook.userId WHERE recipentUserId = " . (int)$userPres["id"] . " AND deleted = 'NO' ORDER BY insDate DESC LIMIT 10";
	$statusMax = 10;
	}

	$userGuestbook = $DB->CacheGetAssoc( 30, $q, FALSE, TRUE );
	if ( count( $userGuestbook ) > 0 )
	{
		while ( list( $key, $value ) = each( $userGuestbook ) )
		{
			$q = "SELECT * FROM fl_images WHERE userId = " . (int)$userGuestbook[ $key ]["userId"] . " AND imageType = 'profileSmall'";
			$guestImage = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $guestImage ) > 0 )
			{
				$avatar = "<img src=\"" . $baseUrl . "/user-photos/" . str_replace('http://dev.flator.se/rwdx/user/', '', $guestImage["imageUrl"]) . "/profile-thumb/" . "\" border=\"0\"  />";
				

			}
			else
			{
				$avatar = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/person_avnatar_liten.gif\" border=\"0\" width=\"26\" height=\"29\" />";
			}

			$q = "SELECT * FROM fl_images WHERE userId = " . (int)$userGuestbook[ $key ]["userId"] . " AND imageType = 'profileMedium'";
			$guestImage = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $guestImage ) > 0 )
			{
				$mediumAvatar = $guestImage["imageUrl"];
			}
			else
			{
				$mediumAvatar = $baseUrl . "/img/symbols/gif_avatars/person_avantar_stor.gif";
			}

			unset( $wallDate );
			if ( date("Y-m-d", $userGuestbook[ $key ]["unixTime"] ) == date( "Y-m-d" ) )
			{
				// Event updated today
				$wallDate = "idag " . date( "H:i", $userGuestbook[ $key ]["unixTime"] );
			}
			elseif ( date("Y-m-d", $userGuestbook[ $key ]["unixTime"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
			{
				// Event updated yesterday
				$wallDate = "ig&aring;r " . date( "H:i", $userGuestbook[ $key ]["unixTime"] );
			}
			elseif ( date("Y", $userGuestbook[ $key ]["unixTime"] ) == date( "Y" ) )
			{
				// Event updated this year
				$wallDate = date( "d", $userGuestbook[ $key ]["unixTime"] ) . " " . strtolower( months( (int)date( "m", $userGuestbook[ $key ]["unixTime"] ) ) ) . ", " . date( "H:i", $userGuestbook[ $key ]["unixTime"] );
			}
			else
			{
				$wallDate = date( "d", $userGuestbook[ $key ]["unixTime"] ) . " " . strtolower( months( (int)date( "m", $userGuestbook[ $key ]["unixTime"] ) ) ) . " " . date( "Y, H:i", $userGuestbook[ $key ]["unixTime"] );
			}

			$body .= "<table width=\"100%\" border=\"0\" cellpadding=\"0px\" cellspacing=\"0px\">";
			$body .= "<tr style=\"margin-bottom: 40px; width:100%;\">";
			$body .= "<td width=\"60px\" valign=\"top\"><a href=\"#noexist\"  style=\"font-weight: normal\" onClick=\"showImage2('popupMediumWallImage".$key."','" . $mediumAvatar . "', 'mediumWallImage".$key."');\">" . $avatar . "</a></td>";
			$body .= "<td width=\"310px\" valign=\"top\" style=\"font-size:12px;\"><a href=\"" . $baseUrl . "/user/" . $userGuestbook[ $key ]["username"] . ".html\">" . $userGuestbook[ $key ]["username"] . "</a> skrev<br /><span class=\"email_date\">" . $wallDate . "</span><br />" . $userGuestbook[ $key ]["message"]."";
			$body .= "<div style=\"position:relative;\"><div id=\"popupMediumWallImage".$key."\" style=\"display: none; position:absolute;border: 2px solid #645d54; top: 0px; left: 0px; z-index: 101; background-color: #ffffff; \"><div style=\"margin: 0px;\"><div style=\"float: left; display: block;\"><a href=\"javascript:void(null)\" onclick=\"closeImage2('popupMediumWallImage".$key."');\"><img src=\"".$baseUrl."/img/symbols/gif_avatars/person_avantar_stor.gif\" id=\"mediumWallImage".$key."\" border=\"0\" style=\"margin: 3px;\" /></a></div></div></div></div>";
			$body .= "</td>";
			$body .= "<td width=\"50px\" valign=\"top\" style=\"text-align:right;\">";
			if (($userGuestbook[ $key ][ "userId" ] != (int)$userProfile["id"]) && $editPresentation == TRUE  ) {
			$body .= "<a href=\"#noexist\" class=\"answerLink\" id=\"answerWallImg".$key."\" OnClick=\"document.getElementById('answerWallImg".$key."').style.display='none';document.getElementById('answerWallForm".$key."').style.display='block';return false\"><img src=\"".$baseUrl."/img/symbols/gif_purple/svara_liten.gif\" border=\"0\" width=\"8px\" height=\"8px\" name=\"answerWallImg".$key."\"  onMouseOver=\"document.answerWallImg".$key.".src='".$baseUrl."/img/symbols/gif_red/svara_liten.gif'\" onMouseOut=\"document.answerWallImg".$key.".src='".$baseUrl."/img/symbols/gif_purple/svara_liten.gif'\"></a>&nbsp;&nbsp;";
			}

			if (($userGuestbook[ $key ][ "userId" ] == (int)$userProfile["id"]) || ( $editPresentation == TRUE ) ) {
			$body .= "<a href=\"#noexist\" class=\"deleteLink\" OnClick=\"if(confirm('Ta bort detta väggmeddelande?')) { location.search='?do=deleteWall&wallId=" . $userGuestbook[ $key ]["id"]."'; } else { return false; }\"><img src=\"".$baseUrl."/img/symbols/gif_purple/kryss_litet.png\" border=\"0\" width=\"8px\" height=\"8px\" name=\"deleteWallImg".$key."\" onMouseOver=\"document.deleteWallImg".$key.".src='".$baseUrl."/img/symbols/gif_red/kryss_litet.png'\" onMouseOut=\"document.deleteWallImg".$key.".src='".$baseUrl."/img/symbols/gif_purple/kryss_litet.png'\"></a>";
			}
				
			$body .= "</td>";
			$body .= "</tr>";
			$body .= "<tr>";
			$body .= "<td colspan=\"3\">&nbsp;</td>";
			$body .= "</tr>";
			$body .= "</table>";
			if (($userGuestbook[ $key ][ "userId" ] != (int)$userProfile["id"]) && $editPresentation == TRUE  ) {
			$body .= "<form id=\"answerWallForm".$key."\" method=\"post\" style=\"margin: 0px; padding: 0px; display: none\" name=\"answerform".$key."\">
<input type=\"hidden\" name=\"type\" value=\"wallAnswer\">
<input type=\"hidden\" name=\"userId\" value=\"".$userGuestbook[ $key ][ "userId" ]."\">
<input type=\"hidden\" name=\"userName\" value=\"".$userGuestbook[ $key ][ "username" ]."\">
<p>Skriv svar till <a href=\"" . $baseUrl . "/user/" . $userGuestbook[ $key ]["username"] . ".html\">" . $userGuestbook[ $key ]["username"] . "</a>:<br /><div style=\"float: left; margin-bottom: 20px\"><textarea name=\"message\" style=\"height: 40px; width: 370px;\"></textarea></div></p>

<p><div style=\"display:block; float: right; margin-right: 11px\"><span onMouseOver=\"document.answerWallFormSubmitImg".$key.".src='" . $baseUrl . "/img/symbols/gif_red/skicka.gif'\" onMouseOut=\"document.answerWallFormSubmitImg".$key.".src='" . $baseUrl . "/img/symbols/gif_purple/skicka.gif'\"><nobr><a href=\"#noexist\" onClick=\"document.answerform".$key.".submit();\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/skicka.gif\" name=\"answerWallFormSubmitImg".$key."\" style=\"vertical-align:middle;\" border=\"0\" />Skicka</a></nobr></span></div></p>
<br><br></form>";
			}


		}
	} else {
	$body .= "<i>Ingen har skrivit på din vägg än :(</i>";
	}
		$body.= "
<table width=\"100%\" border=\"0\" style=\" border-top: 1px dotted #c8c8c8;margin-top:3px;margin-bottom:0px;\"><tr><td></td></tr></table>";


 	if ($_GET["w"] == "full") {
$body.= "\n
<div id=\"showLatestMonth\" onMouseOver=\"document.showLatest.src='" . $baseUrl . "/img/symbols/gif_red/handelser.gif'\" onMouseOut=\"document.showLatest.src='" . $baseUrl . "/img/symbols/gif_purple/handelser.gif'\" style=\"text-transform: none;font-size:12px;float:right;\"><nobr><a href=\"" . $baseUrl . "/user/".stripslashes($userPres["username"]).".html\" style=\"font-weight:normal;\" class=\"presLink\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/handelser.gif\" name=\"showLatest\" style=\"vertical-align:middle;\" border=\"0\" /> Visa 10 senaste</a></nobr></div>";
	} else {
$body.= "\n
<div id=\"showLatestMonth\" onMouseOver=\"document.showLatest.src='" . $baseUrl . "/img/symbols/gif_red/handelser.gif'\" onMouseOut=\"document.showLatest.src='" . $baseUrl . "/img/symbols/gif_purple/handelser.gif'\" style=\"text-transform: none;font-size:12px;float:right;\"><nobr><a href=\"" . $baseUrl . "/user/".stripslashes($userPres["username"]).".html?w=full\" style=\"font-weight:normal;\" class=\"presLink\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/handelser.gif\" name=\"showLatest\" style=\"vertical-align:middle;\" border=\"0\" /> Visa alla inlägg</a></nobr></div>";
	}

	
$body .= "<div style=\"clear:both;\"></div>
 <div id=\"writeWallBelow\" onMouseOver=\"document.writeWall2.src='" . $baseUrl . "/img/symbols/gif_red/annonser_erbjudanden.gif'\" onMouseOut=\"document.writeWall2.src='" . $baseUrl . "/img/symbols/gif_purple/annonser_erbjudanden.gif'\" style=\"text-transform: none;font-size:12px;float:right;\"><nobr><a href=\"#top\" style=\"font-weight:normal;\" onClick=\"document.getElementById('writeWallBelow').style.display='none';document.getElementById('wallFormBelow').style.display='block';return false\" class=\"presLink\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/annonser_erbjudanden.gif\" name=\"writeWall2\" style=\"vertical-align:middle;margin-bottom:2px;\" border=\"0\" /> Skriv på väggen</a></nobr></div>";
 $body .= "<div style=\"clear:both;\"></div>";
 
	$body.= "<form id=\"wallFormBelow\" method=\"post\" style=\"margin: 0px; padding: 0px; display: none\" name=\"form2\">
<input type=\"hidden\" name=\"type\" value=\"wall\">
<p>Skriv meddelande:<br /><div style=\"float: left; margin-bottom: 20px\"><textarea name=\"message\" style=\"height: 40px; width: 370px;\"></textarea></div></p>

<p><div style=\"display:block; float: right; margin-right: 11px\"><span onMouseOver=\"document.writeGuestbook.src='" . $baseUrl . "/img/symbols/gif_red/skicka.gif'\" onMouseOut=\"document.writeGuestbook.src='" . $baseUrl . "/img/symbols/gif_purple/skicka.gif'\"><nobr><a href=\"#noexist\" onClick=\"document.form2.submit();\"><img src=\"" . $baseUrl . "/img/symbols/gif_purple/skicka.gif\" name=\"writeGuestbook\" style=\"vertical-align:middle;\" border=\"0\" />Skicka</a></nobr></span></div></p>
<br><br></form><br><br>";
	$body.= "</div>

</div>

</div><div id=\"right\">";
if ( $editPresentation == TRUE )
{
	$body.= rightMenu('presentation');
}
else
{
	$body.= rightMenu('userPresentation');
}
$body.= "</div>";

}
?>