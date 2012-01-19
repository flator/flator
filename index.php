<?php
session_start(); 
 
include( "config.php" ); 

/* Process file being requested */
if ( strlen( $_GET["file"] ) > 0 )
{
	$page = $_GET["file"];
}
else
{
	$page = "default";
}
/* Save fake querystring as if it was a real one */
if ( eregi( "\?", $_SERVER["REQUEST_URI"] ) )
{
	list( $trash, $vars ) = split( "\?", $_SERVER["REQUEST_URI"] );
	if ( strlen( $vars ) > 0 )
	{
		$varArr = explode( "&", $vars );
		if ( count( $varArr ) > 0 )
		{
			while ( list( $key, $value ) = each ( $varArr ) )
			{
				list( $varName, $varVal ) = split( "=", $value );
				$_GET[ $varName ] = $varVal;
			}
		}
	}
}
#print_r($_SESSION);
if ( $_SESSION["userId"] > 0 && $page == "default" )
{
	$page = "frontpage.html";
}

switch ( $page )
{
	/*case "default":
		if ( DEBUG_MODE == TRUE ) $showAdmin = TRUE;
		$loadAjax = TRUE;
		include( "_index.php" );
	
	break;	
	*/
		case "default":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsReload = TRUE;
		$publicMenu = TRUE;
		if ( (int)$_SESSION["userId"] < 1 ) {
		$loginUrl = $baseUrl . "/";
		include( "_newstart.php" );
		} else {
		redirect($baseUrl ."/");
		}
		break;
	case "crazy.html":
		if ( DEBUG_MODE == TRUE ) $showAdmin = TRUE;
		$loadAjax = TRUE;
		include( "_index.php" );
	
	break;	
	case "invite_videochat.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsReload = TRUE;
		$publicMenu = TRUE;
		if ( (int)$_SESSION["userId"] < 1 || $_GET["user"] == "" ) {
		$loginUrl = $baseUrl . "/";
		include( "_newstart.php" );
		} else {
			
			if ($_GET["user"] != "") {

				$q = "SELECT * FROM fl_users WHERE username = '" . addslashes($_GET["user"]) . "'";
				$invitedUser = $DB->GetRow( $q, FALSE, TRUE );
				if ((int)$invitedUser["id"] > 0) {
					$record["insDate"] = date("Y-m-d H:i:s");
					$record["invitingUser"] = (int)$_SESSION["userId"];
					$record["invitedUser"] = $invitedUser["id"];
					$DB->AutoExecute( "fl_videochat_invitations", $record, 'INSERT');
					$_SESSION["invitationSent"] = TRUE;
					$_SESSION["invitationStatus"] = "Din inbjudan till videochatten har skickats! Videochatten öppnas nu! <br /><strong>Om inget fönster har öppnats kontrollera så att din webbläsare inte blockerar popup-fönster och försök igen.</strong><br />Ha fönstret öppet så länge som du orkar vänta på att ".$_GET["user"]." skall logga in på chatten. Observera att personen kanske inte är inne på Flator.se just nu eller kanske inte vill ha en videochatt just nu.";
					redirect($baseUrl ."/user/".$_GET["user"].".html");
				} else {
					$_SESSION["invitationSent"] = FALSE;
					$_SESSION["invitationStatus"] = "Din inbjudan till videochatten kunde inte skickas, kontrollera så att användaren är inloggad!";
					redirect($baseUrl ."/user/".$_GET["user"].".html");

				}
				

			} else {
					$_SESSION["invitationSent"] = FALSE;
					$_SESSION["invitationStatus"] = "Din inbjudan till videochatten kunde inte skickas, kontrollera så att användaren är inloggad!";
					redirect($baseUrl ."/presentation.html");

			}



					}
		break;
	case "oldstart.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsReload = TRUE;
		$publicMenu = TRUE;
		if ( (int)$_SESSION["userId"] < 1 ) {
		$loginUrl = $baseUrl . "/";
		include( "_newstart.php" );
		} else {
		redirect($baseUrl ."/");
		}
		break;	
	case "admin.html":
		$adminFooter = FALSE;
		$adminMenu = TRUE;
		include( "_admin.php" );
		break;
	case "admin_users.html":
		$adminFooter = TRUE;
		$adminMenu = TRUE;
		$loadPopup = TRUE;
		include( "_admin_users.php" );
		break;
	case "admin_approve.html":
		$adminFooter = TRUE;
		$adminMenu = TRUE;
		$loadPopup = TRUE;
		$jsCheckAll = TRUE;
		$jsCheckbox = TRUE;
		include( "_admin_approve.php" );
		break;
	case "admin_add_user.html":
		$adminFooter = TRUE;
		$noLogo = TRUE;
		include( "_admin_add_user.php" );
		break;
	case "admin_edit_user.html":
		$adminFooter = TRUE;
		$noLogo = TRUE;
		include( "_admin_edit_user.php" );
		break;
	case "admin_edit_poll.html":
		$adminFooter = TRUE;
		$noLogo = TRUE;
		include( "_admin_edit_poll.php" );
		break;
	case "admin_add_poll.html":
		$adminFooter = TRUE;
		$noLogo = TRUE;
		include( "_admin_add_poll.php" );
		break;
	case "admin_poll_result.html":
		$adminFooter = TRUE;
		$noLogo = TRUE;
		include( "_admin_poll_result.php" );
		break;
	case "admin_delete_user.html":
		$adminFooter = TRUE;
		$noLogo = TRUE;
		include( "_admin_delete_user.php" );
		break;
	case "admin_invite.html":
		$adminFooter = TRUE;
		$adminMenu = TRUE;
		$loadPopup = TRUE;
		$loadAjax = TRUE;
		$loadSelect = TRUE;
		include( "_admin_invite.php" );
		break;
	case "admin_invite_template.html":
		$adminFooter = TRUE;
		$noLogo = TRUE;
		$tinyMceFull = TRUE;
		$templateType = "invite";
		include( "_admin_template.php" );
		break;
	case "admin_template.html":
		$adminFooter = TRUE;
		$noLogo = TRUE;
		$tinyMceFull = TRUE;
		include( "_admin_template.php" );
		break;
	case "admin_delete_template.html":
		$adminFooter = TRUE;
		$noLogo = TRUE;
		include( "_admin_delete_template.php" );
		break;
	case "admin_newsletter.html":
		$adminFooter = TRUE;
		$adminMenu = TRUE;
		$loadPopup = TRUE;
		$loadAjax = TRUE;
		$loadSelect = TRUE;
		include( "_admin_newsletter.php" );
		break;
	case "admin_newsletter_template.html":
		$adminFooter = TRUE;
		$noLogo = TRUE;
		$tinyMceFull = TRUE;
		$templateType = "newsletter";
		include( "_admin_template.php" );
		break;
	case "admin_suggestions.html":
		$adminFooter = TRUE;
		$adminMenu = TRUE;
		include( "_admin_suggestions.php" );
		break;
	case "admin_delete_suggestion.html":
		$adminFooter = TRUE;
		$noLogo = TRUE;
		include( "_admin_delete_suggestion.php" );
		break;
	case "admin_templates.html":
		$adminFooter = TRUE;
		$adminMenu = TRUE;
		$loadPopup = TRUE;
		$loadAjax = TRUE;
		$loadSelect = TRUE;
		include( "_admin_templates.php" );
		break;
	case "admin_events.html":
		$adminFooter = TRUE;
		$adminMenu = TRUE;
		$loadPopup = TRUE;
		$loadAjax = TRUE;
		$loadSelect = TRUE;
		include( "_admin_events.php" );
		break;
	case "admin_shouts.html":
		$adminFooter = TRUE;
		$adminMenu = TRUE;
		$loadPopup = TRUE;
		$loadAjax = TRUE;
		$loadSelect = TRUE;
		include( "_admin_shouts.php" );
		break;
	case "admin_polls.html":
		$adminFooter = TRUE;
		$adminMenu = TRUE;
		$loadPopup = TRUE;
		$loadAjax = TRUE;
		$loadSelect = TRUE;
		include( "_admin_polls.php" );
		break;
	case "admin_approve_public_event.html":
		$adminFooter = TRUE;
		$noLogo = TRUE;
		include( "_admin_approve_public_event.php" );
		break;
	case "admin_deny_public_event.html":
		$adminFooter = TRUE;
		$noLogo = TRUE;
		include( "_admin_deny_public_event.php" );
		break;
	case "admin_delete_event.html":
		$adminFooter = TRUE;
		$noLogo = TRUE;
		include( "_admin_delete_event.php" );
		break;
	case "admin_edit_event.html":
		$adminFooter = TRUE;
		$noLogo = TRUE;
		$tinyMceFull = TRUE;
		$jsZapatec = TRUE;
		$metaTitle = "Flator.se > Redigera event";
		include( "_admin_edit_event.php" );
		break;
	case "admin_add_event.html":
		$adminFooter = TRUE;
		$noLogo = TRUE;
		$tinyMceFull = TRUE;
		$jsZapatec = TRUE;
		$metaTitle = "Flator.se > L&auml;gg till event";
		include( "_admin_edit_event.php" );
		break;

	case "admin_delete_shout.html":
		$adminFooter = TRUE;
		$noLogo = TRUE;
		include( "_admin_delete_shout.php" );
		break;
	case "admin_edit_shout.html":
		$adminFooter = TRUE;
		$noLogo = TRUE;
		$tinyMceFull = TRUE;
		$jsZapatec = TRUE;
		$metaTitle = "Flator.se > Redigera nyhet";
		include( "_admin_edit_shout.php" );
		break;
	case "admin_add_shout.html":
		$adminFooter = TRUE;
		$noLogo = TRUE;
		$tinyMceFull = TRUE;
		$jsZapatec = TRUE;
		$metaTitle = "Flator.se > L&auml;gg till nyhet";
		include( "_admin_edit_shout.php" );
		break;
	case "logout.html":
		if ( isset( $_COOKIE[ session_name() ] ) )
		{
			setcookie(session_name(), '', time()-42000, '/');
		}
		session_destroy();
		header("Location: " . $baseUrl . "/" );
		break;
	case "register.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsReload = TRUE;
		$publicMenu = TRUE;
		include( "_register.php" );
		break;
	case "confirm_email.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsReload = TRUE;
		$publicMenu = TRUE;
		include( "_confirm_email.php" );
		break;
	case "member_terms.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsReload = TRUE;
		$publicMenu = TRUE;
		include( "_member_terms.php" );
		break;
	case "reset_password.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsReload = TRUE;
		$publicMenu = TRUE;
		include( "_reset_password.php" );
		break;
	case "new_password.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsReload = TRUE;
		$publicMenu = TRUE;
		include( "_new_password.php" );
		break;
	case "contact.html":
		$newCss = TRUE;
		$memberMenu = TRUE;
		$loadAjax = TRUE;
		$menuPadding = TRUE;
		include( "_contact.php" );
		break;
	case "frontpage.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsReload = TRUE;
		$memberMenu = TRUE;
		$menuFrontpage = TRUE;
		if ( $_POST["type"] == "statusComment" && (int)$_POST["statusId"] > 0  && strlen($_POST["comment"]) > 0 && $_SESSION["demo"] != TRUE )
			{
					$record = array();
					$record["insDate"] = date("Y-m-d H:i:s");
					$record["userId"] = $userProfile["id"];
					$record["type"] = 'statusComment';
					$record["contentId"] = (int)$_POST["statusId"];
					$record["comment"] = addslashes($_POST["comment"]);
					$DB->AutoExecute( "fl_comments", $record, 'INSERT' );
			}

		if ( $_POST["type"] == "photoComment" && (int)$_POST["statusId"] > 0  && strlen($_POST["comment"]) > 0 && $_SESSION["demo"] != TRUE  )
		{
				$record = array();
				$record["insDate"] = date("Y-m-d H:i:s");
				$record["userId"] = $userProfile["id"];
				$record["type"] = 'photoComment';
				$record["contentId"] = (int)$_POST["statusId"];
				$record["comment"] = addslashes($_POST["comment"]);
				$DB->AutoExecute( "fl_comments", $record, 'INSERT' );
				
				$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_images WHERE id = '" . (int)$_POST["statusId"] . "'";
				$commentedPhoto = $DB->GetRow( $q, FALSE, TRUE );

				$record = array();
				$record["insDate"] = date("Y-m-d H:i:s");
				$record["userid"] = (int)$userProfile["id"];
				if (strlen($_POST["comment"])> 25) $_POST["comment"] = substr($_POST["comment"],0,25)." ...";
				$record["statusMessage"] = "Kommenterade foto: <a href=\"http://www.flator.se/media/photos/".(int)$_POST["photoId"].".html\">".addslashes($_POST["comment"])."</a>";
				$record["mostRecent"] = "NO";
				$record["statusType"] = "photoComment";
				$record["private"] = "NO";
				$DB->AutoExecute( "fl_status", $record, 'INSERT');
				
				if ($commentedPhoto["userId"] != $userProfile["id"]) {
				$record = array();
				$record["insDate"] = date("Y-m-d H:i:s");
				$record["userid"] = $commentedPhoto["userId"];
				if (strlen($_POST["comment"])> 25) $_POST["comment"] = substr($_POST["comment"],0,25)." ...";
				$record["statusMessage"] = "<a href=\"http://www.flator.se/user/".$userProfile["username"].".html\">".$userProfile["username"]."</a> kommenterade ett av dina fotografier: <a href=\"http://www.flator.se/media/photos/".(int)$_POST["photoId"].".html\">".addslashes($_POST["comment"])."</a>";
				$record["mostRecent"] = "NO";
				$record["statusType"] = "photoComment";
				$record["private"] = "YES";
				$DB->AutoExecute( "fl_status", $record, 'INSERT');
				}

		}

			if ( $_POST["type"] == "reportAll"  && $_SESSION["demo"] != TRUE )
				{
						$record = array();
						$record["insDate"] = date("Y-m-d H:i:s");
						$record["userId"] = $userProfile["id"];
						$record["reportType"] = addslashes( $_POST["content"] );
						$record["reportId"] = 0;
						$record["reason"] = addslashes( $_POST["comment"] );

						$DB->AutoExecute( "fl_reports", $record, 'INSERT' ); 
						$tmpMessage = "Rapport för innehåll: <a href=\"".$_POST["url"]."\">".$_POST["content"]."</a> med anledning:\n".$_POST["comment"];
						sendMail( "info@flator.se", "crew@flator.se", "Flator.se", "Rapport från medlem på Flator.se", $tmpMessage );


						$thankoyu = "<li>Rapporten har skickats in!</li>\n";


				}
if ($_POST["type"] == "inviteBox") {
	$i2 = 0;
	$i = 1;
	while ( $i2 < 3) {
	
	if (( $_POST["inviteMail".$i] != "") && ( eregi( "^[_a-z0-9-]+(.*)@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST["inviteMail".$i] ) )) {


		$configuration = array();
		$q = "SELECT * FROM fl_configuration";
		$row = $DB->GetAssoc( $q, FALSE, TRUE );
		if ( count( $row ) > 0 )
		{
			while ( list( $key, $value ) = each( $row ) )
			{
				$configuration[ $row[ $key ]["type"] ] = $row[ $key ]["value"];
			}
		}



			$q = "SELECT * FROM fl_templates WHERE id = " . (int)$configuration["newInvitedFriend"];
			$row = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $row ) > 0 )
			{
				$message = $row["content"];
				$subject = $row["subject"];
				if ( strlen( $subject ) < 1 )
				{
					$subject = "Flator.se - Inbjuden av en vän";
				}
				$tmpMessage = $message;
				// Send email
				sendMail( $_POST["inviteMail".$i], "agneta@flator.se", "Flator.se Crew", $subject, $tmpMessage );

				$record = array();
				$record["insDate"] = date( "Y-m-d H:i:s" );
				$record["emailType"] = "invitation";
				$record["recipientUserId"] = 0;
				$record["email"] = addslashes( $_POST["inviteMail".$i] );
				$record["message"] = $tmpMessage;
				$DB->AutoExecute("fl_email_log", $record, 'INSERT');
			}



}
$i2++;
	$i++;

	}
}
		include( "_frontpage.php" );
		break;
	case "crew_communication.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsReload = TRUE;
		$memberMenu = TRUE;
		$menuFrontpage = TRUE;
		include( "_crew_communication.php" );
		break;
	case "deleteUser.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsReload = TRUE;
		$memberMenu = TRUE;
		$menuFrontpage = TRUE;
		
			if ( $_POST["type"] == "deleteAccount" && $_POST["confirmDelete"] == 'YES' )
				{
				
						$record = array();
						$record["insDate"] = date("Y-m-d H:i:s");
						$record["userId"] = (int)$userProfile["id"];
						$record["oldName"] = $userProfile["username"];
						$record["deletedUser"] = "YES";
						$DB->AutoExecute( "fl_username_changes", $record, 'INSERT'); 

						$q = "DELETE FROM fl_users WHERE id = " . (int)$userProfile["id"];
						$DB->Execute( $q );

						$q = "DELETE FROM fl_albums WHERE userId = " . (int)$userProfile["id"];
						$DB->Execute( $q );

						$q = "DELETE FROM fl_blog WHERE userId = " . (int)$userProfile["id"];
						$DB->Execute( $q );

						$q = "DELETE FROM fl_comments WHERE userId = " . (int)$userProfile["id"];
						$DB->Execute( $q );

						$q = "DELETE FROM fl_flirts WHERE senderUserId = " . (int)$userProfile["id"];
						$DB->Execute( $q );

						$q = "DELETE FROM fl_flirts WHERE recipientUserId = " . (int)$userProfile["id"];
						$DB->Execute( $q );

						$q = "DELETE FROM fl_friends WHERE friendUserId = " . (int)$userProfile["id"];
						$DB->Execute( $q );

						$q = "DELETE FROM fl_friends WHERE userId = " . (int)$userProfile["id"];
						$DB->Execute( $q );

						$q = "DELETE FROM fl_guestbook WHERE userId = " . (int)$userProfile["id"];
						$DB->Execute( $q );

						$q = "DELETE FROM fl_images WHERE userId = " . (int)$userProfile["id"];
						$DB->Execute( $q );

						$q = "DELETE FROM fl_visitors WHERE userId = " . (int)$userProfile["id"];
						$DB->Execute( $q );

						$q = "DELETE FROM fl_visitors WHERE visitorUserId = " . (int)$userProfile["id"];
						$DB->Execute( $q );

						$q = "DELETE FROM fl_email_log WHERE recipientUserId = " . (int)$userProfile["id"];
						$DB->Execute( $q );

						$q = "DELETE FROM fl_login_log WHERE userId = " . (int)$userProfile["id"];
						$DB->Execute( $q );


						if ( isset( $_COOKIE[ session_name() ] ) )
						{
							setcookie(session_name(), '', time()-42000, '/');
						}
						session_destroy();
						header("Location: " . $baseUrl . "/" );
						break;						
					
				}
		include( "_deleteUser.php" );
		break;
	case "my_invitations.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsReload = TRUE;
		$memberMenu = TRUE;
		$menuFrontpage = TRUE;
		include( "_my_invitations.php" );
		break;
	case "flirts.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsReload = TRUE;
		$memberMenu = TRUE;
		$menuFrontpage = TRUE;
		
		if ( $_GET["do"] == "deleteFlirt" && (int)$_GET["flirtId"] > 0  && $_SESSION["demo"] != TRUE )
		{
				$DB->_Execute( "DELETE FROM fl_flirts where id = ".(int)$_GET["flirtId"]." AND recipientUserId = ".(int)$userProfile["id"]."  limit 1" );
		}
		
		include( "_flirts.php" );
		break;
	case "events.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsReload = TRUE;
		$memberMenu = TRUE;
		$menuEvents = TRUE;
		include( "_events.php" );
		break;
	case "restaurants.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsReload = TRUE;
		$memberMenu = TRUE;
		$menuEvents = TRUE;
		include( "_restaurants.php" );
		break;
	case "my_events.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsReload = TRUE;
		$memberMenu = TRUE;
		$menuEvents = TRUE;
		$divPopup = TRUE;
		include( "_my_events.php" );
		break;
	case "friends_events.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsReload = TRUE;
		$memberMenu = TRUE;
		$menuEvents = TRUE;
		include( "_friends_events.php" );
		break;
	case "search.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsReload = TRUE;
		$memberMenu = TRUE;
		$menuSearch = TRUE;
		include( "_search.php" );
		break;
	case "forum.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsConfirmSubmit = TRUE;
		$jsForum = TRUE;
		$divPopup = TRUE;
		$memberMenu = TRUE;
		$menuFrontpage = TRUE;
		$menuForum = TRUE;
		require_once('parser.php'); // path to Recruiting Parsers' file
		$parser = new parser; //  start up Recruiting Parsers

		$q = "SELECT * from fl_forum_cat ORDER BY id ASC";
		$forumCats = $DB->GetAssoc( $q, FALSE, TRUE );

		$q = "SELECT shortname, id, name from fl_forum_cat ORDER BY id ASC";
		$forumCatSlug = $DB->GetAssoc( $q, FALSE, TRUE );


		include( "_forum.php" );
		break;
	case "forum_cat.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsConfirmSubmit = TRUE;
		$jsForum = TRUE;
		$divPopup = TRUE;
		$memberMenu = TRUE;
		$menuFrontpage = TRUE;
		$menuForum = TRUE;
		require_once('parser.php'); // path to Recruiting Parsers' file
		$parser = new parser; //  start up Recruiting Parsers
		
		$q = "SELECT * from fl_forum_cat ORDER BY id ASC";
		$forumCats = $DB->GetAssoc( $q, FALSE, TRUE );

		$q = "SELECT shortname, id, name from fl_forum_cat ORDER BY id ASC";
		$forumCatSlug = $DB->GetAssoc( $q, FALSE, TRUE );
		
		if ($_GET["thread"] != "") {
			$q = "SELECT headline FROM fl_forum_threads WHERE slug = '" . addslashes($_GET["thread"]) . "' AND newThread = 'YES' LIMIT 1";
			$threadRow = $DB->GetRow( $q, FALSE, TRUE );
			$threadSubject = $threadRow[0];


		}

		include( "_forum_cat.php" );
		break;
	case "inbox.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsConfirmSubmit = TRUE;
		$memberMenu = TRUE;
		$menuMyPages = TRUE;
		$menuMessages = TRUE;
		$menuInbox = TRUE;
		include( "_inbox.php" );
		break;
	case "outbox.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsConfirmSubmit = TRUE;
		$memberMenu = TRUE;
		$menuMyPages = TRUE;
		$menuMessages = TRUE;
		$menuOutbox = TRUE;
		include( "_outbox.php" );
		break;
	case "maria.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
#		$memberMenu = TRUE;
		include( "_maria.php" );
		break;
	case "invite.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsReload = TRUE;
		$publicMenu = TRUE;
		include( "_invite.php" );
		break;
	case "new_message.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
#		$tinyMce = TRUE;
		$memberMenu = TRUE;
		$menuMyPages = TRUE;
		$menuMessages = TRUE;
		$menuNewMessage = TRUE;
		include( "_new_message.php" );
		break;
	case "message.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
#		$tinyMce = TRUE;
		$memberMenu = TRUE;
		$menuMyPages = TRUE;
		$menuMessages = TRUE;
		$menuReadMessage = TRUE;

		if ( (int)$_SESSION["userId"] > 0 )
		{
			// Fetch message
			$q = "SELECT fl_messages.*, fl_users.username, UNIX_TIMESTAMP( fl_messages.insDate ) AS unixTime FROM fl_messages LEFT JOIN fl_users ON fl_users.id = fl_messages.userId WHERE ((fl_messages.userId = " . (int)$_SESSION["userId"] . " AND fl_messages.senderDeleted = 'NO') OR (fl_messages.recipentUserId = " . (int)$_SESSION["userId"] . " AND fl_messages.deleted = 'NO')) AND fl_messages.id = " . (int)$_GET["messageId"];
#echo $q;
			$message = $DB->GetRow( $q, FALSE, TRUE );
			if ( strlen( $message["subject"] ) > 0 )
			{
				$messageSubject = strip_tags( stripslashes( $message["subject"] ) );
				if ( strlen( $messageSubject ) > 40 )
				{
					$messageSubject = substr( $messageSubject, 0, 37 ) . "...";
				}
			}
			else
			{
				// Not allowed to read message
				$messageSubject = "Kunde inte &ouml;ppnas";
				$message = array();
			}
		}

		include( "_message.php" );
		break;
	case "konv.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
#		$tinyMce = TRUE;
		$memberMenu = TRUE;
		$menuMyPages = TRUE;
		$menuMessages = TRUE;
		$menuReadMessage = TRUE;

		if ( (int)$_SESSION["userId"] > 0 )
		{

			if ( strlen( $_GET["username"] ) > 0 && $_GET["username"] != $userProfile["username"] && strlen( $userProfile["username"] ) > 0 )
			{
				$q = "SELECT * FROM fl_users WHERE username = '" . addslashes( $_GET["username"] ) . "' AND rights > 1";
				$userKonv = $DB->GetRow( $q, FALSE, TRUE );
				if ( (int)$userKonv["id"] > 0 )
				{


			// Fetch message
			$q = "SELECT fl_messages.*, fl_users.username, UNIX_TIMESTAMP( fl_messages.insDate ) AS unixTime FROM fl_messages LEFT JOIN fl_users ON fl_users.id = fl_messages.userId WHERE ((fl_messages.userId = " . (int)$_SESSION["userId"] . " AND fl_messages.senderDeleted = 'NO' AND fl_messages.recipentUserId = " . (int)$userKonv["id"].") OR (fl_messages.recipentUserId = " . (int)$_SESSION["userId"] . " AND fl_messages.deleted = 'NO' AND fl_messages.userId = " . (int)$userKonv["id"].")) ORDER BY ID DESC LIMIT 1";
#echo $q;
			$message = $DB->GetRow( $q, FALSE, TRUE );
			if ( strlen( $message["subject"] ) > 0 )
			{
				$messageSubject = strip_tags( stripslashes( $message["subject"] ) );
				if ( strlen( $messageSubject ) > 40 )
				{
					$messageSubject = substr( $messageSubject, 0, 37 ) . "...";
				}
			}

		}
			}
		}

		include( "_konv.php" );
		break;
	case "delete_message.html":
		$newCss = TRUE;
		$noLogo = TRUE;
		include( "_delete_message.php" );
		break;
	case "my_account.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
#		$tinyMce = TRUE;
		$memberMenu = TRUE;
		#$menuMyPages = TRUE;
		$menuFrontpage = TRUE;
		$divPopup = TRUE;
		$menuAccount = TRUE;


		if ( (int)$_SESSION["rights"] > 1 )
		{


			if ( $_POST["type"] == "editAccount"  && $_SESSION["demo"] != TRUE )
			{
			
					$record = array();
					if (strlen($_POST["firstName"]) > 0) {
					$record["firstName"] = addslashes($_POST["firstName"]); }
					if (strlen($_POST["lastName"]) > 0) {
					$record["lastName"] = addslashes($_POST["lastName"]); }

					if (strlen($_POST["newUsername"]) > 0) {
						if ( !eregi( "^([_a-z0-9-])+$", $_POST["newUsername"] ) || strlen( $_POST["newUsername"] ) > 16 )
						{
							$message.= "<li><b>Anv&auml;ndarnamnet</b> f&aring;r endast inneh&aring;lla bokst&auml;ver, siffror, _ och -. Dessutom f&aring;r anv&auml;ndarnamnet inte vara l&auml;ngre &auml;n 16 tecken.</li>";
						} else {
							if ($userProfile["username"] != $_POST["newUsername"]) {

								$q = "SELECT * FROM fl_users WHERE username = '" . addslashes($_POST["newUsername"]) . "'";
								$checkUserExists = $DB->GetRow( $q, FALSE, TRUE );
								if ( (int)$checkUserExists["id"] > 0 )
								{

								} else {

									$record["username"] = $_POST["newUsername"]; 	
									$record2["insDate"] = date( "Y-m-d H:i:s" ); 
									$record2["userId"] = (int)$userProfile["id"]; 
									$record2["oldName"] = $userProfile["username"]; 
									$record2["newName"] = $_POST["newUsername"];
									$DB->AutoExecute( "fl_username_changes", $record2, 'INSERT' ); 
								}
							}
						}
					}
					
					if (strlen($_POST["newPass"]) > 0) {

							$record["password"] = sha1( $_POST["newPass"]); 
							
					}
					$record["cityId"] = addslashes($_POST["city_id"]);
					$record["relationship"] = addslashes($_POST["relationship"]);
					$record["lookingFor"] = addslashes($_POST["lookingFor"]);
					$record["videoChat"] = addslashes($_POST["videoChat"]);
					$record["attitude"] = addslashes($_POST["attitude"]);
					$record["hobby"] = addslashes($_POST["hobby"]);
					$record["housing"] = addslashes($_POST["housing"]);
					$record["politics"] = addslashes($_POST["politics"]);
					$record["hair"] = addslashes($_POST["hair"]);
					$record["drinks"] = addslashes($_POST["drinks"]);
					$record["sexlife"] = addslashes($_POST["sexlife"]);
					$record["presText"] = addslashes(nl2br($_POST["presText"]));
					
					
					$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = '.(int)$userProfile["id"] ); 
					
					$q = "SELECT * FROM fl_users WHERE id = " . (int)$_SESSION["userId"];
					$userProfile = $DB->GetRow( $q, FALSE, TRUE );

					$thankoyu = "<li>Inställningarna har redigerats, ser allt rätt ut?</li>\n";



					if ( $_POST["email"] != $userProfile["email"]) {
						$configuration = array();
						$q = "SELECT * FROM fl_configuration";
						$row = $DB->GetAssoc( $q, FALSE, TRUE );
						if ( count( $row ) > 0 )
						{
							while ( list( $key, $value ) = each( $row ) )
							{
								$configuration[ $row[ $key ]["type"] ] = $row[ $key ]["value"];
							}
						}
						
						$tmpCode = randCode( 15 );
						$verificationCode = substr( $tmpCode, 0, 5 ) . "-" . substr( $tmpCode, 4, 5 ) . "-" . substr( $tmpCode, 9, 5 );
						

						$q = "SELECT * FROM fl_templates WHERE id = " . (int)$configuration["confirmEmailChange"];
						$row = $DB->GetRow( $q, FALSE, TRUE );
						if ( count( $row ) > 0 )
						{
							$message = $row["content"];
							$subject = $row["subject"];
							if ( strlen( $subject ) < 1 )
							{
								$subject = "Flator.se - Bekräfta e-postadress";
							}
							$tmpMessage = $message;
							$tmpMessage = str_replace( "{verificationCode}", $verificationCode, $tmpMessage );
							// Send email
							sendMail( $_POST["email"], "info@flator.se", "Flator.se Crew", $subject, $tmpMessage );

							$record = array();
							$record["insDate"] = date( "Y-m-d H:i:s" );
							$record["emailType"] = "confirm";
							$record["recipientUserId"] = (int)$_SESSION["userId"];
							$record["email"] = addslashes( $_POST["email"] );
							$record["message"] = $tmpMessage;
							$DB->AutoExecute("fl_email_log", $record, 'INSERT');


							$record = array();
							$record["newEmail"] = addslashes($_POST["email"]);
							$record["verificationCode"] = $verificationCode;
							$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = '.(int)$userProfile["id"] );
							$thankoyu .= "<li>För att ändringen av e-postadress skall genomföras måste du klicka på länken i det bekräftelsemail som nu har skickats till dig.</li>\n";
						}
					}
					

		


					


				
				$_POST = array();
			}
		}






		include( "_my_account.php" );
		break;
	case "videochat.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
#		$tinyMce = TRUE;
		$memberMenu = TRUE;
		#$menuMyPages = TRUE;
		$menuFrontpage = TRUE;
		$divPopup = TRUE;
		$menuVideoChat = TRUE;
		include( "_videochat.php" );
		break;
	case "report.html":
		$newCss = TRUE;
		$noLogo = TRUE;
		include( "_report.php" );
		break;
	case "presentation.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsConfirmSubmit = TRUE;
		$memberMenu = TRUE;
#		$tinyMce = TRUE;
		$divPopup = TRUE;

		unset( $editPresentation );
		if ( strlen( $_GET["username"] ) > 0 && $_GET["username"] != $userProfile["username"] && strlen( $userProfile["username"] ) > 0 )
		{
			$q = "SELECT * FROM fl_users WHERE username = '" . addslashes( $_GET["username"] ) . "' AND rights > 1";
			$userPres = $DB->GetRow( $q, FALSE, TRUE );
			if ( (int)$userPres["id"] > 0 )
			{
				$menuUser = "" . stripslashes( $_GET["username"] );
				$menuUserPresentation = TRUE;
				$metaTitle = "Flator.se - " . $menuUser;

				$doInclude = TRUE;
			}
			else
			{
				$body = "<h2>404: Det finns ingen anv&auml;ndare med detta namn.</h2>\n";
			}
		}
		else
		{
			$userPres = $userProfile;
			$metaTitle = "Flator.se - Presentation";
			$menuMyPages = TRUE;
			$menuPresentation = TRUE;
			$editPresentation = TRUE;
			if ( $editPresentation == TRUE && $_SESSION["demo"] != TRUE  )
			{
				$record = array();
				$record["readByOwner"] = 'YES';
				$DB->AutoExecute( "fl_guestbook", $record, 'UPDATE', 'recipentUserId = '.$userProfile["id"] );
			}
			$doInclude = TRUE;
		}

		if ( $_POST["type"] == "statusComment" && (int)$_POST["statusId"] > 0  && strlen($_POST["comment"]) > 0  && $_SESSION["demo"] != TRUE )
		{
				$record = array();
				$record["insDate"] = date("Y-m-d H:i:s");
				$record["userId"] = $userProfile["id"];
				$record["type"] = 'statusComment';
				$record["contentId"] = (int)$_POST["statusId"];
				$record["comment"] = addslashes($_POST["comment"]);
				$DB->AutoExecute( "fl_comments", $record, 'INSERT' );
		}

				if ( $_POST["type"] == "photoComment" && (int)$_POST["statusId"] > 0  && strlen($_POST["comment"]) > 0  && $_SESSION["demo"] != TRUE )
		{
				$record = array();
				$record["insDate"] = date("Y-m-d H:i:s");
				$record["userId"] = $userProfile["id"];
				$record["type"] = 'photoComment';
				$record["contentId"] = (int)$_POST["statusId"];
				$record["comment"] = addslashes($_POST["comment"]);
				$DB->AutoExecute( "fl_comments", $record, 'INSERT' );

				$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_images WHERE id = '" . (int)$_POST["statusId"] . "'";
				$commentedPhoto = $DB->GetRow( $q, FALSE, TRUE );

				$record = array();
				$record["insDate"] = date("Y-m-d H:i:s");
				$record["userid"] = (int)$userProfile["id"];
				if (strlen($_POST["comment"])> 25) $_POST["comment"] = substr($_POST["comment"],0,25)." ...";
				$record["statusMessage"] = "Kommenterade foto: <a href=\"http://www.flator.se/media/photos/".(int)$_POST["photoId"].".html\">".addslashes($_POST["comment"])."</a>";
				$record["mostRecent"] = "NO";
				$record["statusType"] = "photoComment";
				$record["private"] = "NO";
				$DB->AutoExecute( "fl_status", $record, 'INSERT');
				
				if ($commentedPhoto["userId"] != $userProfile["id"]) {
				$record = array();
				$record["insDate"] = date("Y-m-d H:i:s");
				$record["userid"] = $commentedPhoto["userId"];
				if (strlen($_POST["comment"])> 25) $_POST["comment"] = substr($_POST["comment"],0,25)." ...";
				$record["statusMessage"] = "<a href=\"http://www.flator.se/user/".$userProfile["username"].".html\">".$userProfile["username"]."</a> kommenterade ett av dina fotografier: <a href=\"http://www.flator.se/media/photos/".(int)$_POST["photoId"].".html\">".addslashes($_POST["comment"])."</a>";
				$record["mostRecent"] = "NO";
				$record["statusType"] = "photoComment";
				$record["private"] = "YES";
				$DB->AutoExecute( "fl_status", $record, 'INSERT');
				}
		}

		if ( $_GET["do"] == "deleteWall" && (int)$_GET["wallId"] > 0  && $_SESSION["demo"] != TRUE )
		{
				$DB->_Execute( "DELETE FROM fl_guestbook where id = ".(int)$_GET["wallId"]." AND ( userId = ".(int)$userProfile["id"]." OR recipentUserId = ".(int)$userProfile["id"]." )  limit 1" );
		}
		
		if ( $_GET["do"] == "deleteHistory" && (int)$_GET["statusId"] > 0  && $_SESSION["demo"] != TRUE )
		{
				$DB->_Execute( "DELETE FROM fl_status where id = ".(int)$_GET["statusId"]." and userId = ".(int)$userProfile["id"]." limit 1" );
		}

				if ( $_GET["do"] == "deleteStatusComment" && (int)$_GET["statusId"] > 0  && $_SESSION["demo"] != TRUE )
		{
				$DB->_Execute( "DELETE FROM fl_comments where id = ".(int)$_GET["statusId"]." limit 1" );
		}


		if ($doInclude == TRUE) {
		include( "_presentation.php" );
		}
		break;
	case "blog.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsConfirmSubmit = TRUE;
		$memberMenu = TRUE;
#		$tinyMce = TRUE;
		$divPopup = TRUE;

		unset( $editPresentation );
		if ( strlen( $_GET["username"] ) > 0 && $_GET["username"] != $userProfile["username"] && strlen( $userProfile["username"] ) > 0 )
		{
			$q = "SELECT * FROM fl_users WHERE username = '" . addslashes( $_GET["username"] ) . "' AND rights > 1";
			$userPres = $DB->GetRow( $q, FALSE, TRUE );
			if ( (int)$userPres["id"] > 0 )
			{
				$menuUser = "" . stripslashes( $_GET["username"] );
				$menuUserBlog = TRUE;
				$metaTitle = "Flator.se - " . $menuUser;
				$doInclude = TRUE;
			}
			else
			{
				$body = "<h2>404: Det finns ingen anv&auml;ndare med detta namn.</h2>\n";
			}
		}
		elseif ( (int)$_GET["postId"] > 0)
		{
			$q = "SELECT *, UNIX_TIMESTAMP(insDate) FROM fl_blog WHERE id = '" . (int)$_GET["postId"] . "'";
			$currentPost = $DB->GetRow( $q, FALSE, TRUE );

			$q = "SELECT * FROM fl_users WHERE id = '" . (int)$currentPost["userId"] . "'";
			$userPres = $DB->GetRow( $q, FALSE, TRUE );
			if ( (int)$userPres["id"] > 0 )
			{
				if ($userPres["username"] != $userProfile["username"] && strlen( $userProfile["username"] ) > 0) {


				$_GET["username"] = $userPres["username"];
				$menuUser = "" . stripslashes( $userPres["username"] );
				$menuUserBlog = TRUE;
				$metaTitle = "Flator.se - Blogg - " . $menuUser;
				$doInclude = TRUE;
				} else {
					$userPres = $userProfile;
					$metaTitle = "Flator.se - Blog";
					$menuMyPages = TRUE;
					$menuBlog = TRUE;
					$editBlog = TRUE;
					$doInclude = TRUE;
				}
			}
			else
			{
				$body = "<h2>404: Det finns ingen anv&auml;ndare med detta namn.</h2>\n";
			}
		}
		else
		{
			$userPres = $userProfile;
			$metaTitle = "Flator.se - Blog";
			$menuMyPages = TRUE;
			$menuBlog = TRUE;
			$editBlog = TRUE;
			$doInclude = TRUE;
		}

		if ($editBlog == TRUE && $_SESSION["demo"] != TRUE ) {
				
			if ( (int)$_SESSION["rights"] > 1 )
			{


				if ( $_POST["type"] == "writeBlog" && strlen($_POST["content"]) > 0 )
				{
				
						$record = array();
						$record["insDate"] = date("Y-m-d H:i:s");
						$record["userid"] = (int)$userProfile["id"];
						$record["subject"] = addslashes($_POST["subject"]);
						$record["content"] = addslashes(nl2br($_POST["content"]));
						
						
						$DB->AutoExecute( "fl_blog", $record, 'INSERT'); 
						
						
						$record = array();
						$record["insDate"] = date("Y-m-d H:i:s");
						$record["userid"] = (int)$userProfile["id"];
						$record["statusMessage"] = "Nytt blogginlägg: <a href=\"http://www.flator.se/blogs/".$userProfile["username"].".html\">".addslashes($_POST["subject"])."</a>";
						$record["mostRecent"] = "NO";
						$record["statusType"] = "blogEntry";
						$DB->AutoExecute( "fl_status", $record, 'INSERT'); 

						$_POST = array();
						
					
				}
				
				if ( $_POST["type"] == "editBlog" && (int)$_POST["id"] > 0)
				{
				
						$record = array();
						
						$record["subject"] = addslashes($_POST["subject"]);
						$record["content"] = addslashes(nl2br($_POST["content"]));
						
						
						$DB->AutoExecute( "fl_blog", $record, 'UPDATE', 'id = '.(int)$_POST["id"]." and userid = ".(int)$userProfile["id"]); 
						$_POST = array();
						
					
				}
				if ( $_GET["do"] == "deleteBlog" && (int)$_GET["id"] > 0 )
				{
						$DB->_Execute( "DELETE FROM fl_blog where id = ".(int)$_GET["id"]." and userId = ".(int)$userProfile["id"]." limit 1" );
						$DB->_Execute( "DELETE FROM fl_blog_photos where blogPostId = ".(int)$_GET["id"]."" );
						redirect($baseUrl ."/blogs/".$userPres["username"].".html");
			
						
					
				}
				
				if ( $_GET["do"] == "removeBlogPhoto" && (int)$_GET["blogPost"] > 0 && (int)$_GET["photo"] > 0 )
				{
						$DB->_Execute( "DELETE FROM fl_blog_photos where blogPostId = ".(int)$_GET["blogPost"]." AND photoId = ".(int)$_GET["photo"]."" );
						redirect($baseUrl ."/blogs/".$userPres["username"].".html");
			
						
					
				}
			}
		} else {
		$record = array();
		$record["blogVisits"] = ($userPres["blogVisits"] + 1);
		$DB->AutoExecute( "fl_users", $record, 'UPDATE', 'id = '.(int)$userPres["id"] );
		}
		if ($doInclude == TRUE) {
			include( "_blog.php" );
		}
		break;
	case "friends.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsConfirmSubmit = TRUE;
		$jsCheckAll = TRUE;
		$jsCheckbox = TRUE;
		$memberMenu = TRUE;

		unset( $editFriends );
		if ( strlen( $_GET["username"] ) > 0 && $_GET["username"] != $userProfile["username"] && strlen( $userProfile["username"] ) > 0 )
		{
			$q = "SELECT * FROM fl_users WHERE username = '" . addslashes( $_GET["username"] ) . "' AND rights > 1";
			$userPres = $DB->GetRow( $q, FALSE, TRUE );
			if ( (int)$userPres["id"] > 0 )
			{
				$menuUser = "" . stripslashes( $_GET["username"] );
				$menuUserFriends = TRUE;
				$menuUserAllFriends = TRUE;
				$metaTitle = "Flator.se - " . $menuUser . " - Vänner";
			}
			else
			{
				$body = "<h2>404: Det finns ingen anv&auml;ndare med detta namn.</h2>\n";
			}
		}
		else
		{
			$userPres = $userProfile;
			$menuMyPages = TRUE;
			$menuFriends = TRUE;
			$menuAllFriends = TRUE;
			$editFriends = TRUE;
		}
		include( "_friends.php" );
		break;
	case "friends_online.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsConfirmSubmit = TRUE;
		$jsCheckAll = TRUE;
		$jsCheckbox = TRUE;
		$memberMenu = TRUE;

		unset( $editFriends );
		if ( strlen( $_GET["username"] ) > 0 && $_GET["username"] != $userProfile["username"] && strlen( $userProfile["username"] ) > 0 )
		{
			$q = "SELECT * FROM fl_users WHERE username = '" . addslashes( $_GET["username"] ) . "' AND rights > 1";
			$userPres = $DB->GetRow( $q, FALSE, TRUE );
			if ( (int)$userPres["id"] > 0 )
			{
				$menuUser = "" . stripslashes( $_GET["username"] );
				$menuUserFriends = TRUE;
				$menuUserOnlineFriends = TRUE;
				$metaTitle = "Flator.se - " . $menuUser . " - Vänner";
			}
			else
			{
				$body = "<h2>404: Det finns ingen anv&auml;ndare med detta namn.</h2>\n";
			}
		}
		else
		{
			$userPres = $userProfile;
			$menuMyPages = TRUE;
			$menuFriends = TRUE;
			$menuOnlineFriends = TRUE;
			$editFriends = TRUE;
		}
		include( "_friends.php" );
		break;
	case "friends_updated.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsConfirmSubmit = TRUE;
		$jsCheckAll = TRUE;
		$jsCheckbox = TRUE;
		$memberMenu = TRUE;

		unset( $editFriends );
		if ( strlen( $_GET["username"] ) > 0 && $_GET["username"] != $userProfile["username"] && strlen( $userProfile["username"] ) > 0 )
		{
			$q = "SELECT * FROM fl_users WHERE username = '" . addslashes( $_GET["username"] ) . "' AND rights > 1";
			$userPres = $DB->GetRow( $q, FALSE, TRUE );
			if ( (int)$userPres["id"] > 0 )
			{
				$menuUser = "" . stripslashes( $_GET["username"] );
				$menuUserFriends = TRUE;
				$menuUserUpdatedFriends = TRUE;
				$metaTitle = "Flator.se - " . $menuUser . " - Vänner";
			}
			else
			{
				$body = "<h2>404: Det finns ingen anv&auml;ndare med detta namn.</h2>\n";
			}
		}
		else
		{
			$userPres = $userProfile;
			$menuMyPages = TRUE;
			$menuFriends = TRUE;
			$menuUpdatedFriends = TRUE;
			$editFriends = TRUE;
		}
		include( "_friends.php" );
		break;
	case "friends_common.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsConfirmSubmit = TRUE;
		$jsCheckAll = TRUE;
		$jsCheckbox = TRUE;
		$memberMenu = TRUE;

			$q = "SELECT * FROM fl_users WHERE username = '" . addslashes( $_GET["username"] ) . "' AND rights > 1";
			$userPres = $DB->GetRow( $q, FALSE, TRUE );
			if ( (int)$userPres["id"] > 0 )
			{
				$menuUser = "" . stripslashes( $_GET["username"] );
				$menuUserFriends = TRUE;
				$menuUserCommonFriends = TRUE;
				$metaTitle = "Flator.se - " . $menuUser . " - Vänner";
			}
			else
			{
				$body = "<h2>404: Det finns ingen anv&auml;ndare med detta namn.</h2>\n";
			}

		include( "_friends.php" );
		break;
	case "delete_friends.html":
		$newCss = TRUE;
		$noLogo = TRUE;
		include( "_delete_friends.php" );
		break;

	case "approve_friends.html":
		$newCss = TRUE;
		$noLogo = TRUE;
		include( "_approve_friends.php" );
		break;
	case "media.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsConfirmSubmit = TRUE;
		$jsCheckbox = TRUE;
		$memberMenu = TRUE;
		$divPopup = TRUE;
		$jsMultiUpload = TRUE;

		unset( $editMedia );
		if ( strlen( $_GET["username"] ) > 0 && $_GET["username"] != $userProfile["username"] && strlen( $userProfile["username"] ) > 0 )
		{
			$q = "SELECT * FROM fl_users WHERE username = '" . addslashes( $_GET["username"] ) . "' AND rights > 1";
			$userPres = $DB->GetRow( $q, FALSE, TRUE );
			if ( (int)$userPres["id"] > 0 )
			{
				$menuUser = "" . stripslashes( $_GET["username"] );
				$menuMedia = TRUE;
				$metaTitle = "Flator.se - " . $menuUser . " - Bilder/album";
			}
			else
			{
				$body = "<h2>404: Det finns ingen anv&auml;ndare med detta namn.</h2>\n";
			}
		}
		else
		{
			$userPres = $userProfile;
			$menuMyPages = TRUE;
			$menuMedia = TRUE;
			$editMedia = TRUE;
			$metaTitle = "Flator.se - Mina sidor - Bilder/album";
				

		}
		if (( $_GET["do"] == "setParty" ) && ( (int)$_GET["albumId"] > 0 ) && ( (int)$_SESSION["rights"] > 5 )  && $_SESSION["demo"] != TRUE )
				{
						
						$DB->_Execute( "UPDATE fl_albums SET partyAlbum = 'YES' where ID = ".(int)$_GET["albumId"]." limit 1" ); 

						
						
						$thankoyu = "<li>Albumet är nu festalbum.</li>\n";
						redirect($baseUrl ."/media.html");





				}

				if (( $_GET["do"] == "stopParty" ) && ( (int)$_GET["albumId"] > 0 ) && ( (int)$_SESSION["rights"] > 5 ) && $_SESSION["demo"] != TRUE )
				{
						
						$DB->_Execute( "UPDATE fl_albums SET partyAlbum = 'NO' where ID = ".(int)$_GET["albumId"]." limit 1" ); 

						
						
						$thankoyu = "<li>Albumet är nu inte längre ett festalbum.</li>\n";
						redirect($baseUrl ."/media.html");





				}
								if (( $_GET["do"] == "setClub" ) && ( (int)$_GET["albumId"] > 0 ) && ( (int)$_SESSION["rights"] > 5 ) && $_SESSION["demo"] != TRUE )
				{
						
						$DB->_Execute( "UPDATE fl_albums SET clubAlbum = 'YES' where ID = ".(int)$_GET["albumId"]." limit 1" ); 

						
						
						$thankoyu = "<li>Albumet är nu festalbum.</li>\n";
						redirect($baseUrl ."/media.html");





				}

				if (( $_GET["do"] == "stopClub" ) && ( (int)$_GET["albumId"] > 0 ) && ( (int)$_SESSION["rights"] > 5 ) && $_SESSION["demo"] != TRUE )
				{
						
						$DB->_Execute( "UPDATE fl_albums SET clubAlbum = 'NO' where ID = ".(int)$_GET["albumId"]." limit 1" ); 

						
						
						$thankoyu = "<li>Albumet är nu inte längre ett festalbum.</li>\n";
						redirect($baseUrl ."/media.html");





				}
		include( "_media.php" );
		break;

case "album_topplista.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsConfirmSubmit = TRUE;
		$jsCheckbox = TRUE;
		$memberMenu = TRUE;
		$menuFrontpage = TRUE;
		$divPopup = TRUE;
		$menuToplists = TRUE;
		unset( $editMedia );
		$userPres = $userProfile;
		include( "_album_topplista.php" );
break;

case "album_senaste.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsConfirmSubmit = TRUE;
		$jsCheckbox = TRUE;
		$memberMenu = TRUE;
		$menuFrontpage = TRUE;
		$divPopup = TRUE;
		$menuToplists = TRUE;
		unset( $editMedia );
		$userPres = $userProfile;
		include( "_album_senaste.php" );
break;

case "top_forum_users.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsConfirmSubmit = TRUE;
		$jsCheckbox = TRUE;
		$memberMenu = TRUE;
		$menuFrontpage = TRUE;
		$divPopup = TRUE;
		$menuToplists = TRUE;
		unset( $editMedia );
		$userPres = $userProfile;
		include( "_top_forum_users.php" );
break;
case "top_forum_threads.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsConfirmSubmit = TRUE;
		$jsCheckbox = TRUE;
		$memberMenu = TRUE;
		$menuFrontpage = TRUE;
		$divPopup = TRUE;
		$menuToplists = TRUE;
		unset( $editMedia );
		$userPres = $userProfile;
		include( "_top_forum_threads.php" );
break;
case "senaste_forumtradar.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsConfirmSubmit = TRUE;
		$jsCheckbox = TRUE;
		$memberMenu = TRUE;
		$menuFrontpage = TRUE;
		$divPopup = TRUE;
		$menuToplists = TRUE;
		unset( $editMedia );
		$userPres = $userProfile;
		include( "_senaste_forumtradar.php" );
break;

case "blogg_topplista.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsConfirmSubmit = TRUE;
		$jsCheckbox = TRUE;
		$memberMenu = TRUE;
		$menuFrontpage = TRUE;
		$divPopup = TRUE;
		$menuToplists = TRUE;
		unset( $editMedia );
		$userPres = $userProfile;
		include( "_blogg_topplista.php" );
break;

case "blogg_senaste.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsConfirmSubmit = TRUE;
		$jsCheckbox = TRUE;
		$memberMenu = TRUE;
		$menuFrontpage = TRUE;
		$divPopup = TRUE;
		$menuToplists = TRUE;
		unset( $editMedia );
		$userPres = $userProfile;
		include( "_blogg_senaste.php" );
break;

case "nya_medlemmar.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsConfirmSubmit = TRUE;
		$jsCheckbox = TRUE;
		$memberMenu = TRUE;
		$menuFrontpage = TRUE;
		$divPopup = TRUE;
		$menuToplists = TRUE;
		unset( $editMedia );
		$userPres = $userProfile;
		include( "_nya_medlemmar.php" );
break;

case "nya_bilder.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsConfirmSubmit = TRUE;
		$jsCheckbox = TRUE;
		$memberMenu = TRUE;
		$menuFrontpage = TRUE;
		$divPopup = TRUE;
		$menuToplists = TRUE;
		unset( $editMedia );
		$userPres = $userProfile;
		include( "_nya_bilder.php" );
break;

case "nya_videos.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsConfirmSubmit = TRUE;
		$jsCheckbox = TRUE;
		$memberMenu = TRUE;
		$menuFrontpage = TRUE;
		$divPopup = TRUE;
		$menuToplists = TRUE;
		unset( $editMedia );
		$userPres = $userProfile;
		include( "_nya_videos.php" );
break;

	case "club_media.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsConfirmSubmit = TRUE;
		$jsCheckbox = TRUE;
		$memberMenu = TRUE;
		$divPopup = TRUE;

		unset( $editMedia );
		
	
		
			$userPres = $userProfile;
			
			$menuClubMedia = TRUE;
			
				if (( $_GET["do"] == "setClub" ) && ( (int)$_GET["albumId"] > 0 ) && ( (int)$_SESSION["rights"] > 5 ) && $_SESSION["demo"] != TRUE )
				{
						
						$DB->_Execute( "UPDATE fl_albums SET clubAlbum = 'YES' where ID = ".(int)$_GET["albumId"]." limit 1" ); 

						
						
						$thankoyu = "<li>Albumet är nu festalbum.</li>\n";
						redirect($baseUrl ."/club_media.html");





				}

				if (( $_GET["do"] == "stopClub" ) && ( (int)$_GET["albumId"] > 0 ) && ( (int)$_SESSION["rights"] > 5 ) && $_SESSION["demo"] != TRUE )
				{
						
						$DB->_Execute( "UPDATE fl_albums SET clubAlbum = 'NO' where ID = ".(int)$_GET["albumId"]." limit 1" ); 

						
						
						$thankoyu = "<li>Albumet är nu inte längre ett festalbum.</li>\n";
						redirect($baseUrl ."/club_media.html");





				}

		
		include( "_club_media.php" );
		break;

		
	case "private_media.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsConfirmSubmit = TRUE;
		$jsCheckbox = TRUE;
		$memberMenu = TRUE;
		$divPopup = TRUE;

		unset( $editMedia );
		
	
		
			$userPres = $userProfile;
			
			$menuClubMedia = TRUE;
			
				if (( $_GET["do"] == "setParty" ) && ( (int)$_GET["albumId"] > 0 ) && ( (int)$_SESSION["rights"] > 5 ) && $_SESSION["demo"] != TRUE )
				{
						
						$DB->_Execute( "UPDATE fl_albums SET partyAlbum = 'YES' where ID = ".(int)$_GET["albumId"]." limit 1" ); 

						
						
						$thankoyu = "<li>Albumet är nu festalbum.</li>\n";
						redirect($baseUrl ."/private_media.html");





				}

				if (( $_GET["do"] == "stopParty" ) && ( (int)$_GET["albumId"] > 0 ) && ( (int)$_SESSION["rights"] > 5 ) && $_SESSION["demo"] != TRUE )
				{
						
						$DB->_Execute( "UPDATE fl_albums SET partyAlbum = 'NO' where ID = ".(int)$_GET["albumId"]." limit 1" ); 

						
						
						$thankoyu = "<li>Albumet är nu inte längre ett festalbum.</li>\n";
						redirect($baseUrl ."/private_media.html");





				}

		
		include( "_private_media.php" );
		break;
	case "delete_albums.html":
		$newCss = TRUE;
		$noLogo = TRUE;
		include( "_delete_albums.php" );
		break;

		case "album.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsConfirmSubmit = TRUE;
		$jsCheckbox = TRUE;
		$memberMenu = TRUE;
		$jsMultiUpload = TRUE;

		$divPopup = TRUE;
		unset( $editMedia );
		

		if ( strlen( $_GET["albumId"] ) > 0 )
		{
		$q = "SELECT * FROM fl_albums WHERE id = '" . addslashes( $_GET["albumId"] ) . "'";
		$currentAlbum = $DB->GetRow( $q, FALSE, TRUE );
		$record = array();
		$record["noViews"] = ($currentAlbum["noViews"] + 1);
		$DB->AutoExecute( "fl_albums", $record, 'UPDATE', 'id = '.(int)$currentAlbum["id"] ); 
		$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_images WHERE albumId = '" . addslashes( $_GET["albumId"] ) . "' AND imageType IN ('albumPhoto', 'albumVideo') ORDER BY insDate DESC LIMIT 1";
		$currentPhoto = $DB->GetRow( $q, FALSE, TRUE );
		if (strlen($currentAlbum["id"]) > 0) {

			if ($currentAlbum["userId"] != $userProfile["id"]) {
				$q = "SELECT * FROM fl_users WHERE id = '" . addslashes( $currentAlbum["userId"] ) . "' AND rights > 1";
				$userPres = $DB->GetRow( $q, FALSE, TRUE );
				if ( (int)$userPres["id"] > 0 )
				{
				//Album is not users own
				$menuUser = "" . stripslashes( $userPres["username"] );
				$menuMedia = TRUE;
				
				$menuViewAlbum = TRUE;
				$metaTitle = "Flator.se - " . $menuUser . " - Bilder/album";
				$_GET["username"] = stripslashes( $userPres["username"] );
				} else {
				$body = "<h2>404: Användaren som albumet tillhör verkar ha försvunnit.</h2>\n";

				}

				if ($_SESSION["rights"] > 5) {

						if ( $_POST["type"] == "editPhoto"  && $_SESSION["demo"] != TRUE )
						{
								$record = array();
								$record["name"] = addslashes($_POST["name"]);
								$record["description"] = addslashes( $_POST["description"] );
								$DB->AutoExecute( "fl_images", $record, 'UPDATE', 'id = '.(int)$_POST["photoId"] ); 
								$_POST = array();
								$thankoyu = "<li>Fotografiet <b>" . $_POST["name"] . "</b> har redigerats.</li>\n";
						}


						
						if (( $_GET["do"] == "deletePhoto" ) && ( (int)$currentPhoto["id"] > 0 ) && $_SESSION["demo"] != TRUE )
						{
								unlink($currentPhoto["serverLocation"]);
								if ($currentPhoto["videoLocation"] != "") {
									unlink($currentPhoto["videoLocation"]);
								}
								$DB->_Execute( "DELETE FROM fl_images where ID = ".(int)$currentPhoto["id"]." limit 1" ); 

								$q = "SELECT * FROM fl_albums WHERE id = " . $currentPhoto["albumId"];
								$album_update_aiid = $DB->GetRow( $q, FALSE );
								if (($album_update_aiid["album_image_id"] == 0) || ($album_update_aiid["album_image_id"] == (int)$currentPhoto["id"])) {

									$q = "SELECT * FROM fl_images WHERE albumId = " . $currentPhoto["albumId"]." AND imageType IN ('albumPhoto', 'albumVideo') order by id desc limit 1";
									$image_update_aiid = $DB->GetRow( $q, FALSE );
									if ((int)$image_update_aiid["id"] > 0) {
										$record["album_image_id"] = $image_update_aiid["id"];
										$DB->AutoExecute( "fl_albums", $record, 'UPDATE', 'id = '.$currentPhoto["albumId"] ); 
									}

								}
								
								$thankoyu = "<li>Fotografiet har raderats.</li>\n";
								redirect($baseUrl ."/media/album/".$currentPhoto["albumId"].".html");




						}
			
				}

			} else {
				//Album belongs to current user
				$userPres = $userProfile;
				$menuMyPages = TRUE;
				$menuMedia = TRUE;
				$editMedia = TRUE;
				$menuViewAlbum = TRUE;
				$metaTitle = "Flator.se - Mina sidor - Bilder/album";

				if ( $_POST["type"] == "editPhoto"  && $_SESSION["demo"] != TRUE )
				{
						$record = array();
						$record["name"] = addslashes($_POST["name"]);
						$record["description"] = addslashes( $_POST["description"] );
						$DB->AutoExecute( "fl_images", $record, 'UPDATE', 'id = '.(int)$_POST["photoId"] ); 
						$_POST = array();
						$thankoyu = "<li>Fotografiet <b>" . $_POST["name"] . "</b> har redigerats.</li>\n";
				}


				
				if (( $_GET["do"] == "deletePhoto" ) && ( (int)$currentPhoto["id"] > 0 ) && $_SESSION["demo"] != TRUE )
				{
						unlink($currentPhoto["serverLocation"]);
								if ($currentPhoto["videoLocation"] != "") {
									unlink($currentPhoto["videoLocation"]);
								}
						$DB->_Execute( "DELETE FROM fl_images where ID = ".(int)$currentPhoto["id"]." limit 1" ); 

						$q = "SELECT * FROM fl_albums WHERE id = " . $currentPhoto["albumId"];
						$album_update_aiid = $DB->GetRow( $q, FALSE );
						if (($album_update_aiid["album_image_id"] == 0) || ($album_update_aiid["album_image_id"] == (int)$currentPhoto["id"])) {

							$q = "SELECT * FROM fl_images WHERE albumId = " . $currentPhoto["albumId"]." AND imageType IN ('albumPhoto', 'albumVideo') order by id desc limit 1";
							$image_update_aiid = $DB->GetRow( $q, FALSE );
							if ((int)$image_update_aiid["id"] > 0) {
								$record["album_image_id"] = $image_update_aiid["id"];
								$DB->AutoExecute( "fl_albums", $record, 'UPDATE', 'id = '.$currentPhoto["albumId"] ); 
							}

						}
						
						$thankoyu = "<li>Fotografiet har raderats.</li>\n";
						redirect($baseUrl ."/media/album/".$currentPhoto["albumId"].".html");




				}
				if (( $_GET["do"] == "setThumb" ) && ( (int)$currentPhoto["id"] > 0 ) && $_SESSION["demo"] != TRUE )
				{
						
						$DB->_Execute( "UPDATE fl_albums SET album_image_id = ".(int)$currentPhoto["id"]." where ID = ".(int)$currentPhoto["albumId"]." limit 1" ); 

						
						
						$thankoyu = "<li>Fotografiet har gjorts till thumbnail.</li>\n";
						redirect($baseUrl ."/media/photos/".$currentPhoto["id"].".html");




				}
				

				

			}
				if ( $_POST["type"] == "commentPhoto"  && $_SESSION["demo"] != TRUE )
				{
						$record = array();
						$record["insDate"] = date("Y-m-d H:i:s");
						$record["userId"] = $userProfile["id"];
						$record["type"] = "photoComment";
						$record["contentId"] = (int)$_POST["photoId"];
						$record["comment"] = addslashes( $_POST["comment"] );

						$DB->AutoExecute( "fl_comments", $record, 'INSERT' ); 
						
						$record = array();
						$record["insDate"] = date("Y-m-d H:i:s");
						$record["userid"] = (int)$userProfile["id"];
						if (strlen($_POST["comment"])> 25) $_POST["comment"] = substr($_POST["comment"],0,25)." ...";
						$record["statusMessage"] = "Kommenterade foto: <a href=\"http://www.flator.se/media/photos/".(int)$_POST["photoId"].".html\">".addslashes($_POST["comment"])."</a>";
						$record["mostRecent"] = "NO";
						$record["statusType"] = "photoComment";
						$record["private"] = "NO";
						$DB->AutoExecute( "fl_status", $record, 'INSERT');
						
						if ($userPres["id"] != $userProfile["id"]) {
						$record = array();
						$record["insDate"] = date("Y-m-d H:i:s");
						$record["userid"] = (int)$userPres["id"];
						if (strlen($_POST["comment"])> 25) $_POST["comment"] = substr($_POST["comment"],0,25)." ...";
						$record["statusMessage"] = "<a href=\"http://www.flator.se/user/".$userProfile["username"].".html\">".$userProfile["username"]."</a> kommenterade ett av dina fotografier: <a href=\"http://www.flator.se/media/photos/".(int)$_POST["photoId"].".html\">".addslashes($_POST["comment"])."</a>";
						$record["mostRecent"] = "NO";
						$record["statusType"] = "photoComment";
						$record["private"] = "YES";
						$DB->AutoExecute( "fl_status", $record, 'INSERT');
						}


						$_POST = array();
						$thankoyu = "<li>Kommentaren har sparats.</li>\n";


				}
				if ( $_POST["type"] == "reportPhoto"  && $_SESSION["demo"] != TRUE )
				{
						$record = array();
						$record["insDate"] = date("Y-m-d H:i:s");
						$record["userId"] = $userProfile["id"];
						$record["reportType"] = "photo";
						$record["reportId"] = (int)$_POST["photoId"];
						$record["reason"] = addslashes( $_POST["comment"] );

						$DB->AutoExecute( "fl_reports", $record, 'INSERT' ); 
						$tmpMessage = "Rapport för fotografi ID: <a href=\"http://www.flator.se/media/photos/".(int)$_POST["photoId"].".html\">".(int)$_POST["photoId"]."</a> med anledning:\n".$_POST["comment"];
						sendMail( "c.oberg@gmail.com", "crew@flator.se", "Flator.se", "Rapport från medlem på Flator.se", $tmpMessage );


						$thankoyu = "<li>Rapporten har skickats in!</li>\n";


				}
						if ( $_POST["type"] == "addToBlog"  && $_SESSION["demo"] != TRUE )
				{
						$record = array();
						$record["insDate"] = date("Y-m-d H:i:s");
						$record["blogPostId"] = (int)$_POST["blogPost"];
						$record["photoId"] = (int)$_POST["photoId"];

						$DB->AutoExecute( "fl_blog_photos", $record, 'INSERT' ); 
						$_POST = array();
						$thankoyu = "<center><b>Fotografiet är nu kopplat till ditt blogginlägg!<br><br></b></center>\n";
				}
								if ( $_POST["type"] == "addToChallenge"  && $_SESSION["demo"] != TRUE )
				{
						$record = array();
						$record["insDate"] = date("Y-m-d H:i:s");
						$record["challengeId"] = (int)$_POST["challengeId"];
						$record["userId"] = (int)$userPres["id"];
						$record["mediaId"] = (int)$_POST["mediaId"];

						$DB->AutoExecute( "fl_challenge_participants", $record, 'INSERT' ); 
						$_POST = array();
						$thankoyu = "<center><b>Bilden är nu anmäld till tävlingen<br><br></b></center>\n";
				}
		} else {
				$body = "<h2>404: Det finns inget album med detta ID.</h2>\n";

		}

		} else {
				$body = "<h2>404: Ett album måste anges.</h2>\n";

		}


		include( "_album.php" );
		break;
		case "photos.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$jsConfirmSubmit = TRUE;
		$jsCheckbox = TRUE;
		$memberMenu = TRUE;
		$divPopup = TRUE;
		$jsMultiUpload = TRUE;
		unset( $editMedia );
				




		if ( strlen( $_GET["photoId"] ) > 0 )
		{
		$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_images WHERE id = '" . addslashes( $_GET["photoId"] ) . "'";
		$currentPhoto = $DB->GetRow( $q, FALSE, TRUE );
		if (strlen($currentPhoto["id"]) > 0) {
		$record = array();
		$record["noViews"] = ($currentPhoto["noViews"] + 1);
		$DB->AutoExecute( "fl_images", $record, 'UPDATE', 'id = '.(int)$currentPhoto["id"] ); 

		$q = "SELECT * FROM fl_albums WHERE id = '" . addslashes( $currentPhoto["albumId"] ) . "'";
		$currentAlbum = $DB->GetRow( $q, FALSE, TRUE );

		$record = array();
		$record["noViews"] = ($currentAlbum["noViews"] + 1);
		$DB->AutoExecute( "fl_albums", $record, 'UPDATE', 'id = '.(int)$currentAlbum["id"] );

			if ($currentPhoto["userId"] != $userProfile["id"]) {
				$q = "SELECT * FROM fl_users WHERE id = '" . addslashes( $currentPhoto["userId"] ) . "' AND rights > 1";
				$userPres = $DB->GetRow( $q, FALSE, TRUE );
				if ( (int)$userPres["id"] > 0 )
				{
				//Photo is not users own
				$menuUser = "" . stripslashes( $userPres["username"] );
				$menuMedia = TRUE;
				$metaTitle = "Flator.se - " . $menuUser . " - Bilder";
				$menuViewAlbum = TRUE;
				$_GET["username"] = stripslashes( $userPres["username"] );
				} else {
				$body = "<h2>404: Användaren som albumet tillhör verkar ha försvunnit.</h2>\n";

				}

				if ($_SESSION["rights"] > 5) {

						if ( $_POST["type"] == "editPhoto"  && $_SESSION["demo"] != TRUE )
						{
								$record = array();
								$record["name"] = addslashes($_POST["name"]);
								$record["description"] = addslashes( $_POST["description"] );
								$DB->AutoExecute( "fl_images", $record, 'UPDATE', 'id = '.(int)$_POST["photoId"] ); 
								$_POST = array();
								$thankoyu = "<li>Fotografiet <b>" . $_POST["name"] . "</b> har redigerats.</li>\n";
						}


						
						if (( $_GET["do"] == "deletePhoto" ) && ( (int)$_GET["photoId"] > 0 ) && $_SESSION["demo"] != TRUE )
						{

							
								if ($currentPhoto["videoLocation"] != "") {
									unlink($currentPhoto["videoLocation"]);
								}
								unlink($currentPhoto["serverLocation"]);
								$DB->_Execute( "DELETE FROM fl_images where ID = ".(int)$_GET["photoId"]." limit 1" ); 

								$q = "SELECT * FROM fl_albums WHERE id = " . $currentPhoto["albumId"];
								$album_update_aiid = $DB->GetRow( $q, FALSE );
								if (($album_update_aiid["album_image_id"] == 0) || ($album_update_aiid["album_image_id"] == (int)$_GET["photoId"])) {

									$q = "SELECT * FROM fl_images WHERE albumId = " . $currentPhoto["albumId"]." AND imageType IN ('albumPhoto', 'albumVideo') order by id desc limit 1";
									$image_update_aiid = $DB->GetRow( $q, FALSE );
									if ((int)$image_update_aiid["id"] > 0) {
										$record["album_image_id"] = $image_update_aiid["id"];
										$DB->AutoExecute( "fl_albums", $record, 'UPDATE', 'id = '.$currentPhoto["albumId"] ); 
									}

								}
								
								$thankoyu = "<li>Fotografiet har raderats.</li>\n";
								redirect($baseUrl ."/media/album/".$currentPhoto["albumId"].".html");




						}
			
				}

			} else {
				//Photo belongs to current user
				$userPres = $userProfile;
				$menuMyPages = TRUE;
				$menuMedia = TRUE;
				$editMedia = TRUE;
				$menuViewAlbum = TRUE;
				$metaTitle = "Flator.se - Mina sidor - Bilder/album";

				if ( $_POST["type"] == "editPhoto"  && $_SESSION["demo"] != TRUE )
				{
						$record = array();
						$record["name"] = addslashes($_POST["name"]);
						$record["description"] = addslashes( $_POST["description"] );
						$DB->AutoExecute( "fl_images", $record, 'UPDATE', 'id = '.(int)$_POST["photoId"] ); 
						$_POST = array();
						$thankoyu = "<li>Fotografiet <b>" . $_POST["name"] . "</b> har redigerats.</li>\n";
				}

				if (( $_GET["do"] == "deletePhoto" ) && ( (int)$_GET["photoId"] > 0 ) && $_SESSION["demo"] != TRUE )
				{
						unlink($currentPhoto["serverLocation"]);
						
								if ($currentPhoto["videoLocation"] != "") {
									unlink($currentPhoto["videoLocation"]);
								}
						$DB->_Execute( "DELETE FROM fl_images where ID = ".(int)$_GET["photoId"]." limit 1" ); 

						$q = "SELECT * FROM fl_albums WHERE id = " . $currentPhoto["albumId"];
						$album_update_aiid = $DB->GetRow( $q, FALSE );
						if (($album_update_aiid["album_image_id"] == 0) || ($album_update_aiid["album_image_id"] == (int)$_GET["photoId"])) {

							$q = "SELECT * FROM fl_images WHERE albumId = " . $currentPhoto["albumId"]." AND imageType IN ('albumPhoto', 'albumVideo') order by id desc limit 1";
							$image_update_aiid = $DB->GetRow( $q, FALSE );
							if ((int)$image_update_aiid["id"] > 0) {
								$record["album_image_id"] = $image_update_aiid["id"];
								$DB->AutoExecute( "fl_albums", $record, 'UPDATE', 'id = '.$currentPhoto["albumId"] ); 
							}

						}
						
						$thankoyu = "<li>Fotografiet har raderats.</li>\n";
						redirect($baseUrl ."/media/album/".$currentPhoto["albumId"].".html");




				}
				if (( $_GET["do"] == "setThumb" ) && ( (int)$_GET["photoId"] > 0 ) && $_SESSION["demo"] != TRUE )
				{
						
						$DB->_Execute( "UPDATE fl_albums SET album_image_id = ".(int)$_GET["photoId"]." where ID = ".(int)$currentPhoto["albumId"]." limit 1" ); 

						
						
						$thankoyu = "<li>Fotografiet har gjorts till thumbnail.</li>\n";
						redirect($baseUrl ."/media/photos/".$currentPhoto["id"].".html");




				}
			}

				if ( $_POST["type"] == "commentPhoto"  && $_SESSION["demo"] != TRUE )
				{
						$record = array();
						$record["insDate"] = date("Y-m-d H:i:s");
						$record["userId"] = $userProfile["id"];
						$record["type"] = "photoComment";
						$record["contentId"] = (int)$_POST["photoId"];
						$record["comment"] = addslashes( $_POST["comment"] );

						$DB->AutoExecute( "fl_comments", $record, 'INSERT' ); 

						$record = array();
						$record["insDate"] = date("Y-m-d H:i:s");
						$record["userid"] = (int)$userProfile["id"];
						if (strlen($_POST["comment"])> 25) $_POST["comment"] = substr($_POST["comment"],0,25)." ...";
						$record["statusMessage"] = "Kommenterade foto: <a href=\"http://www.flator.se/media/photos/".(int)$_POST["photoId"].".html\">".addslashes($_POST["comment"])."</a>";
						$record["mostRecent"] = "NO";
						$record["statusType"] = "photoComment";
						$record["private"] = "NO";
						$DB->AutoExecute( "fl_status", $record, 'INSERT');
						
						if ($userPres["id"] != $userProfile["id"]) {
						$record = array();
						$record["insDate"] = date("Y-m-d H:i:s");
						$record["userid"] = (int)$userPres["id"];
						if (strlen($_POST["comment"])> 25) $_POST["comment"] = substr($_POST["comment"],0,25)." ...";
						$record["statusMessage"] = "<a href=\"http://www.flator.se/user/".$userProfile["username"].".html\">".$userProfile["username"]."</a> kommenterade ett av dina fotografier: <a href=\"http://www.flator.se/media/photos/".(int)$_POST["photoId"].".html\">".addslashes($_POST["comment"])."</a>";
						$record["mostRecent"] = "NO";
						$record["statusType"] = "photoComment";
						$record["private"] = "YES";
						$DB->AutoExecute( "fl_status", $record, 'INSERT');
						}



						$_POST = array();
						$thankoyu = "<li>Kommentaren har sparats.</li>\n";
				}
				if ( $_POST["type"] == "reportPhoto"  && $_SESSION["demo"] != TRUE )
				{
						$record = array();
						$record["insDate"] = date("Y-m-d H:i:s");
						$record["userId"] = $userProfile["id"];
						$record["reportType"] = "photo";
						$record["reportId"] = (int)$_POST["photoId"];
						$record["reason"] = addslashes( $_POST["comment"] );

						$DB->AutoExecute( "fl_reports", $record, 'INSERT' ); 
						$tmpMessage = "Rapport för fotografi ID: <a href=\"http://www.flator.se/media/photos/".(int)$_POST["photoId"].".html\">".(int)$_POST["photoId"]."</a> med anledning:\n".$_POST["comment"];
						sendMail( "c.oberg@gmail.com, crew@flator.se", "crew@flator.se", "Flator.se", "Rapport från medlem på Flator.se", $tmpMessage );


						$thankoyu = "<li>Rapporten har skickats in!</li>\n";


				}
				if ( $_POST["type"] == "addToBlog"  && $_SESSION["demo"] != TRUE )
				{
						$record = array();
						$record["insDate"] = date("Y-m-d H:i:s");
						$record["blogPostId"] = (int)$_POST["blogPost"];
						$record["photoId"] = (int)$_POST["photoId"];

						$DB->AutoExecute( "fl_blog_photos", $record, 'INSERT' ); 
						$_POST = array();
						$thankoyu = "<center><b>Fotografiet är nu kopplat till ditt blogginlägg!<br><br></b></center>\n";
				}
				if ( $_POST["type"] == "addToChallenge"  && $_SESSION["demo"] != TRUE )
				{
						$record = array();
						$record["insDate"] = date("Y-m-d H:i:s");
						$record["challengeId"] = (int)$_POST["challengeId"];
						$record["userId"] = (int)$userPres["id"];
						$record["mediaId"] = (int)$_POST["mediaId"];

						$DB->AutoExecute( "fl_challenge_participants", $record, 'INSERT' ); 
						$_POST = array();
						$thankoyu = "<center><b>Bilden är nu anmäld till tävlingen<br><br></b></center>\n";
				}

		} else {
				$body = "<h2>404: Det finns inget album med detta ID.</h2>\n";

		}

		} else {
				$body = "<h2>404: Ett album måste anges.</h2>\n";

		}


		include( "_photos.php" );
		break;
	case "visitors.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$memberMenu = TRUE;
		$menuMyPages = TRUE;
		$menuVisitors = TRUE;
		include( "_visitors.php" );
		break;
	case "notes.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
		$memberMenu = TRUE;
		$menuPadding = TRUE;
#		$menuMyPages = TRUE;
#		$menuVisitors = TRUE;
		include( "_notes.php" );
		break;
	case "design.html":
		$loadAjax = TRUE;
		$newCss = TRUE;
#		$jsReload = TRUE;
		$memberMenu = TRUE;
		include( "_design.php" );
		break;
	case "debug_mode.html":
		$_SESSION["debug"] = TRUE;
		header("Location: " . $baseUrl . "/" );
		break;
        
    /* @todo Remove case */
	case "enkat.html":
		$loadAjax = false;
		$newCss = TRUE;
		$jsReload = false;
		$memberMenu = false;
		$menuFrontpage = false;
		include( "_form_enkat.php" );
		break;
	default:
		$loadAjax = TRUE;
		$newCss = TRUE;
		if ( (int)$_SESSION["rights"] > 1 )
		{
			$memberMenu = TRUE;
		}
		else
		{
			$publicMenu = TRUE;
		}
		$body = "<h2>404: Sidan finns inte</h2>\n";
}

include( "header.php" );

include( "footer.php" );
?>
</body>
</html>